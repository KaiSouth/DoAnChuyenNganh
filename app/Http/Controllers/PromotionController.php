<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Thêm Log

class PromotionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        // Truy vấn dữ liệu từ bảng ChuongTrinhGiamGia với điều kiện tìm kiếm
        $promotions = DB::table('ChuongTrinhGiamGia')
            ->where('TenChuongTrinhGiamGia', 'LIKE', "%$search%")
            ->paginate(5);

        return view('promotions.index', compact('promotions', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'TenChuongTrinhGiamGia' => 'required|string|max:100',
            'ImageUrl' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'MoTa' => 'required|string|max:255',
            'NgayBatDau' => 'required|date',
            'NgayKetThuc' => 'required|date|after_or_equal:NgayBatDau',
        ]);
    
        $imageUrl = null;
    
        if ($request->hasFile('ImageUrl')) {
            $image = $request->file('ImageUrl');
            $imageName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME); // Lấy tên gốc của ảnh
            $imageExtension = $image->getClientOriginalExtension(); 
    
            try {
                // Upload ảnh lên Cloudinary
                $cloudinary = new \Cloudinary\Cloudinary();
                $uploadResult = $cloudinary->uploadApi()->upload(
                    $image->getRealPath(), 
                    [
                        'folder' => 'promotions', // Đặt folder là 'promotions'
                        'public_id' => 'promotions/' . $imageName, // Sử dụng tên file gốc
                    ]
                );
    
                // Lấy URL của ảnh sau khi upload
                $imageUrl = $uploadResult['secure_url'];
                Log::info('Image uploaded to Cloudinary successfully: ' . $imageUrl);
            } catch (\Exception $e) {
                // Ghi log lỗi nếu upload thất bại
                Log::error('Cloudinary upload failed: ' . $e->getMessage());
                return redirect()->back()->withErrors(['error' => 'Cloudinary upload failed: ' . $e->getMessage()]);
            }
        }
    
        // Lưu chương trình khuyến mãi mới
        DB::table('ChuongTrinhGiamGia')->insert([
            'TenChuongTrinhGiamGia' => $request->TenChuongTrinhGiamGia,
            'ImageUrl' => $imageUrl,
            'MoTa' => $request->MoTa,
            'NgayBatDau' => $request->NgayBatDau,
            'NgayKetThuc' => $request->NgayKetThuc,
        ]);
    
        return redirect()->route('promotions.index')->with('success', 'Chương trình khuyến mãi đã được thêm thành công.');
    }

    public function show($id)
    {
        $promotion = DB::table('ChuongTrinhGiamGia')->where('MaChuongTrinhGiamGia', $id)->first();
        $details = DB::table('ChiTietChuongTrinhGiamGia')
            ->leftJoin('DichVu', 'ChiTietChuongTrinhGiamGia.MaDichVu', '=', 'DichVu.MaDichVu')
            ->leftJoin('VatTu', 'ChiTietChuongTrinhGiamGia.MaVatTu', '=', 'VatTu.MaVatTu')
            ->where('MaChuongTrinhGiamGia', $id)
            ->select(
                'ChiTietChuongTrinhGiamGia.*',
                'DichVu.TenDichVu',
                'VatTu.TenVatTu'
            )
            ->get();

        // Lấy danh sách dịch vụ và vật tư
        $services = DB::table('DichVu')->get();
        $materials = DB::table('VatTu')->get();

        return view('promotions.show', compact('promotion', 'details', 'services', 'materials'));
    }
        
    

    public function edit($id)
    {
        $promotion = DB::table('ChuongTrinhGiamGia')->where('MaChuongTrinhGiamGia', $id)->first();

        if (!$promotion) {
            return redirect()->route('promotions.index')->with('error', 'Chương trình khuyến mãi không tồn tại.');
        }

        return view('promotions.edit', compact('promotion'));
    }
    public function updateCtrKM(Request $request, $id)
{
    // Validate dữ liệu gửi lên
    $request->validate([
        'ImageUrl' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Ảnh là không bắt buộc
        'MoTa' => 'required|string|max:255',
        'NgayBatDau' => 'required|date',
        'NgayKetThuc' => 'required|date|after_or_equal:NgayBatDau',
    ]);

    // Tìm chương trình khuyến mãi theo ID
    $promotion = DB::table('ChuongTrinhGiamGia')->where('MaChuongTrinhGiamGia', $id)->first();
    
    if (!$promotion) {
        return redirect()->route('promotions.index')->withErrors(['error' => 'Chương trình khuyến mãi không tồn tại.']);
    }
    
    // Khởi tạo biến lưu URL ảnh (nếu không có ảnh mới, giữ ảnh cũ)
    $ImageUrl = $promotion->ImageUrl;

    // Log thông tin trước khi cập nhật
    Log::info('Updating Promotion ID: ' . $id);
    Log::info('Current ImageUrl: ' . $ImageUrl);
    Log::info('Current Description: ' . $promotion->MoTa);

    if ($request->hasFile('ImageUrl')) {
        // Nếu có ảnh mới, upload lên Cloudinary
        $image = $request->file('ImageUrl');
        $imageName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME); // Lấy tên gốc của ảnh
        $imageExtension = $image->getClientOriginalExtension(); // Lấy phần mở rộng của ảnh

        try {
            // Upload ảnh lên Cloudinary
            $cloudinary = new \Cloudinary\Cloudinary();
            $uploadResult = $cloudinary->uploadApi()->upload(
                $image->getRealPath(),
                [
                    'folder' => 'promotions', // Đặt folder là 'promotions'
                    'public_id' => 'promotions/' . $imageName, // Sử dụng tên file gốc
                ]
            );

            // Lấy URL của ảnh sau khi upload
            $imageUrl = $uploadResult['secure_url'];
            Log::info('New Image uploaded successfully: ' . $imageUrl);
        } catch (\Exception $e) {
            // Ghi log lỗi nếu upload thất bại
            Log::error('Cloudinary upload failed: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Cloudinary upload failed: ' . $e->getMessage()]);
        }
    }

    // Cập nhật thông tin chương trình khuyến mãi
    DB::table('ChuongTrinhGiamGia')->where('MaChuongTrinhGiamGia', $id)->update([
        'ImageUrl' => $ImageUrl, // Cập nhật ảnh mới hoặc giữ ảnh cũ
        'MoTa' => $request->MoTa,
        'NgayBatDau' => $request->NgayBatDau,
        'NgayKetThuc' => $request->NgayKetThuc,
    ]);
    
    // Log sau khi cập nhật
    Log::info('Promotion updated successfully.');

    // Trả về thông báo thành công
    return redirect()->route('promotions.show', $id)->with('success', 'Chương trình khuyến mãi đã được cập nhật thành công.');
}

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'TenChuongTrinhGiamGia' => 'required|string|max:100',
            'MoTa' => 'required|string|max:255',
            'NgayBatDau' => 'required|date',
            'NgayKetThuc' => 'required|date|after_or_equal:NgayBatDau',
        ]);

        $promotion = DB::table('ChuongTrinhGiamGia')->where('MaChuongTrinhGiamGia', $id)->first();
        if (!$promotion) {
            return redirect()->route('promotions.index')->with('error', 'Chương trình khuyến mãi không tồn tại.');
        }

        $data = [
            'TenChuongTrinhGiamGia' => $request->TenChuongTrinhGiamGia,
            'MoTa' => $request->MoTa,
            'NgayBatDau' => $request->NgayBatDau,
            'NgayKetThuc' => $request->NgayKetThuc,
        ];

        if ($request->hasFile('ImageUrl')) {
            $data['ImageUrl'] = $request->file('ImageUrl')->store('images', 'public');
        }

        DB::table('ChuongTrinhGiamGia')->where('MaChuongTrinhGiamGia', $id)->update($data);

        return redirect()->route('promotions.index')->with('success', 'Chương trình khuyến mãi đã được cập nhật.');
    }

    public function destroy($id)
    {
        $promotion = DB::table('ChuongTrinhGiamGia')->where('MaChuongTrinhGiamGia', $id)->first();
    
        if (!$promotion) {
            return redirect()->route('promotions.index')->with('error', 'Chương trình khuyến mãi không tồn tại.');
        }

        DB::table('ChiTietChuongTrinhGiamGia')->where('MaChuongTrinhGiamGia', $id)->delete();
        DB::table('ChuongTrinhGiamGia')->where('MaChuongTrinhGiamGia', $id)->delete();    

        return redirect()->route('promotions.index')->with('success', 'Chương trình khuyến mãi đã được xóa.');
    }


    public function addDetail($promotionId)
    {
        $promotion = DB::table('ChuongTrinhGiamGia')->where('MaChuongTrinhGiamGia', $promotionId)->first();
        if (!$promotion) {
            return redirect()->route('promotions.index')->with('error', 'Chương trình khuyến mãi không tồn tại.');
        }
    
        $services = DB::table('DichVu')->get();
        $materials = DB::table('VatTu')->get();
    
        return view('promotions.show', compact('promotion', 'services', 'materials'));
    }
    public function storeDetail(Request $request, $promotionId)
    {
        $request->validate([
            'PhanTramGiam' => 'required|numeric',
            'GiamToiDa' => 'required|numeric',
            'SoLuong' => 'required|numeric',
            'MaDichVu' => 'nullable|exists:DichVu,MaDichVu',
            'MaVatTu' => 'nullable|exists:VatTu,MaVatTu',
        ]);

        DB::table('ChiTietChuongTrinhGiamGia')->insert([
            'PhanTramGiam' => $request->PhanTramGiam,
            'GiamToiDa' => $request->GiamToiDa,
            'SoLuong' => $request->SoLuong,
            'MaDichVu' => $request->MaDichVu,
            'MaVatTu' => $request->MaVatTu,
            'MaChuongTrinhGiamGia' => $promotionId,
        ]);

        return redirect()->route('promotions.show', $promotionId)->with('success', 'Chi tiết khuyến mãi đã được thêm.');
    }

    public function deleteDetail($promotionId, $detailId)
    {
        $detail = DB::table('ChiTietChuongTrinhGiamGia')->where('MaChiTietGiamGia', $detailId)->first();

        if (!$detail) {
            return redirect()->route('promotions.show', $promotionId)->with('error', 'Chi tiết khuyến mãi không tồn tại.');
        }

        DB::table('ChiTietChuongTrinhGiamGia')->where('MaChiTietGiamGia', $detailId)->delete();

        return redirect()->route('promotions.show', $promotionId)->with('success', 'Chi tiết khuyến mãi đã được xóa.');
    }
    public function updateDetail(Request $request, $promotionId, $detailId)
    {
        $request->validate([
            'PhanTramGiam' => 'required|numeric',
            'GiamToiDa' => 'required|numeric',
            'SoLuong' => 'required|numeric',
            'MaDichVu' => 'nullable|exists:DichVu,MaDichVu',
            'MaVatTu' => 'nullable|exists:VatTu,MaVatTu',
        ]);

        $detail = DB::table('ChiTietChuongTrinhGiamGia')->where('MaChiTietGiamGia', $detailId)->first();

        if (!$detail) {
            return redirect()->route('promotions.show', $promotionId)->with('error', 'Chi tiết khuyến mãi không tồn tại.');
        }

        $data = [
            'PhanTramGiam' => $request->PhanTramGiam,
            'GiamToiDa' => $request->GiamToiDa,
            'SoLuong' => $request->SoLuong,
            'MaDichVu' => $request->MaDichVu,
            'MaVatTu' => $request->MaVatTu,
        ];

        DB::table('ChiTietChuongTrinhGiamGia')->where('MaChiTietGiamGia', $detailId)->update($data);

        return redirect()->route('promotions.show', $promotionId)->with('success', 'Chi tiết khuyến mãi đã được cập nhật thành công.');
    }

}
