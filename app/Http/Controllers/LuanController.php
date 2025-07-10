<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class LuanController extends Controller
{
    public function createBookingService(Request $request)
    {
        if (!$request->headers->get('referer') || !str_contains($request->headers->get('referer'), route('bookingService.create'))) {
            session()->forget('selected_services');
        }
        $selectedServices = session('selected_services', []);
        if ($request->has('MaDichVu')) {
            $selectedServices = array_unique(array_merge($selectedServices, $request->input('MaDichVu')));
            session(['selected_services' => $selectedServices]);
        }
        $keyword = $request->input('keyword', '');
        $query = DB::table('DichVu');
        if ($keyword) {
            $query->where('TenDichVu', 'LIKE', '%' . $keyword . '%');
        }
        $currentPage = $request->input('page', 1);
        $perPage = 5;
        $total = $query->count();
        $totalPages = ceil($total / $perPage);
        $dichvus = $query->skip(($currentPage - 1) * $perPage)->take($perPage)->get();
        if ($request->ajax()) {
            $serviceListHTML = view('bookingservice.serviceList', compact('dichvus', 'selectedServices'))->render();
            $paginationHTML = view('bookingservice.pagination', compact('currentPage', 'totalPages'))->render();
            return response()->json([
                'serviceListHTML' => $serviceListHTML,
                'paginationHTML' => $paginationHTML,
            ]);
        }
        $thucungs = DB::table('ThuCung')->where('MaKhachHang', session('user_id'))->get();
        return view('booking_service', compact('dichvus', 'selectedServices', 'currentPage', 'totalPages', 'thucungs'));
    }

    public function saveSelectedServices(Request $request)
    {
        $currentServices = session('selected_services', []);
        $newServices = $request->input('selectedServices', []);
        $mergedServices = array_unique(array_merge($currentServices, $newServices));
        session(['selected_services' => $mergedServices]);
        return response()->json([
            'status' => 'success',
            'message' => 'Selected services updated successfully.',
            'data' => $mergedServices
        ]);
    }

    public function placeServiceBooking(Request $request)
    {
        $validated = $request->validate([
            'MaDichVu' => 'required|exists:DichVu,MaDichVu',
            'MaThuCung' => 'required|exists:ThuCung,MaThuCung',
            'Ngay' => 'required|date|after_or_equal:today',
            'Gio' => 'required',
        ]);
        try {
            $dichVu = DB::table('DichVu')->where('MaDichVu', $validated['MaDichVu'])->first();
            $thuCung = DB::table('ThuCung')->where('MaThuCung', $validated['MaThuCung'])->first();
            if (!$dichVu || !$thuCung) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Dịch vụ hoặc thú cưng không tồn tại.',
                ]);
            }
            $cart = session()->get('cart', []);
            $cart[] = [
                'id' => $validated['MaDichVu'],
                'name' => $dichVu->TenDichVu,
                'price' => $dichVu->DonGia,
                'quantity' => 1,
                'type' => 'service',
                'pet_id' => $thuCung->MaThuCung,
                'pet_name' => $thuCung->TenThuCung,
                'date' => $validated['Ngay'],
                'time' => $validated['Gio'],
            ];
            session()->put('cart', $cart);
            return response()->json([
                'status' => 'success',
                'message' => 'Dịch vụ đã được thêm vào giỏ hàng.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Đã xảy ra lỗi: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getSelectedServices()
    {
        $selectedServices = session('selected_services', []);
        return response()->json([
            'status' => 'success',
            'selectedServices' => $selectedServices
        ]);
    }

    public function showBookingService(Request $request)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Vui lòng đăng nhập để đặt dịch vụ.');
        }
        $keyword = $request->input('keyword');
        $query = DB::table('DichVu');
        if ($keyword) {
            $query->where('TenDichVu', 'LIKE', "%$keyword%");
        }
        $dichvus = $query->paginate(5)->appends(['keyword' => $keyword]);
        $maKhachHang = session('user_id');
        $thucungs = DB::table('ThuCung')->where('MaKhachHang', $maKhachHang)->get();
        return view('booking_service', compact('dichvus', 'thucungs'))->with('success', session('success'));
    }

    public function storeBookingService(Request $request)
    {
        $request->validate([
            'MaThuCung' => 'required|exists:ThuCung,MaThuCung',
            'Ngay' => 'required|date',
            'Gio' => 'required',
        ]);
        try {
            $selectedServices = session('selected_services', []);
            if (empty($selectedServices)) {
                return redirect()->route('bookingService.create')->withErrors('Không có dịch vụ nào được chọn.');
            }
            $thucung = DB::table('ThuCung')->where('MaThuCung', $request->MaThuCung)->first();
            $cart = session()->get('cart', []);
            foreach ($selectedServices as $dichvuId) {
                $dichvu = DB::table('DichVu')->where('MaDichVu', $dichvuId)->first();
                if ($dichvu) {
                    $cart[] = [
                        'id' => $dichvu->MaDichVu,
                        'name' => $dichvu->TenDichVu,
                        'price' => $dichvu->DonGia,
                        'quantity' => 1,
                        'type' => 'service',
                        'pet_id' => $thucung->MaThuCung,
                        'pet_name' => $thucung->TenThuCung,
                        'date' => $request->Ngay,
                        'time' => $request->Gio,
                    ];
                }
            }
            session()->put('cart', $cart);
            session()->forget('selected_services');
            session()->flash('success', 'Dịch vụ đã được thêm vào giỏ hàng!');
            return redirect()->route('bookingService.create');
        } catch (\Exception $e) {
            return back()->withErrors('Lỗi khi thêm dịch vụ vào giỏ hàng: ' . $e->getMessage());
        }
    }

    // public function storeAppointment(Request $request)
    // {
    //     $validated = $request->validate([
    //         'NgayKham' => 'required|date|after_or_equal:today',
    //         'GioKham' => 'required',
    //         'DiaChi' => 'required',
    //         'ChuanDoan' => 'required',
    //         'ChiPhiKham' => 'required|numeric|min:0',
    //         'MaBacSi' => 'required|exists:BacSi,MaBacSi',
    //         'MaThuCung' => 'required|exists:ThuCung,MaThuCung',
    //     ]);

    //     try {
    //         // Kiểm tra giờ nghỉ (ví dụ: 12:00-13:30)
    //         $gioKham = Carbon::parse($validated['GioKham']);
    //         $gioBatDauNghi = Carbon::parse('12:00');
    //         $gioKetThucNghi = Carbon::parse('13:30');

    //         if ($gioKham->between($gioBatDauNghi, $gioKetThucNghi)) {
    //             return redirect()->back()->with('error', 'Không thể đặt lịch trong giờ nghỉ (12:00-13:30)');
    //         }

    //         // Kiểm tra giờ làm việc (ví dụ: 8:00-17:00)
    //         $gioBatDauLam = Carbon::parse('08:00');
    //         $gioKetThucLam = Carbon::parse('17:00');

    //         if ($gioKham->lt($gioBatDauLam) || $gioKham->gt($gioKetThucLam)) {
    //             return redirect()->back()->with('error', 'Thời gian đặt lịch phải trong khoảng 8:00-17:00');
    //         }

    //         // Kiểm tra lịch trùng
    //         $existingAppointments = DB::table('LichKham')
    //             ->where('NgayKham', $validated['NgayKham'])
    //             ->where('MaBacSi', $validated['MaBacSi'])
    //             ->get();

    //         foreach ($existingAppointments as $appointment) {
    //             $existingTime = Carbon::parse($appointment->GioKham);
    //             $timeDiff = $existingTime->diffInMinutes($gioKham, false);

    //             // Kiểm tra khoảng thời gian 30 phút trước và sau
    //             if (abs($timeDiff) < 30) {
    //                 return redirect()->back()->with('error', 'Đã có lịch khám trong khoảng thời gian này. Vui lòng chọn thời gian khác (cách ít nhất 30 phút).');
    //             }
    //         }

    //         $pet = DB::table('ThuCung')->where('MaThuCung', $validated['MaThuCung'])->first();
    //         $doctor = DB::table('BacSi')->where('MaBacSi', $validated['MaBacSi'])->first();

    //         if (!$pet || !$doctor) {
    //             return redirect()->back()->with('error', 'Không tìm thấy thú cưng hoặc bác sĩ.');
    //         }

    //         $maLichKham = DB::table('LichKham')->insertGetId([
    //             'NgayKham' => $validated['NgayKham'],
    //             'GioKham' => $validated['GioKham'],
    //             'DiaChi' => $validated['DiaChi'],
    //             'ChuanDoan' => $validated['ChuanDoan'],
    //             'ChiPhiKham' => $validated['ChiPhiKham'],
    //             'MaBacSi' => $validated['MaBacSi'],
    //             'MaThuCung' => $validated['MaThuCung'],
    //         ]);

    //         $cart = session()->get('cart', []);
    //         $cart[] = [
    //             'type' => 'appointment',
    //             'id' => $maLichKham,
    //             'name' => $validated['ChuanDoan'],
    //             'pet_name' => $pet->TenThuCung,
    //             'doctor_name' => $doctor->HoTen,
    //             'date' => $validated['NgayKham'],
    //             'time' => $validated['GioKham'],
    //             'price' => $validated['ChiPhiKham'],
    //             'quantity' => 1,
    //         ];

    //         session()->put('cart', $cart);
    //         return redirect()->route('cart')->with('success', 'Lịch khám đã được thêm vào giỏ hàng.');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
    //     }
    // }
    public function storeAppointment(Request $request)
{
    $validated = $request->validate([
        'NgayKham' => 'required|date|after_or_equal:today',
        'GioKham' => 'required',
        'DiaChi' => 'required',
        'ChuanDoan' => 'required',
        'ChiPhiKham' => 'required|numeric|min:0',
        'MaBacSi' => 'required|exists:BacSi,MaBacSi',
        'MaThuCung' => 'required|exists:ThuCung,MaThuCung',
    ]);

    try {
        // Kiểm tra giờ nghỉ (ví dụ: 12:00-13:30)
        $gioKham = Carbon::parse($validated['GioKham']);
        $gioBatDauNghi = Carbon::parse('12:00');
        $gioKetThucNghi = Carbon::parse('13:30');

        if ($gioKham->between($gioBatDauNghi, $gioKetThucNghi)) {
            return redirect()->back()->with('error', 'Không thể đặt lịch trong giờ nghỉ (12:00-13:30)');
        }

        // Kiểm tra giờ làm việc (ví dụ: 8:00-17:00)
        $gioBatDauLam = Carbon::parse('08:00');
        $gioKetThucLam = Carbon::parse('17:00');

        if ($gioKham->lt($gioBatDauLam) || $gioKham->gt($gioKetThucLam)) {
            return redirect()->back()->with('error', 'Thời gian đặt lịch phải trong khoảng 8:00-17:00');
        }

        // Kiểm tra lịch trùng
        $existingAppointments = DB::table('LichKham')
            ->where('NgayKham', $validated['NgayKham'])
            ->where('MaBacSi', $validated['MaBacSi'])
            ->get();

        foreach ($existingAppointments as $appointment) {
            $existingTime = Carbon::parse($appointment->GioKham);
            $timeDiff = $existingTime->diffInMinutes($gioKham, false);

            // Kiểm tra khoảng thời gian 30 phút trước và sau
            if (abs($timeDiff) < 30) {
                return redirect()->back()->with('error', 'Đã có lịch khám trong khoảng thời gian này. Vui lòng chọn thời gian khác (cách ít nhất 30 phút).');
            }
        }

        $pet = DB::table('ThuCung')->where('MaThuCung', $validated['MaThuCung'])->first();
        $doctor = DB::table('BacSi')->where('MaBacSi', $validated['MaBacSi'])->first();

        if (!$pet || !$doctor) {
            return redirect()->back()->with('error', 'Không tìm thấy thú cưng hoặc bác sĩ.');
        }

        // Lưu thông tin lịch khám vào session (không insert vào database)
        $cart = session()->get('cart', []);
        $cart[] = [
            'type' => 'appointment',
            'id'=>'1',
            'pet_id' => $validated['MaThuCung'],
            'doctor_id' => $validated['MaBacSi'],
            'name' => $validated['ChuanDoan'],
            'pet_name' => $pet->TenThuCung,
            'doctor_name' => $doctor->HoTen,

            'date' => $validated['NgayKham'],
            'time' => $validated['GioKham'],
            'price' => $validated['ChiPhiKham'],
            'address' => $validated['DiaChi'], // Lưu thêm địa chỉ
            'quantity' => 1,
        ];

        session()->put('cart', $cart);
        return redirect()->route('cart')->with('success', 'Lịch khám đã được thêm vào giỏ hàng.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
    }
}


    public function showProductList(Request $request)
    {
        $today = now()->format('Y-m-d'); // Giữ nguyên cách dùng này
        $products = DB::table('VatTu')
            ->leftJoin('chitietchuongtrinhgiamgia', 'VatTu.MaVatTu', '=', 'chitietchuongtrinhgiamgia.MaVatTu')
            ->leftJoin('chuongtrinhgiamgia', 'chitietchuongtrinhgiamgia.MaChuongTrinhGiamGia', '=', 'chuongtrinhgiamgia.MaChuongTrinhGiamGia')
            ->select('VatTu.*', 'chitietchuongtrinhgiamgia.PhanTramGiam', 'chitietchuongtrinhgiamgia.GiamToiDa', 'chuongtrinhgiamgia.NgayBatDau', 'chuongtrinhgiamgia.NgayKetThuc')
            ->where('Deleted', false)
            ->get()
            ->map(function ($item) use ($today) {
                // Kiểm tra xem chương trình giảm giá có áp dụng trong ngày hôm nay không
                $isDiscountActive = ($today >= $item->NgayBatDau && $today <= $item->NgayKetThuc);
                // Tính giá sau giảm nếu chương trình giảm giá đang áp dụng
                if ($isDiscountActive && $item->PhanTramGiam > 0) {
                    $discountAmount = ($item->DonGiaBan * $item->PhanTramGiam) / 100;
                    $item->GiaSauGiam = $item->DonGiaBan - $discountAmount;
                    if ($item->GiaSauGiam < 0) {
                        $item->GiaSauGiam = 0; // Đảm bảo giá không âm
                    }
                } else {
                    $item->GiaSauGiam = $item->DonGiaBan; // Nếu không có giảm giá, giá bằng giá ban đầu
                }
                // Gắn cờ xem có đang áp dụng giảm giá không
                $item->isDiscountActive = $isDiscountActive;
                return $item;
            });
        // Lấy danh sách dịch vụ và tính giá sau giảm
        $services = DB::table('DichVu')
            ->leftJoin('chitietchuongtrinhgiamgia', 'DichVu.MaDichVu', '=', 'chitietchuongtrinhgiamgia.MaDichVu')
            ->leftJoin('chuongtrinhgiamgia', 'chitietchuongtrinhgiamgia.MaChuongTrinhGiamGia', '=', 'chuongtrinhgiamgia.MaChuongTrinhGiamGia')
            ->select('DichVu.*', 'chitietchuongtrinhgiamgia.PhanTramGiam', 'chitietchuongtrinhgiamgia.GiamToiDa', 'chuongtrinhgiamgia.NgayBatDau', 'chuongtrinhgiamgia.NgayKetThuc')
            ->where('Deleted', false) // Chỉ lấy nhà cung cấp chưa bị xóa
            ->get()
            ->map(function ($item) use ($today) {
                // Kiểm tra xem chương trình giảm giá có áp dụng trong ngày hôm nay không
                $isDiscountActive = ($today >= $item->NgayBatDau && $today <= $item->NgayKetThuc);
                // Tính giá sau giảm nếu chương trình giảm giá đang áp dụng
                if ($isDiscountActive && $item->PhanTramGiam > 0) {
                    $discountAmount = ($item->DonGia * $item->PhanTramGiam) / 100;
                    $item->GiaSauGiam = $item->DonGia - $discountAmount;
                    if ($item->GiaSauGiam < 0) {
                        $item->GiaSauGiam = 0; // Đảm bảo giá không âm
                    }
                } else {
                    $item->GiaSauGiam = $item->DonGia; // Nếu không có giảm giá, giá bằng giá ban đầu
                }
                // Gắn cờ xem có đang áp dụng giảm giá không
                $item->isDiscountActive = $isDiscountActive;
                return $item;
            });
        // Lấy danh sách thú cưng của người dùng
        $pets = DB::table('ThuCung')
            ->where('MaKhachHang', session('user_id'))
            ->get();
        return view('product', compact('products', 'services', 'pets'));
    }

    public function showProductDetail($id)
    {
        $product = DB::table('VatTu')->where('MaVatTu', $id)->first();
        if (!$product) {
            return redirect()->route('product')->with('error', 'Sản phẩm không tồn tại.');
        }
        $type = 'vat_tu';
        $stock = $product->stock ?? 0;
        return view('detailproduct', compact('product', 'type', 'stock'));
    }

    public function showServiceDetail($id)
    {
        $product = DB::table('DichVu')->where('MaDichVu', $id)->first();
        if (!$product) {
            return redirect()->route('product')->with('error', 'Dịch vụ không tồn tại.');
        }
        $type = 'dich_vu';
        return view('detailproduct', compact('product', 'type'));
    }

    public function showCart()
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Vui lòng đăng nhập để xem giỏ hàng.');
        }

        $cartItems = session()->get('cart', []);

        // Duyệt qua từng item để thêm thông tin giá và khuyến mãi
        $processedCartItems = array_map(function ($item) {
            if ($item['type'] === 'product') {
                // Lấy thông tin sản phẩm
                $product = DB::table('VatTu')->where('MaVatTu', $item['id'])->first();

                if ($product) {
                    // Thêm originalPrice vào item
                    $item['originalPrice'] = $product->DonGiaBan;

                    // Tìm khuyến mãi cho sản phẩm
                    $discount = DB::table('ChiTietChuongTrinhGiamGia')
                        ->join('ChuongTrinhGiamGia', 'ChiTietChuongTrinhGiamGia.MaChuongTrinhGiamGia', '=', 'ChuongTrinhGiamGia.MaChuongTrinhGiamGia')
                        ->where('ChiTietChuongTrinhGiamGia.MaVatTu', $item['id'])
                        ->where('ChuongTrinhGiamGia.NgayBatDau', '<=', now())
                        ->where('ChuongTrinhGiamGia.NgayKetThuc', '>=', now())
                        ->first();

                    // Áp dụng khuyến mãi nếu có
                    if ($discount) {
                        $discountAmount = ($item['originalPrice'] * $discount->PhanTramGiam) / 100;
                        $item['discountedPrice'] = max(0, $item['originalPrice'] - $discountAmount);
                        $item['discountAmount'] = $discountAmount;
                        $item['discountPercent'] = $discount->PhanTramGiam;
                    } else {
                        $item['discountedPrice'] = $item['originalPrice'];
                        $item['discountAmount'] = 0;
                        $item['discountPercent'] = 0;
                    }
                } else {
                    $item['originalPrice'] = $item['price'];
                    $item['discountedPrice'] = $item['price'];
                    $item['discountAmount'] = 0;
                    $item['discountPercent'] = 0;
                }
            } elseif ($item['type'] === 'service') {
                // Lấy thông tin dịch vụ
                $service = DB::table('DichVu')->where('MaDichVu', $item['id'])->first();

                if ($service) {
                    // Thêm originalPrice vào item
                    $item['originalPrice'] = $service->DonGia;

                    // Tìm khuyến mãi cho dịch vụ
                    $discount = DB::table('ChiTietChuongTrinhGiamGia')
                        ->join('ChuongTrinhGiamGia', 'ChiTietChuongTrinhGiamGia.MaChuongTrinhGiamGia', '=', 'ChuongTrinhGiamGia.MaChuongTrinhGiamGia')
                        ->where('ChiTietChuongTrinhGiamGia.MaDichVu', $item['id'])
                        ->where('ChuongTrinhGiamGia.NgayBatDau', '<=', now())
                        ->where('ChuongTrinhGiamGia.NgayKetThuc', '>=', now())
                        ->first();

                    // Áp dụng khuyến mãi nếu có
                    if ($discount) {
                        $discountAmount = ($item['originalPrice'] * $discount->PhanTramGiam) / 100;
                        $item['discountedPrice'] = max(0, $item['originalPrice'] - $discountAmount);
                        $item['discountAmount'] = $discountAmount;
                        $item['discountPercent'] = $discount->PhanTramGiam;
                    } else {
                        $item['discountedPrice'] = $item['originalPrice'];
                        $item['discountAmount'] = 0;
                        $item['discountPercent'] = 0;
                    }
                } else {
                    $item['originalPrice'] = $item['price'];
                    $item['discountedPrice'] = $item['price'];
                    $item['discountAmount'] = 0;
                    $item['discountPercent'] = 0;
                }
            }

            return $item;
        }, $cartItems);
        Log::info($processedCartItems); // Kiểm tra dữ liệu có trả về không.
        session()->put('cart', $processedCartItems);

        // Tính tổng
        $totalProductAmount = array_sum(array_map(function ($item) {
            return $item['type'] === 'product' ? $item['discountedPrice'] * $item['quantity'] : 0;
        }, $processedCartItems));

        $totalServiceAmount = array_sum(array_map(function ($item) {
            return $item['type'] === 'service' ? $item['discountedPrice'] * $item['quantity'] : 0;
        }, $processedCartItems));

        $totalAppointmentAmount = array_sum(array_map(function ($item) {
            return $item['type'] === 'appointment' ? $item['price'] * $item['quantity'] : 0;
        }, $processedCartItems));
        // Phí vận chuyển cố định
        $shippingFee = 30000;

        // Tổng số tiền
        $totalWithShipping = $totalProductAmount + $totalServiceAmount + $shippingFee + $totalAppointmentAmount;

        return view('cart', [
            'cartItems' => $processedCartItems,
            'totalProductAmount' => $totalProductAmount,
            'totalServiceAmount' => $totalServiceAmount,
            'totalAppointmentAmount' => $totalAppointmentAmount,
            'shippingFee' => $shippingFee,
            'totalWithShipping' => $totalWithShipping
        ]);
    }




    public function addToCart(Request $request)
{
    if (!session()->has('user_id')) {
        return response()->json(['redirect' => route('login.form')]);
    }

    $cart = session()->get('cart', []);

    // Xử lý thêm vật tư vào giỏ hàng
    if ($request->has('product_id') && $request->input('product_id') !== null) {
        $productId = $request->input('product_id');
        $product = DB::table('VatTu')->where('MaVatTu', $productId)->first();

        if ($product) {
            // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
            $found = false;
            foreach ($cart as &$item) {
                if ($item['type'] === 'product' && $item['id'] == $productId) {
                    $item['quantity'] += 1; // Tăng số lượng lên 1
                    $found = true;
                    break;
                }
            }

            // Nếu chưa tồn tại trong giỏ hàng, thêm sản phẩm mới
            if (!$found) {
                $cart[] = [
                    'type' => 'product',
                    'id' => $productId,
                    'name' => $product->TenVatTu,
                    'price' => $product->DonGiaBan,
                    'quantity' => 1,
                ];
            }
        }
    }
    // Xử lý thêm dịch vụ vào giỏ hàng
    elseif ($request->has('service_id') && $request->input('service_id') !== null) {
        $serviceId = $request->input('service_id');
        $service = DB::table('DichVu')->where('MaDichVu', $serviceId)->first();

        if ($service) {
            $cart[] = [
                'type' => 'service',
                'id' => $serviceId,
                'name' => $service->TenDichVu,
                'price' => $service->DonGia,
                'quantity' => 1,
            ];
        }
    }

    session()->put('cart', $cart);

    return response()->json(['message' => 'Đã thêm vào giỏ hàng']);
}

    public function checkout(Request $request)
    {
        if ($request->has('service_id') && $request->input('service_id') !== null) {
            return response()->json(['redirect' => route('bookingService.create')]);
        }
        $addToCartResponse = $this->addToCart($request);
        return response()->json(['redirect' => route('cart')]);
    }

    public function updateQuantity(Request $request, $id)
    {
        try {
            $cart = session()->get('cart', []);
            $itemTotal = 0;



            foreach ($cart as &$item) {  // Lưu ý sử dụng '&' để thay đổi giá trị trực tiếp của $item
                if ($item['id'] == $id) {
                    // Cập nhật số lượng cho sản phẩm hoặc dịch vụ
                    $item['quantity'] = max(1, (int)$request->input('quantity'));
                    // Tính lại tổng giá trị cho item sau khi cập nhật
                    $itemTotal = $item['discountedPrice'] * $item['quantity'];
                }
            }
                  // Dùng foreach để xử lý trực tiếp giỏ hàng
             Log::info($cart); // Kiểm tra dữ liệu có trả về không.

            // Cập nhật lại giỏ hàng
            session()->put('cart', $cart);

            // Tính tổng giá trị cho các sản phẩm, dịch vụ và lịch hẹn
            $totalProductAmount = array_sum(array_map(function ($item) {
                return $item['type'] === 'product' ? $item['discountedPrice'] * $item['quantity'] : 0;
            }, $cart));

            $totalServiceAmount = array_sum(array_map(function ($item) {
                return $item['type'] === 'service' ? $item['discountedPrice'] * $item['quantity'] : 0;
            }, $cart));

            $totalAppointmentAmount = array_sum(array_map(function ($item) {
                return $item['type'] === 'appointment' ? $item['price'] * $item['quantity'] : 0;
            }, $cart));

            // Phí vận chuyển cố định
            $shippingFee = 30000;

            // Tổng số tiền
            $totalWithShipping = $totalProductAmount + $totalServiceAmount + $totalAppointmentAmount + $shippingFee;

            // Trả về kết quả dưới dạng JSON
            return response()->json([
                'success' => true,
                'itemTotal' => number_format($itemTotal, 0, ',', '.') . 'đ',
                'totalProductAmount' => number_format($totalProductAmount, 0, ',', '.') . 'đ',
                'totalServiceAmount' => number_format($totalServiceAmount, 0, ',', '.') . 'đ',
                'totalAppointmentAmount' => number_format($totalAppointmentAmount, 0, ',', '.') . 'đ',
                'totalWithShipping' => number_format($totalWithShipping, 0, ',', '.') . 'đ'
            ]);
        } catch (\Exception $e) {
            Log::error(message: 'Update Quantity Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật số lượng: ' . $e->getMessage()
            ], 500);
        }
    }





    public function removeItem(Request $request)
    {
        $itemId = $request->input('id');
        $itemType = $request->input('type');
        if (!$itemId || !$itemType) {
            return response()->json(['success' => false, 'message' => 'Thiếu thông tin ID hoặc loại mục'], 400);
        }
        $cart = session()->get('cart', []);
        $cart = array_filter($cart, function ($item) use ($itemId, $itemType) {
            return !($item['id'] == $itemId && $item['type'] === $itemType);
        });
        session()->put('cart', array_values($cart));
        return response()->json(['success' => true]);
    }

    public function clearCart()
    {
        session()->forget('cart');
        return response()->json(['success' => true]);
    }

    public function showPayment()
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }

        $cartItems = session()->get('cart', []);

        // Tính tổng giá trị của sản phẩm sử dụng discountedPrice
        $totalProductAmount = array_sum(array_map(function ($item) {
            return $item['type'] === 'product' ? $item['discountedPrice'] * $item['quantity'] : 0;
        }, $cartItems));

        // Tính tổng giá trị của dịch vụ sử dụng discountedPrice
        $totalServiceAmount = array_sum(array_map(function ($item) {
            return $item['type'] === 'service' ? $item['discountedPrice'] * $item['quantity'] : 0;
        }, $cartItems));

        // Tính tổng giá trị của cuộc hẹn sử dụng price
        $totalAppointmentAmount = array_sum(array_map(function ($item) {
            return $item['type'] === 'appointment' ? $item['price'] * $item['quantity'] : 0;
        }, $cartItems));

        // Phí vận chuyển cố định
        $shippingFee = 30000;

        // Tổng số tiền bao gồm phí vận chuyển
        $totalWithShipping = $totalProductAmount + $totalServiceAmount + $totalAppointmentAmount + $shippingFee;

        // Lấy thông tin khách hàng
        $customer = DB::table('KhachHang')->where('MaKhachHang', session('user_id'))->first();

        return view('payment', compact(
            'cartItems',
            'totalProductAmount',
            'totalServiceAmount',
            'totalAppointmentAmount',
            'shippingFee',
            'totalWithShipping',
            'customer'
        ));
    }


    // public function placeOrder(Request $request)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $maKhachHang = session('user_id');
    //         if (!$maKhachHang) {
    //             return redirect()->route('login.form')->with('error', 'Vui lòng đăng nhập để đặt hàng.');
    //         }

    //         // Kiểm tra giỏ hàng có trống không
    //         $cartItems = session()->get('cart', []);
    //         if (empty($cartItems)) {
    //             return redirect()->back()->with('error', 'Giỏ hàng trống');
    //         }

    //         // Tính toán giá trị
    //         $totalProductAmount = array_sum(array_map(function ($item) {
    //             return $item['type'] === 'product' ? $item['discountedPrice'] * $item['quantity'] : 0;
    //         }, $cartItems));

    //         // Tính tổng tiền cho dịch vụ sử dụng discountedPrice
    //         $totalServiceAmount = array_sum(array_map(function ($item) {
    //             return $item['type'] === 'service' ? $item['discountedPrice'] * $item['quantity'] : 0;
    //         }, $cartItems));

    //         // Tính tổng tiền cho cuộc hẹn sử dụng price
    //         $totalAppointmentAmount = array_sum(array_map(function ($item) {
    //             return $item['type'] === 'appointment' ? $item['price'] * $item['quantity'] : 0;
    //         }, $cartItems));

    //         // Phí vận chuyển cố định
    //         $shippingFee = 30000;

    //         // Tổng tiền cho hóa đơn
    //         $tongTien = $totalProductAmount + $totalServiceAmount + $totalAppointmentAmount + $shippingFee;

    //         // Tạo hóa đơn mới
    //         $maHoaDon = DB::table('HoaDon')->insertGetId([
    //             'NgayXuatHoaDon' => now(),
    //             'TongTien' => $tongTien,
    //             'MaLichKham' => null,
    //             'MaKhachHang' => $maKhachHang,
    //             'TrangThai' => 'Chờ xác nhận',
    //             'LoaiGiaoDich' => $request->input('paymentMethod', 'COD')
    //         ]);

    //         // Thêm chi tiết hóa đơn
    //         foreach ($cartItems as $item) {
    //             DB::table('ChiTietHoaDon')->insert([
    //                 'SoLuong' => $item['quantity'],
    //                 'DonGia' => $item['type'] === 'product' || $item['type'] === 'service' ? $item['discountedPrice'] : $item['price'],  // Sử dụng discountedPrice cho sản phẩm và dịch vụ
    //                 'ThanhTien' => ($item['type'] === 'product' || $item['type'] === 'service') ? $item['discountedPrice'] * $item['quantity'] : $item['price'] * $item['quantity'],
    //                 'MaVatTu' => $item['type'] === 'product' ? $item['id'] : null,
    //                 'MaDichVu' => $item['type'] === 'service' ? $item['id'] : null,
    //                 'MaThuCung' => $item['type'] === 'appointment' ? $item['id'] : null,
    //                 'MaHoaDon' => $maHoaDon
    //             ]);
    //         }

    //         // Xóa giỏ hàng sau khi đặt
    //         session()->forget('cart');

    //         DB::commit();

    //         // Quay lại trang giỏ hàng với thông báo thành công
    //         return redirect()->route('cart')->with('success', 'Đặt hàng thành công!');

    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         \Log::error('Order error: ' . $e->getMessage());
    //         return redirect()->back()->with('error', 'Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại.');
    //     }
    // }
    public function placeOrder(Request $request)
{
    DB::beginTransaction();
    try {
        $maKhachHang = session('user_id');
        if (!$maKhachHang) {
            return redirect()->route('login.form')->with('error', 'Vui lòng đăng nhập để đặt hàng.');
        }

        // Kiểm tra giỏ hàng có trống không
        $cartItems = session()->get('cart', []);
        if (empty($cartItems)) {
            return redirect()->back()->with('error', 'Giỏ hàng trống');
        }

        // Tính toán giá trị
        $totalProductAmount = array_sum(array_map(function ($item) {
            return $item['type'] === 'product' ? $item['discountedPrice'] * $item['quantity'] : 0;
        }, $cartItems));

        // Tính tổng tiền cho dịch vụ sử dụng discountedPrice
        $totalServiceAmount = array_sum(array_map(function ($item) {
            return $item['type'] === 'service' ? $item['discountedPrice'] * $item['quantity'] : 0;
        }, $cartItems));

        // Tính tổng tiền cho cuộc hẹn sử dụng price
        $totalAppointmentAmount = array_sum(array_map(function ($item) {
            return $item['type'] === 'appointment' ? $item['price'] * $item['quantity'] : 0;
        }, $cartItems));

        // Phí vận chuyển cố định
        $shippingFee = 30000;

        // Tổng tiền cho hóa đơn
        $tongTien = $totalProductAmount + $totalServiceAmount + $totalAppointmentAmount + $shippingFee;


        // Lấy thông tin lịch khám từ session và insert vào database
        $maLichKham = null; // Khởi tạo biến $maLichKham
        foreach ($cartItems as $item) {
            if ($item['type'] === 'appointment') {
                $maLichKham = DB::table('LichKham')->insertGetId([
                    'NgayKham' => $item['date'],
                    'GioKham' => $item['time'],
                    'DiaChi' => $item['address'], // Lấy địa chỉ từ session
                    'ChuanDoan' => $item['name'],
                    'ChiPhiKham' => $item['price'],
                    'MaBacSi' => $item['doctor_id'],
                    'MaThuCung' => $item['pet_id'],
                ]);
            }
        }

        // Tạo hóa đơn mới với MaLichKham
        $maHoaDon = DB::table('HoaDon')->insertGetId([
            'NgayXuatHoaDon' => now(),
            'TongTien' => $tongTien,
            'MaLichKham' => $maLichKham, // Sử dụng $maLichKham vừa insert
            'MaKhachHang' => $maKhachHang,
            'TrangThai' => 'Chờ xác nhận',
            'LoaiGiaoDich' => $request->input('paymentMethod', 'COD')
        ]);

        // Thêm chi tiết hóa đơn
        foreach ($cartItems as $item) {
            DB::table('ChiTietHoaDon')->insert([
                'SoLuong' => $item['quantity'],
                'DonGia' => $item['type'] === 'product' || $item['type'] === 'service' ? $item['discountedPrice'] : $item['price'],  // Sử dụng discountedPrice cho sản phẩm và dịch vụ
                'ThanhTien' => ($item['type'] === 'product' || $item['type'] === 'service') ? $item['discountedPrice'] * $item['quantity'] : $item['price'] * $item['quantity'],
                'MaVatTu' => $item['type'] === 'product' ? $item['id'] : null,
                'MaDichVu' => $item['type'] === 'service' ? $item['id'] : null,
                'MaThuCung' => $item['type'] === 'appointment' ? $item['pet_id'] : null, // Sử dụng pet_id từ session
                'MaHoaDon' => $maHoaDon
            ]);
        }

        // Xóa giỏ hàng sau khi đặt
        session()->forget('cart');

        DB::commit();

        // Quay lại trang giỏ hàng với thông báo thành công
        return redirect()->route('cart')->with('success', 'Đặt hàng thành công!');

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Order error: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại.');
    }
}

    public function showUserDashboard(Request $request)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Vui lòng đăng nhập để truy cập trang này.');
        }
        return redirect()->route('userdashboard.profile');
    }

    public function showProfile(Request $request)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Vui lòng đăng nhập để truy cập trang này.');
        }
        $userId = session('user_id');
        $customer = DB::table('KhachHang')->where('MaKhachHang', $userId)->first();
        if (!$customer) {
            return redirect()->route('userdashboard')->with('error', 'Không tìm thấy thông tin khách hàng.');
        }
        return view('userdashboard.profile', compact('customer'));
    }

    public function updateProfile(Request $request)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Vui lòng đăng nhập để truy cập trang này.');
        }
        $userId = session('user_id');
        $request->validate([
            'HoTen' => 'required|string|max:100',
            'Email' => 'required|email|max:100',
            'SDT' => 'required|string|max:15',
            'DiaChi' => 'nullable|string|max:255',
        ]);
        DB::table('KhachHang')->where('MaKhachHang', $userId)->update([
            'HoTen' => $request->input('HoTen'),
            'Email' => $request->input('Email'),
            'SDT' => $request->input('SDT'),
            'DiaChi' => $request->input('DiaChi'),
        ]);
        return redirect()->route('userdashboard.profile')->with('success', 'Cập nhật thông tin thành công!');
    }

    public function showPets(Request $request)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Vui lòng đăng nhập để truy cập trang này.');
        }
        $userId = session('user_id');
        $pets = DB::table('ThuCung')
            ->join('GiongLoai', 'ThuCung.MaGiongLoai', '=', 'GiongLoai.MaGiongLoai')
            ->where('ThuCung.MaKhachHang', $userId)
            ->select('ThuCung.*', 'GiongLoai.TenGiongLoai')
            ->get();
        return view('userdashboard.pets', compact('pets'));
    }

    public function showAddPetForm()
    {
        $giongLoais = DB::table('GiongLoai')->get();
        return view('userdashboard.addpet', compact('giongLoais'));
    }

    public function showPetDetail($id)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Vui lòng đăng nhập để truy cập trang này.');
        }
        $userId = session('user_id');
        $pet = DB::table('ThuCung')
            ->join('GiongLoai', 'ThuCung.MaGiongLoai', '=', 'GiongLoai.MaGiongLoai')
            ->where('ThuCung.MaKhachHang', $userId)
            ->where('ThuCung.MaThuCung', $id)
            ->select('ThuCung.*', 'GiongLoai.TenGiongLoai', 'ThuCung.ngaydangki')
            ->first();

        if (!$pet) {
            return redirect()->route('userdashboard.pets')->with('error', 'Không tìm thấy thú cưng.');
        }
        return view('userdashboard.petdetail', compact('pet'));
    }

    public function updatePet(Request $request, $id)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Vui lòng đăng nhập để truy cập trang này.');
        }
        $userId = session('user_id');
        $pet = DB::table('ThuCung')
            ->where('MaKhachHang', $userId)
            ->where('MaThuCung', $id)
            ->first();
        if (!$pet) {
            return redirect()->route('userdashboard.pets')->with('error', 'Không tìm thấy thú cưng.');
        }
        $request->validate([
            'TenThuCung' => 'required|string|max:100',
            'GioiTinh' => 'required|string|max:10',
            'Tuoi' => 'required|integer|min:0',
            'GhiChu' => 'nullable|string',
        ]);
        DB::table('ThuCung')
            ->where('MaThuCung', $id)
            ->update([
                'TenThuCung' => $request->input('TenThuCung'),
                'GioiTinh' => $request->input('GioiTinh'),
                'Tuoi' => $request->input('Tuoi'),
                'GhiChu' => $request->input('GhiChu'),
            ]);
        return redirect()->route('userdashboard.petDetail', ['id' => $id])->with('success', 'Cập nhật thành công!');
    }

    public function addPet()
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Vui lòng đăng nhập để truy cập trang này.');
        }
        return view('userdashboard.addpet');
    }

    public function storePet(Request $request)
    {
        $request->validate([
            'TenThuCung' => 'required|string|max:100',
            'GioiTinh' => 'required|string|max:10',
            'Tuoi' => 'required|integer|min:0',
            'GiongLoai' => 'required|string|max:100',
            'GhiChu' => 'nullable|string|max:255',
            'NgayDangKy' => 'required|date',
        ]);
        try {
            $maKhachHang = session('user_id');
            if (!$maKhachHang) {
                return redirect()->route('login.form')->with('error', 'Vui lòng đăng nhập để thực hiện thao tác này.');
            }
            $tenGiongLoai = $request->input('GiongLoai');
            $giongLoai = DB::table('GiongLoai')->where('TenGiongLoai', $tenGiongLoai)->first();
            if (!$giongLoai) {
                $maGiongLoai = DB::table('GiongLoai')->insertGetId([
                    'TenGiongLoai' => $tenGiongLoai,
                ]);
            } else {
                $maGiongLoai = $giongLoai->MaGiongLoai;
            }
            DB::table('ThuCung')->insert([
                'TenThuCung' => $request->input('TenThuCung'),
                'GioiTinh' => $request->input('GioiTinh'),
                'Tuoi' => $request->input('Tuoi'),
                'GhiChu' => $request->input('GhiChu'),
                'HinhAnh' => null,
                'MaKhachHang' => $maKhachHang,
                'MaGiongLoai' => $maGiongLoai,
                'NgayDangKi' => $request->input('NgayDangKy'),
            ]);

            return redirect()->route('userdashboard.pets')->with('success', 'Thú cưng đã được thêm thành công.');
        } catch (\Exception $e) {
            return redirect()->route('userdashboard.addPet')->with('error', 'Có lỗi xảy ra. Vui lòng thử lại! Lỗi: ' . $e->getMessage());
        }
    }

    public function showOrders(Request $request)
    {
        $status = $request->query('status', 'all');

        $mainStatuses = [
            'Chờ xác nhận',
            'Đã xác nhận',
            'Hoàn thành',
            'Từ Chối Đơn Hàng'
        ];

        $inProgressStatuses = [
            'Đợi đến giờ',
            'Đang thực hiện dịch vụ',
            'Đang chuẩn bị hàng',
            'Đang giao hàng'
        ];

        $ordersQuery = DB::table('HoaDon')->where('MaKhachHang', session('user_id'));

        if ($status !== 'all') {
            if ($status === 'Xử Lý') {
                $ordersQuery->whereIn('TrangThai', $inProgressStatuses);
            } elseif (in_array($status, $mainStatuses)) {
                $ordersQuery->where('TrangThai', $status);
            }
        }

        $orders = $ordersQuery->get();

        return view('userdashboard.orders', compact('orders'));
    }

    public function showOrderDetail($id)
    {
        $userId = session('user_id');
        $order = DB::table('HoaDon')
            ->where('MaHoaDon', $id)
            ->where('MaKhachHang', $userId)
            ->first();

        if (!$order) {
            return redirect()->route('userdashboard.orders')->with('error', 'Hóa đơn không tồn tại.');
        }

        $orderDetails = DB::table('ChiTietHoaDon')
            ->leftJoin('hoadon', 'hoadon.MaHoaDon', '=', 'ChiTietHoaDon.MaHoaDon')
            ->leftJoin('VatTu', 'ChiTietHoaDon.MaVatTu', '=', 'VatTu.MaVatTu')
            ->leftJoin('DichVu', 'ChiTietHoaDon.MaDichVu', '=', 'DichVu.MaDichVu')
            ->leftJoin('LichKham', 'hoadon.MaLichKham', '=', 'LichKham.MaLichKham')
            ->leftJoin('ThuCung', 'LichKham.MaThuCung', '=', 'ThuCung.MaThuCung')
            ->select(
                'ChiTietHoaDon.SoLuong',
                'hoadon.MaHoaDon',
                'hoadon.MaLichKham',
                'ChiTietHoaDon.DonGia',
                'ChiTietHoaDon.ThanhTien',
                'VatTu.MaVatTu',
                'VatTu.HinhAnh as HinhAnhVT', // Lấy mã vật tư
                'DichVu.MaDichVu',
                'DichVu.HinhAnh as HinhAnhDV',  // Lấy mã dịch vụ
                'LichKham.MaThuCung',
                DB::raw('
                    CASE
                        WHEN VatTu.TenVatTu IS NOT NULL THEN VatTu.TenVatTu
                        WHEN DichVu.TenDichVu IS NOT NULL THEN DichVu.TenDichVu
                        WHEN LichKham.ChuanDoan IS NOT NULL THEN CONCAT("Khám bệnh - ", LichKham.ChuanDoan, " - ", ThuCung.TenThuCung)
                        ELSE "Không rõ"
                    END AS Ten,
                    CASE
                        WHEN VatTu.TenVatTu IS NOT NULL THEN "product"
                        WHEN DichVu.TenDichVu IS NOT NULL THEN "service"
                        WHEN LichKham.ChuanDoan IS NOT NULL THEN "appointment"
                        ELSE "unknown"
                    END AS type
                ')
            )
            ->where('ChiTietHoaDon.MaHoaDon', $id)
            ->get();

        return view('userdashboard.orderdetail', compact('order', 'orderDetails'));
    }

    public function cancelOrder($id)
    {
        // Kiểm tra xem đơn hàng có tồn tại và thuộc về người dùng hiện tại không
        $order = DB::table('HoaDon')
            ->where('MaHoaDon', $id)
            ->where('MaKhachHang', session('user_id'))
            ->first();

        if (!$order) {
            return redirect()->route('userdashboard.orders')->with('error', 'Đơn hàng không tồn tại hoặc không phải của bạn.');
        }

        // Cập nhật trạng thái đơn hàng thành "Từ Chối Đơn Hàng"
        DB::table('HoaDon')
            ->where('MaHoaDon', $id)
            ->where('MaKhachHang', session('user_id'))
            ->update(['TrangThai' => 'Từ Chối Đơn Hàng']);

        return redirect()->route('userdashboard.orders')->with('success', 'Đơn hàng đã được huỷ.');
    }

    public function showAppointments()
    {
        $userId = session('user_id'); // Lấy mã người dùng từ session
        $pets = DB::table('ThuCung')
        ->where('MaKhachHang', $userId)
        ->get();

        // Lấy danh sách các cuộc hẹn và thông tin liên quan đến hóa đơn
        $appointments = DB::table('HoaDon') // Bắt đầu từ bảng HoaDon
            ->join('LichKham', 'HoaDon.MaLichKham', '=', 'LichKham.MaLichKham') // Nối bảng LichKham
            ->join('ThuCung', 'LichKham.MaThuCung', '=', 'ThuCung.MaThuCung') // Nối bảng ThuCung
            ->select(
                'LichKham.MaLichKham',
                'LichKham.NgayKham',
                'LichKham.GioKham',
                'ThuCung.TenThuCung',
                'ThuCung.MaThuCung',
                'HoaDon.MaHoaDon', // Mã hóa đơn
                'HoaDon.TrangThai' // Trạng thái hóa đơn
            )
            ->where('HoaDon.MaKhachHang', $userId)  // Lọc theo mã khách hàng
            ->get();  // Lấy tất cả các cuộc hẹn, kể cả khi không có hóa đơn

        // Trả về view với danh sách các cuộc hẹn
        return view('userdashboard.appointments', compact('appointments','pets'));
    }




    public function showAppointmentDetail($id)
    {
        $userId = session('user_id');
        $appointment = DB::table('LichKham')
            ->join('ThuCung', 'LichKham.MaThuCung', '=', 'ThuCung.MaThuCung')
            ->select(
                'LichKham.*',
                'ThuCung.TenThuCung',
                'ThuCung.GioiTinh',
                'ThuCung.Tuoi'
            )
            ->where('LichKham.MaLichKham', $id)
            ->where('ThuCung.MaKhachHang', $userId)
            ->first();

        if (!$appointment) {
            return redirect()->route('userdashboard.appointments')->with('error', 'Lịch khám không tồn tại.');
        }
        return view('userdashboard.appointmentdetail', compact('appointment'));
    }

    public function updateAppointment(Request $request)
    {
        $userId = session('user_id');
        $appointmentId = $request->input('appointment_id');
        $petId = $request->input('MaThuCung');
        $newDate = $request->input('NgayKham');
        $newTime = $request->input('GioKham');
        $updated = DB::table('LichKham')
            ->join('ThuCung', 'LichKham.MaThuCung', '=', 'ThuCung.MaThuCung')
            ->where('LichKham.MaLichKham', $appointmentId)
            ->where('ThuCung.MaKhachHang', $userId)
            ->update([
                'LichKham.MaThuCung' => $petId,
                'LichKham.NgayKham' => $newDate,
                'LichKham.GioKham' => $newTime
            ]);
        if ($updated) {
            return redirect()->route('userdashboard.appointments')->with('success', 'Cập nhật lịch khám thành công.');
        } else {
            return redirect()->route('userdashboard.appointments')->with('error', 'Không thể cập nhật lịch khám. Vui lòng thử lại.');
        }
    }

    public function destroy($id)
    {
        try {
            $userId = session('user_id');
            $pet = DB::table('ThuCung')->where('MaThuCung', $id)->where('MaKhachHang', $userId)->first();
            if (!$pet) {
                return response()->json(['success' => false, 'message' => 'Thú cưng không tồn tại hoặc không thuộc về bạn.'], 404);
            }
            DB::table('ThuCung')->where('MaThuCung', $id)->delete();
            return response()->json(['success' => true, 'message' => 'Thú cưng đã được xóa thành công.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Đã xảy ra lỗi: ' . $e->getMessage()], 500);
        }
    }

    // public function deleteOrder($id)
    // {
    //     try {
    //         $order = DB::table('HoaDon')->where('MaHoaDon', $id)->first();
    //         if (!$order || $order->TrangThai !== 'Chờ xác nhận') {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Hóa đơn không tồn tại hoặc không thể xóa.'
    //             ], 400);
    //         }
    //         $appointments = DB::table('ChiTietHoaDon')
    //             ->where('MaHoaDon', $id)
    //             ->whereNotNull('MaThuCung')
    //             ->pluck('MaThuCung');
    //         if ($appointments->isNotEmpty()) {
    //             DB::table('LichKham')->whereIn('MaLichKham', $appointments)->delete();
    //         }
    //         DB::table('ChiTietHoaDon')->where('MaHoaDon', $id)->delete();
    //         DB::table('HoaDon')->where('MaHoaDon', $id)->delete();
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Hóa đơn đã xóa thành công.'
    //         ]);
    //     } catch (\Exception $e) {
    //         Log::error('Lỗi khi xóa hóa đơn:', ['error' => $e->getMessage()]);
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Đã xảy ra lỗi: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }
}
