<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Đảm bảo đã thêm dòng này ở đầu file controller

class StockEntryController extends Controller
{
    public function index(Request $request)
    {
        // Tìm kiếm phiếu nhập
        $search = $request->input('search', '');
        $receipts = DB::table('PhieuNhap')
            ->join('NhaCungCap', 'PhieuNhap.MaNhaCungCap', '=', 'NhaCungCap.MaNhaCungCap')
            ->select('PhieuNhap.*', 'NhaCungCap.TenNhaCungCap')
            ->when($search, function ($query, $search) {
                return $query->where('NhaCungCap.TenNhaCungCap', 'like', "%{$search}%");
            })
            ->orderBy('PhieuNhap.NgayNhap', 'desc') 
            ->paginate(10);

        // Lấy danh sách nhà cung cấp và vật tư
        $suppliers = DB::table('NhaCungCap')->get();
        $materials = DB::table('VatTu')->get();

        return view('StockEntry.index', compact('receipts', 'suppliers', 'materials'));
    }
    public function create()
    {
        $suppliers = DB::table('NhaCungCap')->get();
        $materials = DB::table('VatTu')->get();
    
        return view('StockEntry.create', compact('suppliers', 'materials'));
    }
    
    public function show($id)
    {
        // Lấy thông tin phiếu nhập và chi tiết phiếu nhập
        $receipt = DB::table('PhieuNhap')
            ->join('NhaCungCap', 'PhieuNhap.MaNhaCungCap', '=', 'NhaCungCap.MaNhaCungCap')
            ->where('PhieuNhap.MaPhieuNhap', $id)
            ->select('PhieuNhap.*', 'NhaCungCap.TenNhaCungCap')
            ->first();

        $details = DB::table('ChiTietPhieuNhap')
            ->join('VatTu', 'ChiTietPhieuNhap.MaVatTu', '=', 'VatTu.MaVatTu')
            ->where('ChiTietPhieuNhap.MaPhieuNhap', $id)
            ->select('ChiTietPhieuNhap.*', 'VatTu.TenVatTu', 'VatTu.DonViTinh')
            ->get();

        return view('StockEntry.show', compact('receipt', 'details'));
    }
    public function store(Request $request)
    {
        // Log dữ liệu nhận được từ request để kiểm tra
        Log::info('Request Data:', $request->all());
    
        // Validate the incoming request data
        $validated = $request->validate([
            'NgayNhap' => 'required|date',
            'MaNhaCungCap' => 'required|exists:NhaCungCap,MaNhaCungCap',
            'materials' => 'required|array', // Ensure 'materials' is an array
            'materials.*.MaVatTu' => 'required|exists:VatTu,MaVatTu',
            'materials.*.SoLuong' => 'required|numeric|min:1',
            'materials.*.DonGia' => 'required|numeric|min:0',
            'materials.*.DonViTinh' => 'required|string',
            'materials.*.NgaySanXuat' => 'nullable|date',
            'materials.*.NgayHetHan' => 'nullable|date',
        ]);
    
        // Log dữ liệu đã được validated
        Log::info('Validated Data:', $validated);
    
        // Begin transaction to ensure all data is inserted correctly
        DB::beginTransaction();
    
        try {
            // Save the stock entry (phiếu nhập kho) using DB
            $stockEntryId = DB::table('PhieuNhap')->insertGetId([
                'NgayNhap' => $validated['NgayNhap'],
                'TongTien' => 0, // Set a default total, will update after calculating details
                'MaNhaCungCap' => $validated['MaNhaCungCap'],
            ]);
            Log::info('Mã phiếu nhập vừa được tạo: ' . $stockEntryId);

            $totalAmount = 0;
    
            Log::info('Start saving materials details');
    
            foreach ($validated['materials'] as $material) {
                Log::info('Processing material:', $material);
    
                $subtotal = $material['SoLuong'] * $material['DonGia'];
                $totalAmount += $subtotal;

                DB::table('ChiTietPhieuNhap')->insert([
                    'MaVatTu' => $material['MaVatTu'],
                    'SoLuong' => $material['SoLuong'],
                    'DonGia' => $material['DonGia'],
                    'ThanhTien' => $subtotal,
                    'MaPhieuNhap' => $stockEntryId,
                    'DonViTinh' => $material['DonViTinh'],
                    'NgaySanXuat' => $material['NgaySanXuat'] ?? null, // Ensure null if empty
                    'NgayHetHan' => $material['NgayHetHan'] ?? null, // Ensure null if empty
                ]);
                DB::table('LoHang')->insert([
                    'MaPhieuNhap' => $stockEntryId,
                    'SoLuongTonKho' => $material['SoLuong'],
                    'MaVatTu' => $material['MaVatTu'],
                    'DonViTinh' => $material['DonViTinh'],
                    'NgaySanXuat' => $material['NgaySanXuat'] ?? null, 
                    'NgayHetHan' => $material['NgayHetHan'] ?? null, 
                ]);
            }
    
            DB::table('PhieuNhap')->where('MaPhieuNhap', $stockEntryId)->update([
                'TongTien' => $totalAmount
            ]);
    
            DB::commit();
    
            return response()->json(['success' => true]);
    
        } catch (\Exception $e) {
            DB::rollBack();
    
            Log::error('Error occurred:', ['message' => $e->getMessage()]);
    
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    

    

    public function edit($id)
    {
        $receipt = DB::table('PhieuNhap')
            ->where('PhieuNhap.MaPhieuNhap', $id)
            ->first();

        $details = DB::table('ChiTietPhieuNhap')
            ->join('VatTu', 'ChiTietPhieuNhap.MaVatTu', '=', 'VatTu.MaVatTu')
            ->where('ChiTietPhieuNhap.MaPhieuNhap', $id)
            ->get();

        return response()->json(['success' => true, 'receipt' => $receipt, 'details' => $details]);
    }

    public function destroy($id)
    {
        try {
            DB::table('ChiTietPhieuNhap')->where('MaPhieuNhap', $id)->delete();
            DB::table('PhieuNhap')->where('MaPhieuNhap', $id)->delete();

            return response()->json(['success' => true, 'message' => 'Xóa phiếu nhập thành công']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()], 500);
        }
    }
    public function getMaterialsBySupplier($supplierId)
    {
        // Lấy danh sách vật tư của nhà cung cấp
        $materials = DB::table('VatTu')
                        ->where('MaNhaCungCap', $supplierId)
                        ->get(['MaVatTu', 'TenVatTu']);
        return response()->json($materials);
    }

}
