<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Đảm bảo đã thêm dòng này ở đầu file controller
use Illuminate\Support\Facades\Storage;
use Cloudinary\Cloudinary;
class IssueController extends Controller
{
    /**
     * Hiển thị danh sách vấn đề
     */
    public function index()
    {
        // Query lấy các vấn đề chờ xử lý
        $pendingIssues = DB::table('XuLyVanDe')
            ->select('XuLyVanDe.*', 'HoaDon.NgayXuatHoaDon')
            ->join('HoaDon', 'XuLyVanDe.MaHoaDon', '=', 'HoaDon.MaHoaDon')
            ->where('XuLyVanDe.TrangThai', '=', 'Chờ xử lý')
            ->get();

        // Query lấy các vấn đề đã xử lý
        $resolvedIssues = DB::table('XuLyVanDe')
            ->select('XuLyVanDe.*', 'HoaDon.NgayXuatHoaDon')
            ->join('HoaDon', 'XuLyVanDe.MaHoaDon', '=', 'HoaDon.MaHoaDon')
            ->where('XuLyVanDe.TrangThai', '=', 'Đã xử lý')
            ->get();
        return view('issues.index', compact('pendingIssues', 'resolvedIssues'));
    }

    /**
     * Hiển thị chi tiết một vấn đề
     */
    public function show($id)
    {
        try {
            // Lấy chi tiết hóa đơn và các mục liên quan
            $invoice = DB::table('HoaDon')
                ->leftJoin('XuLyVanDe', 'XuLyVanDe.MaHoaDon', '=', 'XuLyVanDe.MaHoaDon')
                ->leftJoin('KhachHang', 'HoaDon.MaKhachHang', '=', 'KhachHang.MaKhachHang')
                ->leftJoin('ChiTietHoaDon', 'HoaDon.MaHoaDon', '=', 'ChiTietHoaDon.MaHoaDon')
                ->leftJoin('VatTu', 'ChiTietHoaDon.MaVatTu', '=', 'VatTu.MaVatTu')
                ->leftJoin('DichVu', 'ChiTietHoaDon.MaDichVu', '=', 'DichVu.MaDichVu')
                ->leftJoin('LichKham', 'HoaDon.MaLichKham', '=', 'LichKham.MaLichKham')
                ->select(
                    'HoaDon.*',
                    'XuLyVanDe.TrangThai as TrangThaiVD',
                    'XuLyVanDe.MoTa as MoTaVD',
                    'KhachHang.HoTen as TenKhachHang',
                    'ChiTietHoaDon.*',
                    'VatTu.TenVatTu',
                    'VatTu.HinhAnh as HinhAnhVT',
                    'VatTu.DonGiaBan as DonGiaVT',
                    'DichVu.TenDichVu',
                    'DichVu.HinhAnh as HinhAnhDV',
                    'DichVu.DonGia as DonGiaDV',
                    'LichKham.NgayKham',
                    'LichKham.GioKham',
                    'LichKham.DiaChi',
                    'LichKham.ChuanDoan',
                    'LichKham.ChiPhiKham'
                )
                ->where('HoaDon.MaHoaDon', $id)
                ->get();
    
            if ($invoice->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy hóa đơn',
                ], 404);
            }
    
            // Trả về JSON
            return response()->json([
                'success' => true,
                'invoice' => $invoice,
            ]);
        } catch (\Exception $e) {
            Log::error('Invoice Detail Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage(),
            ], 500);
        }
    }
    
    

    /**
     * Cập nhật trạng thái giải quyết vấn đề
     */
    public function resolve(Request $request, $id)
    {

        // Validate incoming data
        $validated = $request->validate([
            'TrangThai' => 'required|in:Chờ Xử Lý,Đã Xử Lý',
            'MoTa' => 'nullable|string|max:255',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Kiểm tra hình ảnh
        ]);
    
        // Kiểm tra vấn đề có tồn tại không
        $issue = DB::table('XuLyVanDe')->where('MaVanDe', $id)->first();
    
        if (!$issue) {
            return response()->json(['success' => false, 'message' => 'Vấn đề không tồn tại!'], 404);
        }
    
        // Chuẩn bị dữ liệu để cập nhật
        $updateData = [
            'TrangThai' => $validated['TrangThai'],
            'MoTa' => $validated['MoTa']
        ];
    
        // Log thông tin về tệp nếu có
        if ($request->hasFile('img')) {
            Log::info('Tệp được gửi:', ['file' => $request->file('img')->getClientOriginalName()]);
    
            $file = $request->file('img');
            $imageName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    
            try {
                // Upload ảnh lên Cloudinary
                $cloudinary = new \Cloudinary\Cloudinary();
                $uploadResult = $cloudinary->uploadApi()->upload(
                    $file->getRealPath(),
                    [
                        'folder' => 'issues', // Lưu trong thư mục 'issues'
                        'public_id' => 'issue_' . $imageName // Đặt tên file
                    ]
                );
    
                // Lấy URL đầy đủ từ Cloudinary
                $secureUrl = $uploadResult['secure_url']; // URL đầy đủ
                $updateData['img'] = $secureUrl; // Lưu URL đầy đủ
                Log::info('Image uploaded to Cloudinary successfully: ' . $secureUrl);
            } catch (\Exception $e) {
                Log::error('Cloudinary upload failed: ' . $e->getMessage());
                return response()->json(['success' => false, 'error' => 'Cloudinary upload failed: ' . $e->getMessage()]);
            }
        } else {
            Log::info('Không có tệp được gửi');
        }
    
        // Cập nhật dữ liệu trong database
        $updated = DB::table('XuLyVanDe')
            ->where('MaVanDe', $id)
            ->update($updateData);
    
        if ($updated) {
            Log::info('Update Result', ['issueId' => $id, 'updateData' => $updateData]);
            return response()->json(['success' => true, 'message' => 'Vấn đề đã được giải quyết thành công!', 'updatedData' => $updateData]);
        } else {
            return response()->json(['success' => false, 'message' => 'Không có thay đổi nào được thực hiện.']);
        }
    }
    
    
    public function resolveIssue($issueId)
    {
        // Truy vấn trực tiếp từ bảng 'issues' (giả sử tên bảng là 'issues')
        $issue = DB::table('XuLyVanDe')->where('MaVanDe', $issueId)->first();

        if (!$issue) {
            return response()->json(['success' => false, 'message' => 'Vấn đề không tồn tại.']);
        }

        return response()->json([
            'success' => true,
            'issue' => [
                'MaVanDe' => $issue->MaVanDe,
                'MaHoaDon' => $issue->MaHoaDon ,
                'TrangThai' => $issue->TrangThai ,
                'MoTa' => $issue->MoTa,
            ]
        ]);
    }


    public function storeResolvedIssue(Request $request, $issueId)
    {
        // Log all incoming request data
        Log::info('Incoming Request Data', [
            'issueId' => $issueId,
            'all_inputs' => $request->all(),
            'status' => $request->input('TrangThai'),
            'description' => $request->input('MoTa'),
            'has_image' => $request->hasFile('image')
        ]);
    
        // Validate the request
        $validated = $request->validate([
            'TrangThai' => 'required|string',
            'MoTa' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);
    
        try {
            // Find the issue
            $issue = DB::table('XuLyVanDe')->where('MaVanDe', $issueId)->first();
    
            if (!$issue) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Vấn đề không tồn tại.'
                ], 404);
            }
    
            // Prepare update data
            $updateData = [
                'TrangThai' => $request->input('TrangThai'),
                'MoTa' => $request->input('MoTa'),
            ];
    
            // Log update data before update
            Log::info('Update Data Prepared', [
                'issueId' => $issueId,
                'updateData' => $updateData
            ]);
    
            // Handle image upload to Cloudinary
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                try {
                    // Khởi tạo Cloudinary
                    $cloudinary = new Cloudinary();
                    
                    // Upload ảnh lên Cloudinary
                    $uploadResult = $cloudinary->uploadApi()->upload(
                        $image->getRealPath(), // Đường dẫn file ảnh
                        [
                            'folder' => 'issues', // Đặt thư mục lưu ảnh là 'issues'
                            'public_id' => 'issues/' . pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME), // Sử dụng tên gốc của ảnh làm public_id
                        ]
                    );
    
                    // Lấy URL của ảnh đã upload
                    $imageUrl = $uploadResult['secure_url'];
                    $updateData['img'] = $imageUrl; // Lưu đường dẫn ảnh Cloudinary vào database
    
                    // Log kết quả thành công
                    Log::info('Image uploaded to Cloudinary successfully: ' . $imageUrl);
                } catch (\Exception $e) {
                    // Log lỗi nếu upload thất bại
                    Log::error('Cloudinary upload failed: ' . $e->getMessage());
                    return response()->json(['success' => false, 'error' => 'Cloudinary upload failed: ' . $e->getMessage()]);
                }
            }
    
            // Update the issue
            $updated = DB::table('XuLyVanDe')
                ->where('MaVanDe', $issueId)
                ->update($updateData);
    
            // Log update result
            Log::info('Update Result', [
                'issueId' => $issueId,
                'updated' => $updated,
                'updateData' => $updateData
            ]);
    
            if (!$updated) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Không có thay đổi nào được áp dụng.'
                ], 400);
            }
    
            return response()->json([
                'success' => true, 
                'message' => 'Vấn đề đã được cập nhật thành công.'
            ]);
    
        } catch (\Exception $e) {
            Log::error('Issue resolution error', [
                'issueId' => $issueId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false, 
                'message' => 'Có lỗi xảy ra trong quá trình xử lý: ' . $e->getMessage()
            ], 500);
        }
    }

}