<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Thêm Log
use Cloudinary\Uploader;  // Thêm dòng này vào
use Cloudinary\Cloudinary;

class ProductServiceController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $vatTus = DB::table('vattu')
            ->join('loaivattu', 'vattu.MaLoaiVatTu', '=', 'loaivattu.MaLoaiVatTu')
            ->leftJoin('nhacungcap', 'vattu.MaNhaCungCap', '=', 'nhacungcap.MaNhaCungCap') // Join bảng nhà cung cấp
            ->select('vattu.*', 'loaivattu.TenLoaiVatTu', 'nhacungcap.TenNhaCungCap') // Lấy thêm tên nhà cung cấp
            ->where('vattu.Deleted', false) // Thêm điều kiện Deleted = false
            ->when($search, function ($query, $search) {
                return $query->where('vattu.TenVatTu', 'LIKE', "%$search%");
            })
            ->paginate(5, ['*'], 'vatTuPage'); // Đặt tên cho phân trang vật tư

        $dichVus = DB::table('dichvu')
            ->join('loaidichvu', 'dichvu.MaLoaiDichVu', '=', 'loaidichvu.MaLoaiDichVu')
            ->select('dichvu.*', 'loaidichvu.TenLoaiDichVu')
            ->where('dichvu.Deleted', false) // Thêm điều kiện Deleted = false
            ->when($search, function ($query, $search) {
                return $query->where('dichvu.TenDichVu', 'LIKE', "%$search%");
            })
            ->paginate(5, ['*'], 'dichVuPage'); // Đặt tên cho phân trang dịch vụ
        \Log::info("DichVus data:", $dichVus->toArray());

        return view('Product_Service.index', compact('vatTus', 'dichVus', 'search'));
    }


    public function getLoaiVatTu()
    {
        $loaiVatTu = DB::table('loaivattu')->select('MaLoaiVatTu', 'TenLoaiVatTu')->get();
        return response()->json($loaiVatTu);
    }
    
    public function getLoaiDichVu()
    {
        $loaiDichVu = DB::table('loaidichvu')->select('MaLoaiDichVu', 'TenLoaiDichVu')->get();
        return response()->json($loaiDichVu);
    }
    public function getNhaCungCap()
    {
        $nhaCungCap = DB::table('nhacungcap')
            ->where('Deleted', false) // Chỉ lấy nhà cung cấp chưa bị xóa
            ->select('MaNhaCungCap', 'TenNhaCungCap')
            ->get();

        return response()->json($nhaCungCap);
    }

    public function store(Request $request)
    {
        try {
            // Get request inputs
            $itemType = $request->input('itemType');
            $itemCategory = $request->input('itemCategory');
            $description = $request->input('MoTa');

            // Handle image upload to Cloudinary
            $imageUrl = null;

            if ($request->hasFile('HinhAnh')) {
                $image = $request->file('HinhAnh');
                $imageName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME); // Get original image name
                $imageExtension = $image->getClientOriginalExtension(); // Get image extension

                try {
                    // Upload image to Cloudinary
                    $cloudinary = new Cloudinary();
                    $uploadResult = $cloudinary->uploadApi()->upload(
                        $image->getRealPath(), 
                        [
                            'folder' => 'product', // Set folder to 'product'
                            'public_id' => 'product/' . $imageName, // Use original file name
                        ]
                    );

                    // Get image URL after upload
                    $imageUrl = $uploadResult['secure_url'];
                    Log::info('Image uploaded to Cloudinary successfully: ' . $imageUrl);
                } catch (\Exception $e) {
                    // Log error if upload fails
                    Log::error('Cloudinary upload failed: ' . $e->getMessage());
                    return response()->json(['success' => false, 'error' => 'Cloudinary upload failed: ' . $e->getMessage()]);
                }
            }

            // Save item data to the database
            if ($itemType === 'vattu') {
                DB::table('vattu')->insert([
                    'TenVatTu' => $request->input('TenVatTu'),
                    'DonViTinh' => $request->input('DonViTinh'),
                    'DonGiaBan' => $request->input('DonGiaBan'),
                    'MoTa' => $description,
                    'HinhAnh' => $imageUrl, // Save Cloudinary image URL
                    'MaLoaiVatTu' => $itemCategory,
                    'MaNhaCungCap' => $request->input('MaNhaCungCap'),
                    'Deleted' => false,
                ]);
            } elseif ($itemType === 'dichvu') {
                DB::table('dichvu')->insert([
                    'TenDichVu' => $request->input('TenDichVu'),
                    'DonGia' => $request->input('DonGia'),
                    'MoTa' => $description,
                    'HinhAnh' => $imageUrl, // Save Cloudinary image URL
                    'MaLoaiDichVu' => $itemCategory,
                    'Deleted' => false, // Set Deleted to false when creating new
                ]);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Log general error if any other error occurs
            Log::error('Error during item save: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function softDelete(Request $request)
    {
        try {
            $itemType = $request->input('itemType');
            $itemId = $request->input('id');

            if ($itemType === 'vattu') {
                DB::table('vattu')
                    ->where('MaVatTu', $itemId)
                    ->update(['Deleted' => true]);
            } elseif ($itemType === 'dichvu') {
                DB::table('dichvu')
                    ->where('MaDichVu', $itemId)
                    ->update(['Deleted' => true]);
            }

            return response()->json(['success' => true, 'message' => 'Xóa thành công!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Xóa thất bại!', 'error' => $e->getMessage()]);
        }
    }
    public function trash(Request $request)
    {
        $search = $request->input('search');
    
        // Phân trang cho vật tư (chỉ hiển thị vật tư có Deleted = false)
        $vatTus = DB::table('vattu')
            ->join('loaivattu', 'vattu.MaLoaiVatTu', '=', 'loaivattu.MaLoaiVatTu')
            ->select('vattu.*', 'loaivattu.TenLoaiVatTu')
            ->where('vattu.Deleted', true) // Thêm điều kiện Deleted = false
            ->when($search, function ($query, $search) {
                return $query->where('vattu.TenVatTu', 'LIKE', "%$search%");
            })
            ->paginate(5, ['*'], 'vatTuPage'); // Đặt tên cho phân trang vật tư
    
        // Phân trang cho dịch vụ (chỉ hiển thị dịch vụ có Deleted = false)
        $dichVus = DB::table('dichvu')
            ->join('loaidichvu', 'dichvu.MaLoaiDichVu', '=', 'loaidichvu.MaLoaiDichVu')
            ->select('dichvu.*', 'loaidichvu.TenLoaiDichVu')
            ->where('dichvu.Deleted', operator: true) // Thêm điều kiện Deleted = false
            ->when($search, function ($query, $search) {
                return $query->where('dichvu.TenDichVu', 'LIKE', "%$search%");
            })
            ->paginate(5, ['*'], 'dichVuPage'); // Đặt tên cho phân trang dịch vụ
    
        return view('Product_Service.trash', compact('vatTus', 'dichVus', 'search'));
    }
    public function undoDelete(Request $request)
    {
        try {
            $itemType = $request->input('itemType');
            $itemId = $request->input('id');
            
            if ($itemType === 'vattu') {
                DB::table('vattu')->where('MaVatTu', $itemId)->update(['Deleted' => false]);
            } elseif ($itemType === 'dichvu') {
                DB::table('dichvu')->where('MaDichVu', $itemId)->update(['Deleted' => false]);
            }

            return response()->json(['success' => true, 'message' => 'Khôi phục thành công!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Có lỗi xảy ra!', 'error' => $e->getMessage()]);
        }
    }
    public function edit($itemType, $id)
    {
        if ($itemType === 'vattu') {
            $item = DB::table('vattu')
                ->join('loaivattu', 'vattu.MaLoaiVatTu', '=', 'loaivattu.MaLoaiVatTu')
                ->join('nhacungcap', 'vattu.MaNhaCungCap', '=', 'nhacungcap.MaNhaCungCap', 'left') // Join nhà cung cấp
                ->select('vattu.*', 'loaivattu.TenLoaiVatTu', 'nhacungcap.TenNhaCungCap', 'nhacungcap.MaNhaCungCap')
                ->where('vattu.MaVatTu', $id)
                ->first();

            $loHangs = DB::table('lohang')
                ->where('MaVatTu', $id)
                ->get();

            // Lấy danh sách loại vật tư
            $loaiVatTu = DB::table('loaivattu')->get();

            // Lấy danh sách nhà cung cấp
            $nhaCungCap = DB::table('nhacungcap')
                ->where('Deleted', false)
                ->get();

            return view('Product_Service.edit', compact('item', 'loHangs', 'itemType', 'loaiVatTu', 'nhaCungCap'));
        } elseif ($itemType === 'dichvu') {
            $item = DB::table('dichvu')
                ->join('loaidichvu', 'dichvu.MaLoaiDichVu', '=', 'loaidichvu.MaLoaiDichVu')
                ->select('dichvu.*', 'loaidichvu.TenLoaiDichVu')
                ->where('dichvu.MaDichVu', $id)
                ->first();

            // Lấy danh sách loại dịch vụ
            $loaiDichVu = DB::table('loaidichvu')->get();

            return view('Product_Service.edit', compact('item', 'itemType', 'loaiDichVu'));
        }
    }


 
public function update(Request $request, $itemType, $id)
{
    try {
        // Đường dẫn hình ảnh mặc định
        $imageUrl = null;

        // Kiểm tra xem có hình ảnh mới không
        if ($request->hasFile('HinhAnh')) {
            $image = $request->file('HinhAnh');
            $imageName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME); // Lấy tên gốc của hình ảnh
            $imageExtension = $image->getClientOriginalExtension(); // Lấy phần mở rộng của hình ảnh

            try {
                // Upload hình ảnh lên Cloudinary
                $cloudinary = new Cloudinary();
                $uploadResult = $cloudinary->uploadApi()->upload(
                    $image->getRealPath(),
                    [
                        'folder' => 'product', // Thư mục trên Cloudinary
                        'public_id' => 'product/' . $imageName, // ID công khai sử dụng tên gốc
                    ]
                );

                // Lấy URL hình ảnh sau khi upload
                $imageUrl = $uploadResult['secure_url'];
                Log::info('Image uploaded to Cloudinary successfully: ' . $imageUrl);
            } catch (\Exception $e) {
                // Log lỗi nếu upload thất bại
                Log::error('Cloudinary upload failed: ' . $e->getMessage());
                return redirect()->route('products_services.index')
                    ->withErrors('Upload hình ảnh thất bại. Vui lòng thử lại.');
            }
        }

        if ($itemType === 'vattu') {
            DB::table('vattu')
                ->where('MaVatTu', $id)
                ->update([
                    'TenVatTu' => $request->input('TenVatTu'),
                    'MaLoaiVatTu' => $request->input('MaLoaiVatTu'),
                    'MaNhaCungCap' => $request->input('MaNhaCungCap'), // Cập nhật nhà cung cấp
                    'DonViTinh' => $request->input('DonViTinh'),
                    'DonGiaBan' => $request->input('DonGiaBan'),
                    'MoTa' => $request->input('MoTa'),
                    'HinhAnh' => $imageUrl ? $imageUrl : DB::table('vattu')->where('MaVatTu', $id)->value('HinhAnh'), // Cập nhật URL hình ảnh nếu có, nếu không giữ nguyên
                ]);

            return redirect()->route('products_services.index')
                ->with('success', 'Cập nhật vật tư thành công');
        } elseif ($itemType === 'dichvu') {
            // Cập nhật thông tin dịch vụ
            DB::table('dichvu')
                ->where('MaDichVu', $id)
                ->update([
                    'TenDichVu' => $request->input('TenDichVu'),
                    'MaLoaiDichVu' => $request->input('MaLoaiDichVu'),
                    'DonGia' => $request->input('DonGia'),
                    'MoTa' => $request->input('MoTa'),
                    'HinhAnh' => $imageUrl ? $imageUrl : DB::table('dichvu')->where('MaDichVu', $id)->value('HinhAnh'), // Cập nhật URL hình ảnh nếu có, nếu không giữ nguyên
                ]);

            return redirect()->route('products_services.index')
                ->with('success', 'Cập nhật dịch vụ thành công');
        }

        return redirect()->route('products_services.index')
            ->withErrors('Không thể cập nhật dữ liệu.');
    } catch (\Exception $e) {
        // Log lỗi chung nếu có lỗi xảy ra
        Log::error('Error during update: ' . $e->getMessage());
        return redirect()->route('products_services.index')
            ->withErrors('Cập nhật thất bại, vui lòng thử lại sau.');
    }
}
    



}
