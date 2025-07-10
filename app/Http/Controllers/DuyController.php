<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class DuyController extends Controller
{
    // Hiển thị form Đặt Lịch Khám
    public function showAppointmentForm()
    {
        // Fetch veterinarians and pets for dropdown
        $bacSi = DB::select('SELECT MaBacSi, HoTen FROM BacSi');
        $thuCung = DB::select('SELECT MaThuCung, TenThuCung FROM ThuCung WHERE MaKhachHang = ?', [session('user_id')]);

        return view('Duy_LichKham', ['bacSi' => $bacSi, 'thuCung' => $thuCung]);
    }

    // Xử lý Đặt Lịch Khám
    public function handleAppointment(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'NgayKham' => 'required|date|after_or_equal:today',
            'GioKham' => 'required',
            'DiaChi' => 'required|string|max:255',
            'ChuanDoan' => 'required|string|max:255',
            'ChiPhiKham' => 'required|numeric|min:0',
            'MaBacSi' => 'required|integer|exists:BacSi,MaBacSi',
            'MaThuCung' => 'required|integer|exists:ThuCung,MaThuCung',
        ]);

        try {
            // Lấy MaKhachHang từ session
            $maKhachHang = session('user_id');

            DB::beginTransaction();

            // Insert vào LichKham
            $maLichKham = DB::table('LichKham')->insertGetId([
                'NgayKham' => $validated['NgayKham'],
                'GioKham' => $validated['GioKham'],
                'DiaChi' => $validated['DiaChi'],
                'ChuanDoan' => $validated['ChuanDoan'],
                'ChiPhiKham' => $validated['ChiPhiKham'],
                'MaBacSi' => $validated['MaBacSi'],
                'MaThuCung' => $validated['MaThuCung'],
            ]);

            // Insert vào HoaDon
            DB::table('HoaDon')->insert([
                'NgayXuatHoaDon' => date('Y-m-d'),
                'TongTien' => $validated['ChiPhiKham'],
                'MaLichKham' => $maLichKham,
                'MaKhachHang' => $maKhachHang,
            ]);

            DB::commit();

            return redirect()->route('appointment.form')->with('success', 'Đặt lịch khám thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Lỗi khi đặt lịch khám: ' . $e->getMessage());
        }
    }

    public function authCustomshowLoginForm()
    {
        return view('authCustom');
    }

    public function authCustomhandleLogin(Request $request)
    {
    $validated = $request->validate([
        'role' => 'required|string|in:manager,employee,doctor',
        'TaiKhoan' => 'required|string',
        'MatKhau' => 'required|string',
    ]);

    try {
        // Verify manager
        if ($validated['role'] === 'manager') {
            if ($validated['TaiKhoan'] === 'admin' && Hash::check($validated['MatKhau'], Hash::make('admin123'))) {
                session([
                    'manage_id' => 1,
                    'role' => 'manager',
                    'user_name' => 'Admin'
                ]);
                return redirect()->route('admin.assignments.index')->with('success', 'Đăng nhập thành công.');
            }
            return back()->withErrors('Tài khoản hoặc mật khẩu không đúng.');
        }

        // Verify employee
        if ($validated['role'] === 'employee') {
            $user = DB::table('NhanVien')
                        ->where('TaiKhoan', $validated['TaiKhoan'])
                        ->first();

            if ($user && Hash::check($validated['MatKhau'], $user->MatKhau)) {
                session([
                    'manage_id' => $user->MaNhanVien,
                    'role' => 'employee',
                    'user_name' => $user->TenNhanVien
                ]);
                return redirect()->route('employee.dashboard',['id'=>$user->MaNhanVien])->with('success', 'Đăng nhập thành công.');
            }
            return back()->withErrors('Tài khoản hoặc mật khẩu không đúng.');
        }


        if ($validated['role'] === 'doctor') {
            $user = DB::table('bacsi')
                ->where('TaiKhoan', $validated['TaiKhoan'])
                ->first();

            if ($user) {
                if (Hash::check($validated['MatKhau'], $user->MatKhau)) {
                    session([
                        'manage_id' => $user->MaBacSi,
                        'role' => 'doctor',
                        'user_name' => $user->HoTen
                    ]);
                    session()->save();
                    return redirect()->route('doctor.schedule.byId', ['maBacSi' => $user->MaBacSi]);
                }
            }
            return back()->withErrors('Tài khoản hoặc mật khẩu không đúng.');
        }



    } catch (\Exception $e) {
        return back()
            ->withInput(['TaiKhoan' => $validated['TaiKhoan']])
            ->withErrors('Đã xảy ra lỗi trong quá trình đăng nhập. Vui lòng thử lại.');
    }
    }


    // Hiển thị form Đăng nhập
    public function showLoginForm()
    {
        return view('login');
    }

    // Xử lý Đăng nhập
    public function handleLogin(Request $request)
    {
        $validated = $request->validate([
            'TaiKhoan' => 'required|string',
            'MatKhau' => 'required|string',
        ]);

        // Tìm người dùng
        $user = DB::table('KhachHang')->where('TaiKhoan', $validated['TaiKhoan'])->first();

        if ($user && Hash::check($validated['MatKhau'], $user->MatKhau)) {
            // Lưu thông tin người dùng vào session
            session(['user_id' => $user->MaKhachHang, 'user_name' => $user->HoTen]);
            return redirect()->route('index')->with('success', 'Đăng nhập thành công.');
        }

        return back()->withErrors('Tài khoản hoặc mật khẩu không đúng.');
    }

    // Hiển thị form Đăng ký
    public function showRegisterForm()
    {
        return view('login'); // Sử dụng cùng một view với form đăng ký
    }

    // Xử lý Đăng ký
    public function handleRegister(Request $request)
    {
        $validated = $request->validate([
            'HoTen' => 'required|string|max:100',
            'SDT' => 'required|string|max:15',
            'Email' => 'required|email|max:100|unique:KhachHang,Email',
            'DiaChi' => 'required|string|max:255',
            'TaiKhoan' => 'required|string|max:50|unique:KhachHang,TaiKhoan',
            'MatKhau' => 'required|string|min:6|confirmed',
        ]);

        try {
            // Mã hóa mật khẩu
            $hashedPassword = Hash::make($validated['MatKhau']);

            // Insert người dùng mới
            $maKhachHang = DB::table('KhachHang')->insertGetId([
                'HoTen' => $validated['HoTen'],
                'SDT' => $validated['SDT'],
                'Email' => $validated['Email'],
                'DiaChi' => $validated['DiaChi'],
                'TaiKhoan' => $validated['TaiKhoan'],
                'MatKhau' => $hashedPassword,
            ]);

            // Đăng nhập người dùng mới
            session(['user_id' => $maKhachHang, 'user_name' => $validated['HoTen']]);

            return redirect()->route('index')->with('success', 'Đăng ký và đăng nhập thành công.');
        } catch (\Exception $e) {
            return back()->withErrors('Lỗi khi đăng ký: ' . $e->getMessage());
        }
    }

    // Xử lý Đăng xuất
    public function logout(Request $request)
    {
        // Xóa tất cả thông tin trong session
        $request->session()->flush();

        // Redirect về trang đăng nhập
        return redirect()->route('authCustom.login.form');
    }

    public function logoutUser(Request $request)
    {
        // Xóa tất cả thông tin trong session
        $request->session()->flush();

        // Redirect về trang đăng nhập
        return redirect()->route('login.form');
    }



    public function showCustomerDetails($id)
    {
        // Validate that $id is a positive integer
        if (!is_numeric($id) || $id <= 0) {
            return redirect()->route('index')->withErrors('ID khách hàng không hợp lệ.');
        }

        try {
            // Fetch customer data
            $customer = DB::table('KhachHang')->where('MaKhachHang', $id)->first();

            if (!$customer) {
                return redirect()->route('index')->withErrors('Không tìm thấy khách hàng.');
            }

            return view('Duy_CustomerDetails', ['customer' => $customer]);
        } catch (\Exception $e) {
            // Log the exception message for debugging
            \Log::error('Error fetching customer details: ' . $e->getMessage());

            return redirect()->route('index')->withErrors('Có lỗi xảy ra khi lấy thông tin khách hàng.');
        }
    }
    public function Customerindex(Request $request)
    {
        $search = $request->input('search');
        $query = DB::table('KhachHang')
            ->where('Deleted', false);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('HoTen', 'LIKE', "%{$search}%")
                  ->orWhere('Email', 'LIKE', "%{$search}%")
                  ->orWhere('SDT', 'LIKE', "%{$search}%");
            });
        }

        $customers = $query->orderBy('MaKhachHang', 'desc')
                          ->paginate(10);

        return view('Duy_nhanvien_khachhangIndex', compact('customers', 'search'));
    }

    public function Customerdelete($id)
    {
        try {
            DB::table('KhachHang')
                ->where('MaKhachHang', $id)
                ->update(['Deleted' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Xóa khách hàng thành công'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
    public function updateCustomer(Request $request, $id)
    {
        if (!is_numeric($id) || $id <= 0) {
            return redirect()->back()->withErrors('ID khách hàng không hợp lệ.');
        }

        // Lấy thông tin khách hàng hiện tại
        $customer = DB::table('KhachHang')->where('MaKhachHang', $id)->first();
        if (!$customer) {
            return redirect()->back()->withErrors('Không tìm thấy khách hàng.');
        }

        // Rules cơ bản cho các trường được nhập
        $rules = [];
        $updateData = [];

        // Kiểm tra và thêm rules cho từng trường nếu được gửi lên
        if ($request->filled('HoTen')) {
            $rules['HoTen'] = 'string|max:100';
            $updateData['HoTen'] = $request->HoTen;
        }

        if ($request->filled('SDT')) {
            $rules['SDT'] = ['regex:/^[0-9]{10,15}$/'];
            $updateData['SDT'] = $request->SDT;
        }

        if ($request->filled('Email')) {
            $rules['Email'] = 'email|max:100';
            $updateData['Email'] = $request->Email;
        }

        if ($request->filled('DiaChi')) {
            $rules['DiaChi'] = 'string|max:255';
            $updateData['DiaChi'] = $request->DiaChi;
        }

        if ($request->filled('TaiKhoan')) {
            $rules['TaiKhoan'] = 'string|max:50|unique:KhachHang,TaiKhoan,'.$id.',MaKhachHang';
            $updateData['TaiKhoan'] = $request->TaiKhoan;
        }

        // Xử lý mật khẩu nếu được nhập
        if ($request->filled('MatKhau')) {
            $rules['MatKhau'] = 'string|min:6|confirmed';
            if ($request->MatKhau) {
                $updateData['MatKhau'] = Hash::make($request->MatKhau);
            }
        }

        // Nếu không có dữ liệu cập nhật
        if (empty($updateData)) {
            return redirect()->back()->with('info', 'Không có thông tin nào được thay đổi.');
        }

        // Validate dữ liệu đã nhập
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        try {
            DB::beginTransaction();

            $affected = DB::table('KhachHang')
                         ->where('MaKhachHang', $id)
                         ->update($updateData);

            if ($affected === 0) {
                DB::rollBack();
                return redirect()->back()->with('info', 'Không có thay đổi nào được lưu.');
            }

            DB::commit();
            return redirect()->back()->with('success', 'Thông tin khách hàng đã được cập nhật thành công.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error updating customer: ' . $e->getMessage());
            return redirect()->back()->withErrors('Có lỗi xảy ra khi cập nhật thông tin khách hàng.');
        }
    }


    public function employeeDashboard($id)
    {
        // Validate that $id is a positive integer
        if (!is_numeric($id) || $id <= 0) {
            return redirect()->route('index')
                             ->withErrors('ID nhân viên không hợp lệ.');
        }

        try {
            // Fetch employee data
            $employee = DB::table('NhanVien')
                        ->where('MaNhanVien', $id)
                        ->first();

            if (!$employee) {
                return redirect()->route('index')
                                 ->withErrors('Không tìm thấy nhân viên.');
            }

            // Get the work schedule for the employee (monthly view by default)
            $endDate = Carbon::now()->endOfMonth();
            $startDate = Carbon::now()->startOfMonth();

            $phanCongs = DB::table('PhanCong')
                ->join('CaLamViec', 'PhanCong.MaCaLamViec', '=', 'CaLamViec.MaCaLamViec')
                ->where('PhanCong.MaNhanVien', $id)
                ->whereBetween('PhanCong.NgayLamViec', [$startDate->toDateString(), $endDate->toDateString()])
                ->select('PhanCong.*', 'CaLamViec.MoTa as CaLamViecMoTa')
                // Thêm sắp xếp giảm dần theo ngày
                ->orderBy('PhanCong.NgayLamViec', 'desc')
                ->get();

            $dates = [];
            $currentDate = $startDate->copy();
            while ($currentDate->lte($endDate)) {
                $dates[] = $currentDate->copy();
                $currentDate->addDay();
            }

            // Sắp xếp ngày giảm dần
            $dates = array_reverse($dates);

            $schedule = [];
            foreach ($dates as $date) {
                $assignment = $phanCongs->firstWhere('NgayLamViec', $date->toDateString());
                if ($assignment) {
                    $schedule[] = [
                        'date' => $date->format('d/m/Y'),
                        'status' => 'working',
                        'details' => $assignment,
                    ];
                } else {
                    $schedule[] = [
                        'date' => $date->format('d/m/Y'),
                        'status' => 'off',
                        'details' => null,
                    ];
                }
            }

            return view('Duy_employee_dashboard', [
                'employee' => $employee,
                'schedule' => $schedule,
                'hasSchedule' => !$phanCongs->isEmpty(),
                'message' => $phanCongs->isEmpty() ? 'Không có lịch phân công công việc trong tháng này.' : '',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching employee data: ' . $e->getMessage());
            return redirect()->route('home')
                             ->withErrors('Có lỗi xảy ra khi lấy thông tin nhân viên.');
        }
    }

    public function showDoctorSchedule($id, $type = 'month')
    {
        // Validate inputs
        if (!is_numeric($id) || $id <= 0) {
            return redirect()->route('home')->withErrors('ID bác sĩ không hợp lệ.');
        }

        if (!in_array($type, ['week', 'month'])) {
            return redirect()->route('home')->withErrors('Loại lịch không hợp lệ.');
        }

        try {
            // Fetch doctor data
            $doctor = DB::table('BacSi')
                ->where('MaBacSi', $id)
                ->first();

            if (!$doctor) {
                return redirect()->route('home')->withErrors('Không tìm thấy bác sĩ.');
            }

            // Define date range based on type
            if ($type === 'week') {
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
            } else {
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
            }

            // Lấy lịch phân công của bác sĩ
            $phanCongs = DB::table('PhanCong')
                ->join('CaLamViec', 'PhanCong.MaCaLamViec', '=', 'CaLamViec.MaCaLamViec')
                ->where('PhanCong.MaBacSi', $id)
                ->whereBetween('PhanCong.NgayLamViec', [$startDate->toDateString(), $endDate->toDateString()])
                ->select('PhanCong.*', 'CaLamViec.MoTa as CaLamViecMoTa')
                ->get();

            // Lấy lịch khám bệnh của bác sĩ
            $lichKhams = DB::table('LichKham')
                ->where('MaBacSi', $id)
                ->whereBetween('NgayKham', [$startDate->toDateString(), $endDate->toDateString()])
                ->get();

            $dates = [];
            $currentDate = $startDate->copy();
            while ($currentDate->lte($endDate)) {
                $dates[] = $currentDate->copy();
                $currentDate->addDay();
            }

            // Sắp xếp ngày giảm dần (chỉ áp dụng cho view month)
            if ($type === 'month') {
                $dates = array_reverse($dates);
            }

            $schedule = [];
            foreach ($dates as $date) {
                $daySchedule = [];

                // Kiểm tra lịch phân công trong ngày
                $assignments = $phanCongs->where('NgayLamViec', $date->toDateString());
                foreach ($assignments as $assignment) {
                    $daySchedule[] = [
                        'date' => $date->format('d/m/Y'),
                        'status' => 'working',
                        'type' => 'assignment',
                        'details' => $assignment,
                    ];
                }

                // Kiểm tra lịch khám bệnh trong ngày
                $appointments = $lichKhams->where('NgayKham', $date->toDateString());
                foreach ($appointments as $appointment) {
                    $daySchedule[] = [
                        'date' => $date->format('d/m/Y'),
                        'status' => 'working',
                        'type' => 'appointment',
                        'details' => $appointment,
                    ];
                }

                // Nếu không có lịch phân công hoặc lịch khám bệnh trong ngày
                if (empty($daySchedule)) {
                    $daySchedule[] = [
                        'date' => $date->format('d/m/Y'),
                        'status' => 'off',
                        'type' => 'off',
                        'details' => null,
                    ];
                }

                $schedule = array_merge($schedule, $daySchedule);
            }


            return view('Duy_doctor_dashboard', [
                'doctor' => $doctor,
                'schedule' => $schedule,
                'hasSchedule' => !$phanCongs->isEmpty() || !$lichKhams->isEmpty(), // Kiểm tra cả hai loại lịch
                'type' => $type,
                'message' => ($phanCongs->isEmpty() && $lichKhams->isEmpty())
                    ? 'Không có lịch làm việc trong ' . ($type === 'week' ? 'tuần này.' : 'tháng này.')
                    : '',
            ]);

        } catch (\Exception $e) {
            \Log::error('Error fetching doctor schedule: ' . $e->getMessage());
            return redirect()->route('home')->withErrors('Có lỗi xảy ra khi lấy lịch làm việc. Vui lòng thử lại sau.');
        }
    }


    public function doctorDashboard($id)
    {
        // Validate that $id is a positive integer
        if (!is_numeric($id) || $id <= 0) {
            return redirect()->route('index')->withErrors('ID bác sĩ không hợp lệ.');
        }

        try {
            // Fetch doctor data
            $doctor = DB::table('BacSi')
                ->where('MaBacSi', $id)
                ->first();

            if (!$doctor) {
                return redirect()->route('index')->withErrors('Không tìm thấy bác sĩ.');
            }

            // Get the work schedule for the doctor (monthly view by default)
            $endDate = Carbon::now()->endOfMonth();
            $startDate = Carbon::now()->startOfMonth();

            // Lấy lịch phân công của bác sĩ
            $phanCongs = DB::table('PhanCong')
                ->join('CaLamViec', 'PhanCong.MaCaLamViec', '=', 'CaLamViec.MaCaLamViec')
                ->where('PhanCong.MaBacSi', $id)
                ->whereBetween('PhanCong.NgayLamViec', [$startDate->toDateString(), $endDate->toDateString()])
                ->select('PhanCong.*', 'CaLamViec.MoTa as CaLamViecMoTa')
                ->get();

            // Lấy lịch khám bệnh của bác sĩ
            $lichKhams = DB::table('LichKham')
                ->where('MaBacSi', $id)
                ->whereBetween('NgayKham', [$startDate->toDateString(), $endDate->toDateString()])
                ->get();

            $dates = [];
            $currentDate = $startDate->copy();
            while ($currentDate->lte($endDate)) {
                $dates[] = $currentDate->copy();
                $currentDate->addDay();
            }

            $schedule = [];
            foreach ($dates as $date) {
                $daySchedule = [];

                // Kiểm tra lịch phân công trong ngày
                $assignments = $phanCongs->where('NgayLamViec', $date->toDateString());
                foreach ($assignments as $assignment) {
                    $daySchedule[] = [
                        'date' => $date->format('d/m/Y'),
                        'status' => 'working',
                        'type' => 'assignment',
                        'details' => $assignment,
                    ];
                }



                // Nếu không có lịch phân công hoặc lịch khám bệnh trong ngày
                if (empty($daySchedule)) {
                    $daySchedule[] = [
                        'date' => $date->format('d/m/Y'),
                        'status' => 'off',
                        'type' => 'off',
                        'details' => null,
                    ];
                }

                $schedule = array_merge($schedule, $daySchedule);
            }

            return view('Duy_doctor_dashboard', [
                'doctor' => $doctor,
                'schedule' => $schedule,
                'hasSchedule' => !$phanCongs->isEmpty() || !$lichKhams->isEmpty(), // Kiểm tra cả hai loại lịch
                'message' => ($phanCongs->isEmpty() && $lichKhams->isEmpty())
                    ? 'Không có lịch làm việc trong tháng này.'
                    : '',
            ]);

        } catch (\Exception $e) {
            \Log::error('Error fetching doctor data: ' . $e->getMessage());
            return redirect()->route('home')->withErrors('Có lỗi xảy ra khi lấy thông tin bác sĩ.');
        }
    }

    // public function placeOrderOnline(Request $request)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $maKhachHang = session('user_id');
    //         if (!$maKhachHang) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Vui lòng đăng nhập để đặt hàng.'
    //             ], 401);
    //         }
    //         // Kiểm tra giỏ hàng
    //         $cartItems = session()->get('cart', []);
    //         if (empty($cartItems)) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Giỏ hàng trống'
    //             ], 400);
    //         }

    //         // Tính toán giá trị
    //         $totalProductAmount = array_sum(array_map(function ($item) {
    //             return $item['type'] === 'product' ? $item['price'] * $item['quantity'] : 0;
    //         }, $cartItems));

    //         $totalServiceAmount = array_sum(array_map(function ($item) {
    //             return $item['type'] === 'service' ? $item['price'] * $item['quantity'] : 0;
    //         }, $cartItems));

    //         $totalAppointmentAmount = array_sum(array_map(function ($item) {
    //             return $item['type'] === 'appointment' ? $item['price'] * $item['quantity'] : 0;
    //         }, $cartItems));

    //         $shippingFee = 2000;
    //         $tongTien = $totalProductAmount + $totalServiceAmount + $totalAppointmentAmount + $shippingFee;

    //         // Tạo hóa đơn
    //         $maHoaDon = DB::table('HoaDon')->insertGetId([
    //             'NgayXuatHoaDon' => now(),
    //             'TongTien' => $tongTien,
    //             'MaLichKham' => null,
    //             'MaKhachHang' => $maKhachHang,
    //             'TrangThai' => 'Chờ xác nhận',
    //             'LoaiGiaoDich' => "Banking"
    //         ]);

    //         // Thêm chi tiết hóa đơn
    //         foreach ($cartItems as $item) {
    //             DB::table('ChiTietHoaDon')->insert([
    //                 'SoLuong' => $item['quantity'],
    //                 'DonGia' => $item['price'],
    //                 'ThanhTien' => $item['price'] * $item['quantity'],
    //                 'MaVatTu' => $item['type'] === 'product' ? $item['id'] : null,
    //                 'MaDichVu' => $item['type'] === 'service' ? $item['id'] : null,
    //                 'MaThuCung' => $item['type'] === 'appointment' ? $item['id'] : null,
    //                 'MaHoaDon' => $maHoaDon
    //             ]);
    //         }


    //         session()->forget('cart');
    //         DB::commit();

    //         return response()->json([
    //             'success' => true,
    //             'order_id' => $maHoaDon,
    //             'message' => 'Đặt hàng thành công'
    //         ]);

    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }
    public function placeOrderOnline(Request $request)
{
    DB::beginTransaction();
    try {
        $maKhachHang = session('user_id');
        if (!$maKhachHang) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập để đặt hàng.'
            ], 401);
        }
        // Kiểm tra giỏ hàng
        $cartItems = session()->get('cart', []);
        if (empty($cartItems)) {
            return response()->json([
                'success' => false,
                'message' => 'Giỏ hàng trống'
            ], 400);
        }

        // Tính toán giá trị
        $totalProductAmount = array_sum(array_map(function ($item) {
            return $item['type'] === 'product' ? $item['discountedPrice'] * $item['quantity'] : 0; // Sử dụng discountedPrice
        }, $cartItems));

        $totalServiceAmount = array_sum(array_map(function ($item) {
            return $item['type'] === 'service' ? $item['discountedPrice'] * $item['quantity'] : 0; // Sử dụng discountedPrice
        }, $cartItems));

        $totalAppointmentAmount = array_sum(array_map(function ($item) {
            return $item['type'] === 'appointment' ? $item['price'] * $item['quantity'] : 0;
        }, $cartItems));

        $shippingFee = 1000;
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

        // Tạo hóa đơn
        $maHoaDon = DB::table('HoaDon')->insertGetId([
            'NgayXuatHoaDon' => now(),
            'TongTien' => $tongTien,
            'MaLichKham' => $maLichKham, // Sử dụng $maLichKham vừa insert
            'MaKhachHang' => $maKhachHang,
            'TrangThai' => 'Chờ xác nhận',
            'LoaiGiaoDich' => "Banking"
        ]);

        // Thêm chi tiết hóa đơn
        foreach ($cartItems as $item) {
            DB::table('ChiTietHoaDon')->insert([
                'SoLuong' => $item['quantity'],
                'DonGia' => $item['type'] === 'product' || $item['type'] === 'service' ? $item['discountedPrice'] : $item['price'], // Sử dụng discountedPrice cho sản phẩm và dịch vụ
                'ThanhTien' => ($item['type'] === 'product' || $item['type'] === 'service') ? $item['discountedPrice'] * $item['quantity'] : $item['price'] * $item['quantity'],
                'MaVatTu' => $item['type'] === 'product' ? $item['id'] : null,
                'MaDichVu' => $item['type'] === 'service' ? $item['id'] : null,
                'MaThuCung' => $item['type'] === 'appointment' ? $item['pet_id'] : null, // Sử dụng pet_id từ session
                'MaHoaDon' => $maHoaDon
            ]);
        }


        session()->forget('cart');
        DB::commit();

        return response()->json([
            'success' => true,
            'order_id' => $maHoaDon,
            'message' => 'Đặt hàng thành công'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Display the work assignment schedule for the specified employee.
     *
     * @param  int  $id  Employee ID (MaNhanVien)
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showWorkSchedule($id, $type = 'month')
    {
        // Validate inputs
        if (!is_numeric($id) || $id <= 0) {
            return redirect()->route('home')->withErrors('ID nhân viên không hợp lệ.');
        }

        if (!in_array($type, ['week', 'month'])) {
            return redirect()->route('home')->withErrors('Loại lịch không hợp lệ.');
        }

        try {
             // Fetch employee data
             $employee = DB::table('NhanVien')
             ->where('MaNhanVien', $id)
             ->first();

            if (!$employee) {
                return redirect()->route('home')->withErrors('Không tìm thấy nhân viên.');
            }

            // Define date range based on type
            if ($type === 'week') {
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
            } else {
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
            }

            $phanCongs = DB::table('PhanCong')
                ->join('CaLamViec', 'PhanCong.MaCaLamViec', '=', 'CaLamViec.MaCaLamViec')
                ->where('PhanCong.MaNhanVien', $id)
                ->whereBetween('PhanCong.NgayLamViec', [$startDate->toDateString(), $endDate->toDateString()])
                ->select('PhanCong.*', 'CaLamViec.MoTa as CaLamViecMoTa')
                // Thêm sắp xếp giảm dần theo ngày
                ->orderBy('PhanCong.NgayLamViec', 'desc')
                ->get();

            $dates = [];
            $currentDate = $startDate->copy();
            while ($currentDate->lte($endDate)) {
                $dates[] = $currentDate->copy();
                $currentDate->addDay();
            }

            // Sắp xếp ngày giảm dần (chỉ áp dụng cho view month)
            if ($type === 'month') {
                $dates = array_reverse($dates);
            }

            $schedule = [];
            foreach ($dates as $date) {
                $assignment = $phanCongs->firstWhere('NgayLamViec', $date->toDateString());
                if ($assignment) {
                    $schedule[] = [
                        'date' => $date->format('d/m/Y'),
                        'status' => 'working',
                        'details' => $assignment,
                    ];
                } else {
                    $schedule[] = [
                        'date' => $date->format('d/m/Y'),
                        'status' => 'off',
                        'details' => null,
                    ];
                }
            }

            return view('Duy_employee_dashboard', [
                'employee' => $employee,
                'schedule' => $schedule,
                'hasSchedule' => !$phanCongs->isEmpty(),
                'type' => $type,
                'message' => $phanCongs->isEmpty() ? 'Không có lịch phân công công việc trong ' . ($type === 'week' ? 'tuần này.' : 'tháng này.') : '',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching work schedule: ' . $e->getMessage());

            return redirect()->route('home')->withErrors('Có lỗi xảy ra khi lấy lịch phân công công việc. Vui lòng thử lại sau.');
        }
    }



    public function adminIndex(Request $request)
    {
        try {
            // Lấy tất cả các phân công công việc cùng thông tin liên quan
            $assignments = DB::table('PhanCong')
                ->join('NhanVien', 'PhanCong.MaNhanVien', '=', 'NhanVien.MaNhanVien')
                ->join('CaLamViec', 'PhanCong.MaCaLamViec', '=', 'CaLamViec.MaCaLamViec')
                ->leftJoin('DichVu', 'PhanCong.MaDichVu', '=', 'DichVu.MaDichVu')
                ->leftJoin('BacSi', 'PhanCong.MaBacSi', '=', 'BacSi.MaBacSi')
                ->select(
                    'PhanCong.MaPhanCong',
                    'NhanVien.TenNhanVien',
                    'PhanCong.LoaiCongViec',
                    'PhanCong.NgayLamViec',
                    'CaLamViec.MoTa as CaLamViecMoTa',
                    'PhanCong.TrangThai',
                    'DichVu.TenDichVu',
                    'BacSi.HoTen as BacSiHoTen'
                )
                ->orderBy('PhanCong.NgayLamViec', 'desc')
                ->paginate(10);

            return view('Duy_admin_phancongCV', ['assignments' => $assignments]);
        } catch (\Exception $e) {
            \Log::error('Error fetching assignments: ' . $e->getMessage());
            return redirect()->route('index')
                ->withErrors('Có lỗi xảy ra khi lấy danh sách phân công công việc.');
        }
    }

    /**
     * Hiển thị form thêm mới phân công công việc của Admin.
     *
     * @return \Illuminate\View\View
     */
    public function adminCreate()
    {
        try {
            // Lấy danh sách nhân viên, ca làm việc, dịch vụ và bác sĩ để chọn trong form
            $employees = DB::table('NhanVien')->orderBy('TenNhanVien')->get();
            $shifts = DB::table('CaLamViec')->orderBy('MaCaLamViec')->get();
            $services = DB::table('DichVu')->orderBy('TenDichVu')->get();
            $vets = DB::table('BacSi')->orderBy('HoTen')->get();

            return view('Duy_admin_createCV', [
                'employees' => $employees,
                'shifts' => $shifts,
                'services' => $services,
                'vets' => $vets
            ]);
        } catch (\Exception $e) {
            \Log::error('Error loading create assignment form: ' . $e->getMessage());
            return redirect()->route('admin.assignments.index')
                             ->withErrors('Có lỗi xảy ra khi tải form phân công công việc mới.');
        }
    }

    /**
     * Xử lý lưu phân công công việc mới của Admin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminStore(Request $request)
    {
        // Xác thực dữ liệu nhập vào
        $validated = $request->validate([
            'MaNhanVien' => 'required|integer|exists:NhanVien,MaNhanVien',
            'LoaiCongViec' => 'required|string|max:255',
            'NgayLamViec' => 'required|date',
            'MaCaLamViec' => 'required|integer|exists:CaLamViec,MaCaLamViec',
            'TrangThai' => 'required|string|max:50',
            'MaDichVu' => 'nullable|integer|exists:DichVu,MaDichVu',
            'MaBacSi' => 'nullable|integer|exists:BacSi,MaBacSi',
        ], [
            'MaNhanVien.required' => 'Vui lòng chọn nhân viên.',
            'MaNhanVien.exists' => 'Nhân viên không tồn tại.',
            'LoaiCongViec.required' => 'Vui lòng nhập loại công việc.',
            'NgayLamViec.required' => 'Vui lòng chọn ngày làm việc.',
            'MaCaLamViec.required' => 'Vui lòng chọn ca làm việc.',
            'TrangThai.required' => 'Vui lòng nhập trạng thái.',
            'MaDichVu.exists' => 'Dịch vụ không tồn tại.',
            'MaBacSi.exists' => 'Bác sĩ không tồn tại.',
        ]);

        try {
            // Kiểm tra xem nhân viên đã được phân công vào ca này chưa
            $existingEmployeeAssignment = DB::table('PhanCong')
                ->where('MaNhanVien', $validated['MaNhanVien'])
                ->where('NgayLamViec', $validated['NgayLamViec'])
                ->where('MaCaLamViec', $validated['MaCaLamViec'])
                ->first();

            if ($existingEmployeeAssignment) {
                return redirect()->route('admin.assignments.create')
                    ->withErrors('Nhân viên đã được phân công vào ca làm việc này!')
                    ->withInput();
            }

            // Kiểm tra xem bác sĩ đã được phân công vào ca này chưa (nếu có chọn bác sĩ)
            if (!empty($validated['MaBacSi'])) {
                $existingVetAssignment = DB::table('PhanCong')
                    ->where('MaBacSi', $validated['MaBacSi'])
                    ->where('NgayLamViec', $validated['NgayLamViec'])
                    ->where('MaCaLamViec', $validated['MaCaLamViec'])
                    ->first();

                if ($existingVetAssignment) {
                    return redirect()->route('admin.assignments.create')
                        ->withErrors('Bác sĩ đã được phân công vào ca làm việc này!')
                        ->withInput();
                }
            }

            // Nếu không có trùng lịch, tiến hành thêm phân công mới
            DB::table('PhanCong')->insert([
                'LoaiCongViec' => $validated['LoaiCongViec'],
                'NgayPhanCong' => Carbon::now()->toDateString(),
                'TrangThai' => $validated['TrangThai'],
                'MaDichVu' => $validated['MaDichVu'] ?? null,
                'MaNhanVien' => $validated['MaNhanVien'],
                'MaBacSi' => $validated['MaBacSi'] ?? null,
                'MaCaLamViec' => $validated['MaCaLamViec'],
                'NgayLamViec' => $validated['NgayLamViec'],
            ]);

            return redirect()->route('admin.assignments.index')
                ->with('success', 'Phân công công việc đã được thêm thành công.');

        } catch (\Exception $e) {
            \Log::error('Error storing assignment: ' . $e->getMessage());
            return redirect()->route('admin.assignments.create')
                ->withErrors('Có lỗi xảy ra khi lưu phân công công việc mới.')
                ->withInput();
        }
    }


    /**
     * Hiển thị form chỉnh sửa phân công công việc của Admin.
     *
     * @param  int  $id  MaPhanCong
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function adminEdit($id)
    {
        try {
            // Lấy thông tin phân công công việc cần chỉnh sửa
            $assignment = DB::table('PhanCong')->where('MaPhanCong', $id)->first();

            if (!$assignment) {
                return redirect()->route('admin.assignments.index')
                                 ->withErrors('Không tìm thấy phân công công việc.');
            }

            // Lấy danh sách nhân viên, dịch vụ, bác sĩ
            $employees = DB::table('NhanVien')->orderBy('TenNhanVien')->get();
            $services = DB::table('DichVu')->orderBy('TenDichVu')->get();
            $vets = DB::table('BacSi')->orderBy('HoTen')->get();

            // Lấy tất cả ca làm việc
            $shifts = DB::table('CaLamViec')->orderBy('MaCaLamViec')->get();

            return view('Duy_admin_editCV', [
                'assignment' => $assignment,
                'employees' => $employees,
                'services' => $services,
                'vets' => $vets,
                'shifts' => $shifts
            ]);
        } catch (\Exception $e) {
            \Log::error('Error loading edit assignment form: ' . $e->getMessage());
            return redirect()->route('admin.assignments.index')
                             ->withErrors('Có lỗi xảy ra khi tải form chỉnh sửa phân công công việc.');
        }
    }

    public function checkAvailableDoctors(Request $request)
    {
        $date = $request->input('NgayLamViec');
        $shift = $request->input('MaCaLamViec');

        $availableDoctors = DB::table('BacSi')
            ->leftJoin('PhanCong', function ($join) use ($date, $shift) {
                $join->on('BacSi.MaBacSi', '=', 'PhanCong.MaBacSi')
                    ->where('PhanCong.NgayLamViec', $date)
                    ->where('PhanCong.MaCaLamViec', $shift);
            })
            ->whereNull('PhanCong.MaPhanCong') // Bác sĩ chưa có phân công
            ->select('BacSi.MaBacSi', 'BacSi.HoTen')
            ->get();

        return response()->json($availableDoctors);
    }

        public function checkAvailableTime(Request $request)
        {
            $ngayKham = $request->input('NgayKham');
            $gioKham = $request->input('GioKham');
            $maBacSi = $request->input('MaBacSi');

            // Xử lý trường hợp không có GioKham
            if (empty($gioKham)) {
                return response()->json([
                    'available' => false,
                    'message' => 'Vui lòng nhập giờ khám.'
                ]);
            }

            // Kiểm tra MaBacSi có tồn tại không
            $bacSi = DB::table('BacSi')->where('MaBacSi', $maBacSi)->first();
            if (!$bacSi) {
                return response()->json([
                    'available' => false,
                    'message' => 'Mã bác sĩ không tồn tại.'
                ]);
            }

            // Convert thành Carbon instance
            $gioKhamCarbon = Carbon::parse("$ngayKham $gioKham");

            // 1. Kiểm tra giờ làm việc (8:00-17:00)
            $hour = (int)$gioKhamCarbon->format('H');
            $minute = (int)$gioKhamCarbon->format('i');

            if ($hour < 8 || $hour >= 17) {
                return response()->json([
                    'available' => false,
                    'message' => 'Thời gian khám phải từ 8:00 đến 17:00'
                ]);
            }

            // 2. Kiểm tra phải đúng khung giờ 30 phút
            if ($minute % 30 !== 0) {
                return response()->json([
                    'available' => false,
                    'message' => 'Thời gian khám phải đặt theo khung giờ 30 phút (VD: 8:00, 8:30, 9:00...)'
                ]);
            }

            // 3. Kiểm tra giờ nghỉ trưa (12:00-13:00)
            if ($hour === 12) {
                return response()->json([
                    'available' => false,
                    'message' => 'Không thể đặt lịch trong giờ nghỉ trưa (12:00 - 13:00)'
                ]);
            }

            try {
                // 4. Kiểm tra trùng lịch CHÍNH XÁC theo giờ
                $existingAppointment = DB::table('LichKham')
                    ->where('MaBacSi', $maBacSi)
                    ->where('NgayKham', $ngayKham)
                    ->where('GioKham', $gioKham)
                    ->first();

                if ($existingAppointment) {
                    return response()->json([
                        'available' => false,
                        'message' => "Bác sĩ {$bacSi->HoTen} đã có lịch khám vào $gioKham ngày $ngayKham, vui lòng chọn giờ khác"
                    ]);
                }

                // 5. Kiểm tra lịch liền trước và sau 30 phút
                $gioTruoc = $gioKhamCarbon->copy()->subMinutes(30)->format('H:i:s');
                $gioSau = $gioKhamCarbon->copy()->addMinutes(30)->format('H:i:s');

                $lichLienKe = DB::table('LichKham')
                    ->where('MaBacSi', $maBacSi)
                    ->where('NgayKham', $ngayKham)
                    ->whereIn('GioKham', [$gioTruoc, $gioSau])
                    ->first();

                if ($lichLienKe) {
                    $gioLienKe = $lichLienKe->GioKham;
                    return response()->json([
                        'available' => false,
                        'message' => "Bác sĩ {$bacSi->HoTen} đã có lịch khám liền kề vào lúc {$gioLienKe} ngày {$ngayKham}, vui lòng chọn giờ cách ít nhất 30 phút"
                    ]);
                }

                // 6. Kiểm tra bác sĩ có trong ca làm việc vào ngày đó không
                $coCaLamViec = DB::table('PhanCong')
                    ->where('MaBacSi', $maBacSi)
                    ->where('NgayLamViec', $ngayKham)
                    ->exists();

                if (!$coCaLamViec) {
                    return response()->json([
                        'available' => false,
                        'message' => "Bác sĩ {$bacSi->HoTen} không có ca làm việc vào ngày {$ngayKham}"
                    ]);
                }

                return response()->json([
                    'available' => true,
                    'message' => 'Thời gian khả dụng'
                ]);

            } catch (\Exception $e) {
                \Log::error('Lỗi khi kiểm tra thời gian khả dụng: ' . $e->getMessage());
                return response()->json([
                    'available' => false,
                    'message' => 'Có lỗi xảy ra khi kiểm tra thời gian khả dụng. Vui lòng thử lại sau.'
                ], 500); // Trả về lỗi 500
            }
        }


    public function getAvailableVets(Request $request)
    {
        $selectedDate = $request->input('NgayLamViec');

        // Lấy danh sách bác sĩ chưa có phân công vào ngày được chọn
        $availableVets = DB::table('BacSi')
            ->whereNotIn('MaBacSi', function ($query) use ($selectedDate) {
                $query->select('MaBacSi')
                      ->from('PhanCong')
                      ->where('NgayLamViec', $selectedDate);
            })
            ->orderBy('HoTen')
            ->get();

        return response()->json($availableVets);
    }


    /**
     * Xử lý cập nhật phân công công việc của Admin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id  MaPhanCong
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminUpdate(Request $request, $id)
    {
        // Xác thực dữ liệu nhập vào
        $validated = $request->validate([
            'MaNhanVien' => 'required|integer|exists:NhanVien,MaNhanVien',
            'LoaiCongViec' => 'required|string|max:255',
            'NgayLamViec' => 'required|date',
            'MaCaLamViec' => 'required|integer|exists:CaLamViec,MaCaLamViec',
            'TrangThai' => 'required|string|max:50',
            'MaDichVu' => 'nullable|integer|exists:DichVu,MaDichVu',
            'MaBacSi' => 'nullable|integer|exists:BacSi,MaBacSi',
        ], [
            'MaNhanVien.required' => 'Vui lòng chọn nhân viên.',
            'MaNhanVien.exists' => 'Nhân viên không tồn tại.',
            'LoaiCongViec.required' => 'Vui lòng nhập loại công việc.',
            'NgayLamViec.required' => 'Vui lòng chọn ngày làm việc.',
            'MaCaLamViec.required' => 'Vui lòng chọn ca làm việc.',
            'TrangThai.required' => 'Vui lòng nhập trạng thái.',
            'MaDichVu.exists' => 'Dịch vụ không tồn tại.',
            'MaBacSi.exists' => 'Bác sĩ không tồn tại.',
        ]);

        try {
            // Kiểm tra xem bác sĩ có bị trùng lịch không
            if (!empty($validated['MaBacSi'])) {
                $isConflict = DB::table('PhanCong')
                    ->where('NgayLamViec', $validated['NgayLamViec'])
                    ->where('MaCaLamViec', $validated['MaCaLamViec'])
                    ->where('MaBacSi', $validated['MaBacSi'])
                    ->where('MaPhanCong', '!=', $id) // Loại bỏ phân công hiện tại
                    ->exists();

                if ($isConflict) {
                    return redirect()->back()
                        ->withErrors('Bác sĩ đã được phân công cho ca làm việc này trong ngày. Vui lòng chọn ca khác hoặc bác sĩ khác.')
                        ->withInput();
                }
            }

            // Cập nhật thông tin phân công
            DB::table('PhanCong')
                ->where('MaPhanCong', $id)
                ->update([
                    'LoaiCongViec' => $validated['LoaiCongViec'],
                    'TrangThai' => $validated['TrangThai'] ?? 'Đề xuất', // Mặc định là "Đề xuất"
                    'MaDichVu' => $validated['MaDichVu'] ?? null,
                    'MaNhanVien' => $validated['MaNhanVien'],
                    'MaBacSi' => $validated['MaBacSi'] ?? null,
                    'MaCaLamViec' => $validated['MaCaLamViec'],
                    'NgayLamViec' => $validated['NgayLamViec'],
                ]);

            return redirect()->route('admin.assignments.index')
                             ->with('success', 'Phân công công việc đã được cập nhật thành công.');
        } catch (\Exception $e) {
            \Log::error('Error updating assignment: ' . $e->getMessage());
            return redirect()->route('admin.assignments.edit', ['id' => $id])
                             ->withErrors('Có lỗi xảy ra khi cập nhật phân công công việc.')
                             ->withInput();
        }
    }


    public function adminSearchAssignments(Request $request)
    {
        // Lấy từ khóa tìm kiếm từ request
        $keyword = $request->input('keyword');
        $month = $request->input('month');

        // Khởi tạo query
        $query = DB::table('PhanCong')
            ->join('BacSi', 'PhanCong.MaBacSi', '=', 'BacSi.MaBacSi')
            ->join('NhanVien', 'PhanCong.MaNhanVien', '=', 'NhanVien.MaNhanVien')
            ->join('CaLamViec', 'PhanCong.MaCaLamViec', '=', 'CaLamViec.MaCaLamViec')
            ->leftJoin('DichVu', 'PhanCong.MaDichVu', '=', 'DichVu.MaDichVu') // Thêm liên kết với bảng DichVu
            ->select(
                'PhanCong.*',
                'BacSi.HoTen as BacSiHoTen',
                'NhanVien.TenNhanVien',
                'CaLamViec.MoTa as CaLamViecMoTa',
                'DichVu.TenDichVu as TenDichVu' // Lấy tên dịch vụ
            );

        // Nếu có từ khóa, tìm theo tên bác sĩ
        if ($keyword) {
            $query->where('BacSi.HoTen', 'like', '%' . $keyword . '%');
        }

        // Nếu có tháng, tìm theo tháng làm việc
        if ($month) {
            $query->whereMonth('PhanCong.NgayLamViec', '=', $month);
        }

        // Lấy kết quả với phân trang
        $assignments = $query->orderBy('PhanCong.NgayLamViec', 'desc')->paginate(10);

        return view('Duy_admin_phancongCV', compact('assignments', 'keyword', 'month'));
    }
        public function thongtinDieuTri($id)
        {
            // Lấy thông tin thú cưng
            $pet = DB::table('ThuCung')
                ->where('MaThuCung', $id)
                ->first();

            if (!$pet) {
                return abort(404); // Hoặc xử lý lỗi theo cách khác
            }

            // Lấy thông tin khách hàng
            $khachHang = DB::table('KhachHang')
                ->where('MaKhachHang', $pet->MaKhachHang)
                ->first();

            // Lấy thông tin giống loài
            $giongLoai = DB::table('GiongLoai')
                ->where('MaGiongLoai', $pet->MaGiongLoai)
                ->first();

            // Lấy lịch sử điều trị
            $lichKhams = DB::table('LichKham')
                ->join('BacSi', 'LichKham.MaBacSi', '=', 'BacSi.MaBacSi')
                ->where('LichKham.MaThuCung', $id)
                ->select('LichKham.*', 'BacSi.HoTen as BacSiHoTen')
                ->get();

            // Gán thông tin khách hàng và giống loài vào đối tượng thú cưng
            $pet->khachHang = $khachHang;
            $pet->giongLoai = $giongLoai;

            // Trả về view
            return view('Duy_doctor_thongtinDIeuTriThuCung', [
                'pet' => $pet,
                'lichKhams' => $lichKhams,
            ]);
        }

        public function doctorUpdate(Request $request, $id)
        {
            // Xác thực dữ liệu nhập vào
            $validated = $request->validate([
                'MaNhanVien' => 'required|integer|exists:NhanVien,MaNhanVien',
                'LoaiCongViec' => 'required|string|max:255',
                'NgayLamViec' => 'required|date',
                'MaCaLamViec' => 'required|integer|exists:CaLamViec,MaCaLamViec',
                'TrangThai' => 'required|string|max:50',
                'MaDichVu' => 'nullable|integer|exists:DichVu,MaDichVu',
                'MaBacSi' => 'nullable|integer|exists:BacSi,MaBacSi',
            ], [
                'MaNhanVien.required' => 'Vui lòng chọn nhân viên.',
                'MaNhanVien.exists' => 'Nhân viên không tồn tại.',
                'LoaiCongViec.required' => 'Vui lòng nhập loại công việc.',
                'NgayLamViec.required' => 'Vui lòng chọn ngày làm việc.',
                'MaCaLamViec.required' => 'Vui lòng chọn ca làm việc.',
                'TrangThai.required' => 'Vui lòng nhập trạng thái.',
                'MaDichVu.exists' => 'Dịch vụ không tồn tại.',
                'MaBacSi.exists' => 'Bác sĩ không tồn tại.',
            ]);

            try {
                // Kiểm tra xem bác sĩ có bị trùng lịch không
                if (!empty($validated['MaBacSi'])) {
                    $isConflict = DB::table('PhanCong')
                        ->where('NgayLamViec', $validated['NgayLamViec'])
                        ->where('MaCaLamViec', $validated['MaCaLamViec'])
                        ->where('MaBacSi', $validated['MaBacSi'])
                        ->where('MaPhanCong', '!=', $id) // Loại bỏ phân công hiện tại
                        ->exists();

                    if ($isConflict) {
                        return redirect()->back()
                            ->withErrors('Bác sĩ đã được phân công cho ca làm việc này trong ngày. Vui lòng chọn ca khác hoặc bác sĩ khác.')
                            ->withInput();
                    }
                }

                // Cập nhật thông tin phân công
                DB::table('PhanCong')
                    ->where('MaPhanCong', $id)
                    ->update([
                        'LoaiCongViec' => $validated['LoaiCongViec'],
                        'TrangThai' => $validated['TrangThai'] ?? 'Đề xuất', // Mặc định là "Đề xuất"
                        'MaDichVu' => $validated['MaDichVu'] ?? null,
                        'MaNhanVien' => $validated['MaNhanVien'],
                        'MaBacSi' => $validated['MaBacSi'] ?? null,
                        'MaCaLamViec' => $validated['MaCaLamViec'],
                        'NgayLamViec' => $validated['NgayLamViec'],
                    ]);

                    return redirect()->route('doctor.update', ['id' => $validated['MaBacSi']])
                            ->with('success', 'Phân công công việc đã được cập nhật thành công.');
            } catch (\Exception $e) {
                \Log::error('Error updating assignment: ' . $e->getMessage());
                return redirect()->route('admin.assignments.edit', ['id' => $id])
                                 ->withErrors('Có lỗi xảy ra khi cập nhật phân công công việc.')
                                 ->withInput();
            }
        }
        public function capNhatGhiChu(Request $request, $id)
        {
            // Validate dữ liệu từ form nếu cần
            $request->validate([
                'ChuanDoan' => 'required|string', // Kiểm tra xem ChuanDoan có được gửi lên và là chuỗi hay không
            ]);

            try {
                // Cập nhật ChuanDoan và TrangThai trong bảng LichKham
                DB::table('LichKham')
                    ->where('MaLichKham', $id)
                    ->update([
                        'ChuanDoan' => $request->input('ChuanDoan'),
                        'TrangThai' => 'Đã khám',
                    ]);

                // Chuyển hướng về trang chi tiết thú cưng hoặc trang khác tùy ý
                return redirect()->route('petData', ['id' => $request->input('MaThuCung')]);

            } catch (\Exception $e) {
                // Xử lý lỗi nếu có
                return redirect()->back()->withErrors(['error' => 'Lỗi cập nhật ghi chú.']);
            }
        }

    /**
     * Xóa phân công công việc của Admin.
     *
     * @param  int  $id  MaPhanCong
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminDetailLichKham($id)
{
    try {
        // Lấy thông tin phân công
        $assignment = DB::table('PhanCong')
            ->select('PhanCong.*',
                    'BacSi.HoTen as TenBacSi',
                    'BacSi.MaBacSi',
                    'DichVu.TenDichVu',
                    'CaLamViec.MoTa as CaLamViecMoTa')
            ->leftJoin('BacSi', 'PhanCong.MaBacSi', '=', 'BacSi.MaBacSi')
            ->leftJoin('DichVu', 'PhanCong.MaDichVu', '=', 'DichVu.MaDichVu')
            ->leftJoin('CaLamViec', 'PhanCong.MaCaLamViec', '=', 'CaLamViec.MaCaLamViec')
            ->where('PhanCong.MaPhanCong', $id)
            ->first();

        if (!$assignment) {
            \Log::warning('Assignment not found for ID: ' . $id);
            return redirect()->route('admin.assignments.index')
                           ->withErrors('Không tìm thấy thông tin phân công.');
        }

        // Lấy danh sách lịch khám
        $lichKhamTrongNgay = DB::table('LichKham')
            ->select('LichKham.*',
                    'ThuCung.TenThuCung')
            ->leftJoin('ThuCung', 'LichKham.MaThuCung', '=', 'ThuCung.MaThuCung')
            ->where('LichKham.NgayKham', $assignment->NgayLamViec)
            ->where('LichKham.MaBacSi', $assignment->MaBacSi)
            ->orderBy('LichKham.GioKham', 'asc')
            ->get();

        // Log để debug
        \Log::info('Query Parameters:', [
            'NgayLamViec' => $assignment->NgayLamViec,
            'MaBacSi' => $assignment->MaBacSi
        ]);

        \Log::info('Found appointments:', [
            'count' => $lichKhamTrongNgay->count(),
            'data' => $lichKhamTrongNgay
        ]);

        return view('Duy_admin_lichkhamtheoPhanCong', [
            'assignment' => $assignment,
            'lichKhamTrongNgay' => $lichKhamTrongNgay
        ]);

    } catch (\Exception $e) {
        \Log::error('Error in adminDetailLichKham: ' . $e->getMessage());
        \Log::error($e->getTraceAsString());
        return redirect()->route('admin.assignments.index')
                       ->withErrors('Có lỗi xảy ra khi xem chi tiết phân công.');
    }
}




    public function showDoctorScheduleById($maBacSi, Request $request)
    {
        // Validate that $maBacSi is a positive integer
        if (!is_numeric($maBacSi) || $maBacSi <= 0) {
            return redirect()->route('admin.assignments.index')
                             ->withErrors('Mã bác sĩ không hợp lệ.');
        }

        try {
            // Fetch doctor details
            $doctor = DB::table('BacSi')->where('MaBacSi', $maBacSi)->first();

            if (!$doctor) {
                return redirect()->route('admin.assignments.index')
                                 ->withErrors('Không tìm thấy bác sĩ với mã đã cung cấp.');
            }

            // Get selected date range: month or week
            $viewType = $request->input('view_type', 'month'); // default to 'month'
            $startDate = Carbon::now();
            $endDate = Carbon::now();

            if ($viewType == 'month') {
                // Set date range for the current month
                $startDate = $startDate->startOfMonth();
                $endDate = $endDate->endOfMonth();
            } elseif ($viewType == 'week') {
                // Set date range for the current week (from Monday to Sunday)
                $startDate = $startDate->startOfWeek();
                $endDate = $endDate->endOfWeek();
            }

            // Fetch assignments within the selected date range
            $assignments = DB::table('PhanCong')
                ->join('CaLamViec', 'PhanCong.MaCaLamViec', '=', 'CaLamViec.MaCaLamViec')
                ->leftJoin('DichVu', 'PhanCong.MaDichVu', '=', 'DichVu.MaDichVu')
                ->where('PhanCong.MaBacSi', $maBacSi)
                ->whereBetween('PhanCong.NgayLamViec', [$startDate->toDateString(), $endDate->toDateString()])
                ->select(
                    'PhanCong.MaPhanCong',
                    'PhanCong.LoaiCongViec',
                    'PhanCong.NgayLamViec',
                    'CaLamViec.MoTa as TenCaLamViec',
                    'PhanCong.TrangThai',
                    'DichVu.TenDichVu'
                )
                ->orderBy('PhanCong.NgayLamViec', 'asc')
                ->get();

            // Organize assignments by date
            $schedule = [];
            foreach ($assignments as $assignment) {
                $date = Carbon::parse($assignment->NgayLamViec)->format('d/m/Y');
                $schedule[$date][] = [
                    'LoaiCongViec' => $assignment->LoaiCongViec,
                    'TenCaLamViec' => $assignment->TenCaLamViec,
                    'TrangThai' => $assignment->TrangThai,
                    'TenDichVu' => $assignment->TenDichVu,
                    'MaPhanCong' => $assignment->MaPhanCong, // Ensure MaPhanCong is included in the data
                ];
            }

            return view('duy_doctor_schedule_by_id', [
                'doctor' => $doctor,
                'schedule' => $schedule,
                'dateRange' => [
                    'start' => $startDate->format('d/m/Y'),
                    'end' => $endDate->format('d/m/Y')
                ],
                'viewType' => $viewType // Pass the selected view type (month/week) to the view
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching doctor schedule: ' . $e->getMessage());
            return redirect()->route('admin.assignments.index')
                             ->withErrors('Có lỗi xảy ra khi lấy lịch làm việc của bác sĩ.');
        }
    }
    public function confirmAssignment($id)
    {
        // Tìm lịch làm việc theo ID
        $assignment = DB::table('PhanCong')->where('MaPhanCong', $id)->first();

        if (!$assignment) {
            return redirect()->back()->with('error', 'Lịch làm việc không tồn tại.');
        }

        // Cập nhật trạng thái thành "Xác nhận"
        DB::table('PhanCong')->where('MaPhanCong', $id)->update([
            'TrangThai' => 'Làm việc'
        ]);

        return redirect()->back()->with('success', 'Lịch làm việc đã được xác nhận.');
    }

    public function rejectAssignment($id)
    {
       $assignment = DB::table('PhanCong')->where('MaPhanCong', $id)->first();

       if (!$assignment) {
       return redirect()->back()->with('error', 'Lịch làm việc không tồn tại.');
       }
       DB::table('PhanCong')->where('MaPhanCong', $id)->delete();

       return redirect()->back()->with('success', 'Lịch làm việc đã bị từ chối.');
    }




    // Show all doctors (list view)
    public function showDoctors()
    {
        try {
            $doctors = DB::table('BacSi')
                ->where('Deleted', false)
                ->get();

            return view('Duy_admin_doctor_view', [
                'doctors' => $doctors
            ]);

        } catch (\Exception $e) {
            return redirect()->route('admin.doctors.index')
                ->withErrors('Có lỗi xảy ra khi lấy danh sách bác sĩ: ' . $e->getMessage());
        }
    }


    // Show doctor details for editing
    public function editDoctor($maBacSi)
    {
        try {
            $doctor = DB::table('BacSi')->where('MaBacSi', $maBacSi)->first();
            if (!$doctor) {
                return redirect()->route('admin.doctors.index')->withErrors('Không tìm thấy bác sĩ.');
            }
            return view('Duy_admin_doctor_edit', ['doctor' => $doctor]);
        } catch (\Exception $e) {
            return redirect()->route('admin.doctors.index')->withErrors('Có lỗi xảy ra khi lấy thông tin bác sĩ.');
        }
    }

    public function updateDoctor(Request $request, $maBacSi)
    {
        try {
            $validated = $request->validate([
                'HoTen' => 'required|string|max:100',
                'ChuyenMon' => 'required|string|max:255',
                'NgaySinh' => 'required|date',
                'GioiTinh' => 'required|string|max:10',
                'SDT' => 'required|string|max:15',
                'TaiKhoan' => 'required|string|max:50',
                'MatKhau' => 'nullable|string|max:255', // Sửa thành nullable vì có thể không cập nhật mật khẩu
                'LuongTheoGio' => 'required|numeric',
                'Email' => 'required|email|max:100',
            ]);

            // Tạo mảng dữ liệu cập nhật
            $updateData = [
                'HoTen' => $validated['HoTen'],
                'ChuyenMon' => $validated['ChuyenMon'],
                'NgaySinh' => $validated['NgaySinh'],
                'GioiTinh' => $validated['GioiTinh'],
                'SDT' => $validated['SDT'],
                'TaiKhoan' => $validated['TaiKhoan'],
                'LuongTheoGio' => $validated['LuongTheoGio'],
                'Email' => $validated['Email']
            ];

            // Chỉ cập nhật mật khẩu nếu người dùng nhập mật khẩu mới
            if (!empty($validated['MatKhau'])) {
                $updateData['MatKhau'] = Hash::make($validated['MatKhau']);
            }

            // Cập nhật thông tin
            DB::table('BacSi')
                ->where('MaBacSi', $maBacSi)
                ->update($updateData);

            return redirect()->route('admin.doctors.index')
                ->with('success', 'Thông tin bác sĩ đã được cập nhật thành công.');
        } catch (\Exception $e) {
            return redirect()->route('admin.doctors.index')
                ->withErrors('Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    // Show add new doctor form
    public function createDoctor()
    {
        return view('Duy_admin_doctor_create');
    }

    // Store a new doctor in the database
    public function storeDoctor(Request $request)
    {
        try {
            // Validation với các quy tắc chi tiết
            $validator = Validator::make($request->all(), [
                'HoTen' => 'required|string|max:100|regex:/^[\pL\s]+$/u',
                'ChuyenMon' => 'required|string|max:255',
                'NgaySinh' => [
                    'required',
                    'date',
                    function ($attribute, $value, $fail) {
                        $age = Carbon::parse($value)->age;
                        if ($age < 22 || $age > 70) {
                            $fail('Tuổi của bác sĩ phải từ 22 đến 70.');
                        }
                    },
                ],
                'GioiTinh' => 'required|in:Nam,Nữ,Khác',
                'SDT' => [
                    'required',
                    'string',
                    'max:15',
                    'regex:/^(0|\+84)[0-9]{9,10}$/',
                    'unique:BacSi,SDT'
                ],
                'TaiKhoan' => 'required|string|max:50|unique:BacSi,TaiKhoan',
                'MatKhau' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/'
                ],
                'LuongTheoGio' => 'required|numeric|min:0',
                'Email' => 'required|email|max:100|unique:BacSi,Email',
            ], [
                // Custom error messages
                'HoTen.regex' => 'Họ tên chỉ được chứa chữ cái và khoảng trắng',
                'SDT.regex' => 'Số điện thoại không hợp lệ',
                'MatKhau.regex' => 'Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ, số và ký tự đặc biệt',
                'Email.unique' => 'Email này đã được sử dụng',
                'TaiKhoan.unique' => 'Tài khoản này đã tồn tại',
                // Thêm các message tùy chỉnh khác...
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Chuẩn hóa dữ liệu
            $hoTen = ucwords(strtolower($request->HoTen)); // Chuẩn hóa tên
            $email = strtolower($request->Email); // Email viết thường



            // Insert bác sĩ mới
            DB::table('BacSi')->insert([

                'HoTen' => $hoTen,
                'ChuyenMon' => $request->ChuyenMon,
                'NgaySinh' => $request->NgaySinh,
                'GioiTinh' => $request->GioiTinh,
                'SDT' => $request->SDT,
                'TaiKhoan' => $request->TaiKhoan,
                'MatKhau' => Hash::make($request->MatKhau),
                'LuongTheoGio' => $request->LuongTheoGio,
                'Email' => $email,
            ]);

            return redirect()
                ->route('admin.doctors.index')
                ->with('success', "Bác sĩ $hoTen đã được thêm thành công");

        } catch (\Exception $e) {
            \Log::error('Lỗi thêm bác sĩ: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withErrors('Có lỗi xảy ra khi thêm bác sĩ: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Delete a doctor
    public function deleteDoctor($maBacSi)
    {
        try {
            // Kiểm tra bác sĩ có tồn tại không
            $doctor = DB::table('BacSi')
                ->where('MaBacSi', $maBacSi)
                ->where('Deleted', false)
                ->first();

            if (!$doctor) {
                return redirect()->route('admin.doctors.index')
                    ->withErrors('Không tìm thấy bác sĩ hoặc bác sĩ đã bị xóa.');
            }

            // Cập nhật trường Deleted thành true
            DB::table('BacSi')
                ->where('MaBacSi', $maBacSi)
                ->update(['Deleted' => true]);

            return redirect()->route('admin.doctors.index')
                ->with('success', 'Bác sĩ đã được xóa thành công.');

        } catch (\Exception $e) {
            return redirect()->route('admin.doctors.index')
                ->withErrors('Có lỗi xảy ra khi xóa bác sĩ: ' . $e->getMessage());
        }
    }



    // Search doctors by ID or Name
    public function searchDoctor(Request $request)
    {
        try {
            $searchTerm = $request->input('searchTerm');

            // Kiểm tra nếu không có từ khóa tìm kiếm
            if (empty($searchTerm)) {
                return redirect()->route('admin.doctors.index')->withErrors('Vui lòng nhập từ khóa tìm kiếm.');
            }

            // Làm sạch và loại bỏ khoảng trắng thừa
            $searchTerm = trim($searchTerm);

            // Tìm kiếm bác sĩ theo mã hoặc tên
            $doctors = DB::table('BacSi')
                ->where('HoTen', 'like', '%' . $searchTerm . '%') // Tìm kiếm tên bác sĩ
                ->orWhere('MaBacSi', 'like', '%' . $searchTerm . '%') // Tìm kiếm theo mã bác sĩ
                ->get();

            // Nếu không tìm thấy bác sĩ nào
            if ($doctors->isEmpty()) {
                return redirect()->route('admin.doctors.index')->withErrors('Không tìm thấy bác sĩ.');
            }

            // Trả về kết quả tìm kiếm
            return view('Duy_admin_doctor_view', ['doctors' => $doctors]);

        } catch (\Exception $e) {
            // Nếu có lỗi xảy ra, trả về thông báo lỗi
            return redirect()->route('admin.doctors.index')->withErrors('Có lỗi xảy ra khi tìm kiếm bác sĩ: ' . $e->getMessage());
        }
    }


    // 1. Hiển thị danh sách thú cưng
    public function petList()
    {
        try {
            $pets = DB::table('ThuCung')
                ->join('KhachHang', 'ThuCung.MaKhachHang', '=', 'KhachHang.MaKhachHang')
                ->join('GiongLoai', 'ThuCung.MaGiongLoai', '=', 'GiongLoai.MaGiongLoai')
                ->select(
                    'ThuCung.MaThuCung',
                    'ThuCung.TenThuCung',
                    'ThuCung.GioiTinh',
                    'ThuCung.Tuoi',
                    'KhachHang.HoTen as TenChuSoHuu',
                    'GiongLoai.TenGiongLoai'
                )
                ->get();

            return view('pet_list', ['pets' => $pets]);
        } catch (\Exception $e) {
            \Log::error('Lỗi khi lấy danh sách thú cưng: ' . $e->getMessage());
            return redirect()->back()->withErrors('Không thể tải danh sách thú cưng.');
        }
    }

    public function searchPets(Request $request)
    {
        $searchTerm = $request->input('search');

        try {
            $pets = DB::table('ThuCung')
                ->join('KhachHang', 'ThuCung.MaKhachHang', '=', 'KhachHang.MaKhachHang')
                ->join('GiongLoai', 'ThuCung.MaGiongLoai', '=', 'GiongLoai.MaGiongLoai')
                ->select(
                    'ThuCung.MaThuCung',
                    'ThuCung.TenThuCung',
                    'ThuCung.GioiTinh',
                    'ThuCung.Tuoi',
                    'KhachHang.HoTen as TenChuSoHuu',
                    'GiongLoai.TenGiongLoai'
                )
                ->where('KhachHang.HoTen', 'LIKE', '%' . $searchTerm . '%')
                ->get();

            // Kiểm tra nếu không có thú cưng nào
            if ($pets->isEmpty()) {
                return view('pet_list', ['pets' => [], 'noPetsMessage' => "Không có thú cưng nào thuộc tên người dùng này."]);
            }

            return view('pet_list', ['pets' => $pets]);
        } catch (\Exception $e) {
            \Log::error('Lỗi khi tìm kiếm thú cưng: ' . $e->getMessage());
            return redirect()->back()->withErrors('Không thể tìm kiếm thú cưng.');
        }
    }

    public function createGiongLoaiForm() {
        // Lấy danh sách giống loài hiện có
        $giongLoaiList = DB::table('GiongLoai')->get();

        return view('Duy_loaiPet_create', [
            'giongLoaiList' => $giongLoaiList
        ]);
    }

    public function saveGiongLoai(Request $request) {
        $tenGiongLoai = trim($request->input('TenGiongLoai'));

        // Validate
        if (empty($tenGiongLoai)) {
            return redirect()->back()->with('error', 'Tên giống loài không được để trống');
        }

        try {
            // Kiểm tra trùng tên
            $exists = DB::table('GiongLoai')
                ->where('TenGiongLoai', $tenGiongLoai)
                ->exists();

            if ($exists) {
                return redirect()->back()->with('error', 'Giống loài đã tồn tại');
            }

            // Thêm mới
            $id = DB::table('GiongLoai')->insertGetId([
                'TenGiongLoai' => $tenGiongLoai,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return redirect()->route('giong-loai.create')->with('success', 'Thêm giống loài thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    // Phương thức xóa giống loài
    public function deleteGiongLoai($id) {
        try {
            DB::table('GiongLoai')->where('MaGiongLoai', $id)->delete();
            return redirect()->route('giong-loai.create')->with('success', 'Xóa giống loài thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    public function searchGiongLoai(Request $request) {
        $search = $request->input('search');

        $giongLoai = DB::table('GiongLoai')
                       ->where('TenGiongLoai', 'LIKE', "%{$search}%")
                       ->get();

        return response()->json($giongLoai);
    }



    public function petDetails($id)
    {
        try {
            // Validate ID
            if (!is_numeric($id) || $id <= 0) {
                return redirect()->back()->withErrors('Mã thú cưng không hợp lệ.');
            }

            // Truy vấn chi tiết thú cưng
            $pet = DB::table('ThuCung')
                ->join('KhachHang', 'ThuCung.MaKhachHang', '=', 'KhachHang.MaKhachHang')
                ->join('GiongLoai', 'ThuCung.MaGiongLoai', '=', 'GiongLoai.MaGiongLoai')
                ->where('ThuCung.MaThuCung', $id)
                ->first();

            if (!$pet) {
                return redirect()->back()->withErrors('Không tìm thấy thông tin thú cưng.');
            }

            // Lấy danh sách khách hàng và giống loài để form
            $customers = DB::table('KhachHang')->select('MaKhachHang', 'HoTen')->get();
            $breeds = DB::table('GiongLoai')->select('MaGiongLoai', 'TenGiongLoai')->get();

            return view('pet_details', [
                'pet' => $pet,
                'customers' => $customers,
                'breeds' => $breeds
            ]);
        } catch (\Exception $e) {
            \Log::error('Lỗi khi lấy chi tiết thú cưng: ' . $e->getMessage());
            return redirect()->back()->withErrors('Có lỗi xảy ra khi tải thông tin thú cưng.');
        }
    }

    // 4, 5 & 6. Xử lý cập nhật hoặc tạo mới hồ sơ thú cưng
    public function savePet(Request $request)
    {
        // Validate dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'TenThuCung' => 'required|max:100',
            'GioiTinh' => 'required|in:Đực,Cái',
            'Tuoi' => 'required|integer|min:0',
            'MaKhachHang' => 'required|exists:KhachHang,MaKhachHang',
            'MaGiongLoai' => 'required|exists:GiongLoai,MaGiongLoai',
            'GhiChu' => 'nullable|max:255',
            'HinhAnh' => 'nullable|max:255'
        ], [
            'TenThuCung.required' => 'Tên thú cưng không được để trống.',
            'MaKhachHang.required' => 'Phải chọn chủ sở hữu.',
            'MaGiongLoai.required' => 'Phải chọn giống loài.',
        ]);

        // Nếu validate fail
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Kiểm tra là cập nhật hay tạo mới
            $petId = $request->input('MaThuCung');

            $data = [
                'TenThuCung' => $request->input('TenThuCung'),
                'GioiTinh' => $request->input('GioiTinh'),
                'Tuoi' => $request->input('Tuoi'),
                'MaKhachHang' => $request->input('MaKhachHang'),
                'MaGiongLoai' => $request->input('MaGiongLoai'),
                'GhiChu' => $request->input('GhiChu'),
                'HinhAnh' => $request->input('HinhAnh'),
                'ngaydangki' => now()
            ];

            if ($petId) {
                // Cập nhật hồ sơ
                DB::table('ThuCung')
                    ->where('MaThuCung', $petId)
                    ->update($data);

                $message = 'Cập nhật hồ sơ thú cưng thành công.';
            } else {
                // Tạo hồ sơ mới
                $newPetId = DB::table('ThuCung')->insertGetId($data);

                $message = 'Tạo hồ sơ thú cưng mới thành công.';
            }

            // Chuyển hướng về trang danh sách với thông báo
            return redirect()->route('pet.list')->with('success', $message);

        } catch (\Exception $e) {
            // Ghi log lỗi
            \Log::error('Lỗi khi lưu hồ sơ thú cưng: ' . $e->getMessage());

            return redirect()->back()
                ->withErrors('Có lỗi xảy ra khi lưu hồ sơ thú cưng.')
                ->withInput();
        }
    }
    // 7. Giao diện tạo hồ sơ mới
    public function createPetForm()
    {
        // Lấy danh sách khách hàng và giống loài
        $customers = DB::table('KhachHang')->select('MaKhachHang', 'HoTen')->get();
        $breeds = DB::table('GiongLoai')->select('MaGiongLoai', 'TenGiongLoai')->get();

        return view('pet_create_form', [
            'customers' => $customers,
            'breeds' => $breeds
        ]);
    }

    // Hiển thị danh sách nhân viên
    public function NhanVienindex()
    {
        $nhanViens = DB::table('NhanVien')
            ->where('Deleted', false)  // Chỉ lấy những nhân viên chưa bị xóa
            ->get();
        return view('Duy_admin_nhanvien_index', ['nhanViens' => $nhanViens]);
    }


    // Hiển thị form thêm nhân viên
    public function NhanViencreate()
    {
        return view('Duy_admin_nhanvien_create');
    }

    // Lưu thông tin nhân viên mới
    public function NhanVienstore(Request $request)
    {
        $validated = $request->validate([
            'TenNhanVien' => 'required|string|max:100',
            'ChucVu' => 'required|string|max:100',
            'SDT' => 'required|string|max:15',
            'Email' => 'required|email|max:100',
            'LuongTheoGio' => 'required|numeric',
            'TaiKhoan' => 'required|string|max:50',
            'MatKhau' => 'required|string|max:255',
        ]);

        // Hash mật khẩu
        $validated['MatKhau'] = Hash::make($validated['MatKhau']);

        DB::table('NhanVien')->insert($validated);

        return redirect()->route('admin.nhanvien.index');
    }

    // Hiển thị form chỉnh sửa nhân viên
    public function NhanVienedit($maNhanVien)
    {
        $nhanVien = DB::table('NhanVien')->where('MaNhanVien', $maNhanVien)->first();
        return view('Duy_admin_nhanvien_edit', ['nhanVien' => $nhanVien]);
    }

    // Cập nhật thông tin nhân viên
    public function NhanVienupdate(Request $request, $maNhanVien)
    {
        $validated = $request->validate([
            'TenNhanVien' => 'required|string|max:100',
            'ChucVu' => 'required|string|max:100',
            'SDT' => 'required|string|max:15',
            'Email' => 'required|email|max:100',
            'LuongTheoGio' => 'required|numeric',
            'TaiKhoan' => 'required|string|max:50',
            'MatKhau' => 'nullable|string|max:255',
        ]);

        // Hash mật khẩu nếu có
        if ($validated['MatKhau']) {
            $validated['MatKhau'] = Hash::make($validated['MatKhau']);
        }

        DB::table('NhanVien')->where('MaNhanVien', $maNhanVien)->update($validated);

        return redirect()->route('admin.nhanvien.index');
    }

    // Xóa nhân viên
    public function NhanViendestroy($maNhanVien)
    {
        DB::table('NhanVien')
            ->where('MaNhanVien', $maNhanVien)
            ->update(['Deleted' => true]);

        return redirect()->route('admin.nhanvien.index')->with('success', 'Nhân viên đã được xóa mềm');
    }


    // Tìm kiếm nhân viên
    public function NhanViensearch(Request $request)
    {
        $query = $request->input('query');
        $nhanViens = DB::table('NhanVien')
                        ->where('TenNhanVien', 'like', "%{$query}%")
                        ->orWhere('ChucVu', 'like', "%{$query}%")
                        ->get();

        return view('Duy_admin_nhanvien_index', ['nhanViens' => $nhanViens]);
    }

}
