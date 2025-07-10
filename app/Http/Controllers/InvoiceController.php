<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller 
{
    protected $vatTuStatuses = [
        'Chờ xác nhận',
        'Đã xác nhận',
        'Đang chuẩn bị hàng',
        'Đang giao hàng',
        'Hoàn thành',
        'Từ Chối Đơn Hàng'
    ];

    protected $dichVuStatuses = [
        'Chờ xác nhận',
        'Đã xác nhận',
        'Đợi đến giờ',
        'Đang thực hiện dịch vụ',
        'Hoàn thành',
       'Từ Chối Đơn Hàng'
    ];

    public function index()
    {
        $pendingQuery = DB::table('HoaDon')
            ->leftJoin('KhachHang', 'HoaDon.MaKhachHang', '=', 'KhachHang.MaKhachHang')
            ->leftJoin('ChiTietHoaDon', 'HoaDon.MaHoaDon', '=', 'ChiTietHoaDon.MaHoaDon')
            ->select(
                'HoaDon.MaHoaDon',
                'HoaDon.NgayXuatHoaDon', 
                'HoaDon.MaKhachHang',
                'HoaDon.MaLichKham',
                'HoaDon.TrangThai',
                'HoaDon.LoaiGiaoDich',
                'HoaDon.TongTien',
                'KhachHang.HoTen',
                DB::raw('COUNT(CASE WHEN ChiTietHoaDon.MaVatTu IS NOT NULL THEN 1 END) as has_vattu')
            )
            ->where('HoaDon.TrangThai', 'Chờ xác nhận')
            ->groupBy(
                'HoaDon.MaHoaDon',
                'HoaDon.NgayXuatHoaDon',
                'HoaDon.MaKhachHang',
                'HoaDon.MaLichKham',
                'HoaDon.TrangThai',
                'HoaDon.LoaiGiaoDich',
                'HoaDon.TongTien',
                'KhachHang.HoTen'
            )
            ->orderByDesc('HoaDon.NgayXuatHoaDon');
        $confirmedQuery = DB::table('HoaDon')
            ->leftJoin('KhachHang', 'HoaDon.MaKhachHang', '=', 'KhachHang.MaKhachHang')
            ->leftJoin('ChiTietHoaDon', 'HoaDon.MaHoaDon', '=', 'ChiTietHoaDon.MaHoaDon')
            ->select(
                'HoaDon.*', 
                'KhachHang.HoTen',
                DB::raw('COUNT(CASE WHEN ChiTietHoaDon.MaVatTu IS NOT NULL THEN 1 END) as has_vattu')
            )
            ->where('HoaDon.TrangThai', 'Đã xác nhận')
            ->groupBy('HoaDon.MaHoaDon','HoaDon.MaLichKham', 'HoaDon.NgayXuatHoaDon', 'HoaDon.MaKhachHang', 
                     'HoaDon.TrangThai', 'HoaDon.LoaiGiaoDich', 'HoaDon.TongTien', 'KhachHang.HoTen')
            ->orderByDesc('HoaDon.NgayXuatHoaDon');

        $inProgressQuery = DB::table('HoaDon')
            ->leftJoin('KhachHang', 'HoaDon.MaKhachHang', '=', 'KhachHang.MaKhachHang')
            ->leftJoin('ChiTietHoaDon', 'HoaDon.MaHoaDon', '=', 'ChiTietHoaDon.MaHoaDon')
            ->select(
                'HoaDon.*', 
                'KhachHang.HoTen',
                DB::raw('COUNT(CASE WHEN ChiTietHoaDon.MaVatTu IS NOT NULL THEN 1 END) as has_vattu')
            )
            ->whereIn('HoaDon.TrangThai', ['Đang chuẩn bị hàng', 'Đang giao hàng', 'Đợi đến giờ', 'Đang thực hiện dịch vụ'])
            ->groupBy('HoaDon.MaHoaDon', 'HoaDon.NgayXuatHoaDon','HoaDon.MaLichKham', 'HoaDon.MaKhachHang', 
                     'HoaDon.TrangThai', 'HoaDon.LoaiGiaoDich', 'HoaDon.TongTien', 'KhachHang.HoTen')
            ->orderByDesc('HoaDon.NgayXuatHoaDon');

        $completedQuery = DB::table('HoaDon')
            ->leftJoin('KhachHang', 'HoaDon.MaKhachHang', '=', 'KhachHang.MaKhachHang')
            ->leftJoin('ChiTietHoaDon', 'HoaDon.MaHoaDon', '=', 'ChiTietHoaDon.MaHoaDon')
            ->select(
                'HoaDon.*', 
                'KhachHang.HoTen',
                DB::raw('COUNT(CASE WHEN ChiTietHoaDon.MaVatTu IS NOT NULL THEN 1 END) as has_vattu')
            )
            ->where('HoaDon.TrangThai', 'Hoàn thành')
            ->groupBy('HoaDon.MaHoaDon', 'HoaDon.NgayXuatHoaDon','HoaDon.MaLichKham', 'HoaDon.MaKhachHang', 
                     'HoaDon.TrangThai', 'HoaDon.LoaiGiaoDich', 'HoaDon.TongTien', 'KhachHang.HoTen')
            ->orderByDesc('HoaDon.NgayXuatHoaDon');
        $rejectedQuery = DB::table('HoaDon')
            ->leftJoin('KhachHang', 'HoaDon.MaKhachHang', '=', 'KhachHang.MaKhachHang')
            ->leftJoin('ChiTietHoaDon', 'HoaDon.MaHoaDon', '=', 'ChiTietHoaDon.MaHoaDon')
            ->select(
                'HoaDon.*', 
                'KhachHang.HoTen',
                DB::raw('COUNT(CASE WHEN ChiTietHoaDon.MaVatTu IS NOT NULL THEN 1 END) as has_vattu')
            )
            ->where('HoaDon.TrangThai', 'Từ Chối Đơn Hàng')
            ->groupBy('HoaDon.MaHoaDon', 'HoaDon.NgayXuatHoaDon','HoaDon.MaLichKham', 'HoaDon.MaKhachHang', 
                     'HoaDon.TrangThai', 'HoaDon.LoaiGiaoDich', 'HoaDon.TongTien', 'KhachHang.HoTen')
            ->orderByDesc('HoaDon.NgayXuatHoaDon');
        $invoices = [
            'pending' => $pendingQuery->get(),
            'confirmed' => $confirmedQuery->get(),
            'in-progress' => $inProgressQuery->get(),
            'completed' => $completedQuery->get(),
            'rejected' => $rejectedQuery->get()

        ];

        $statusOptions = [
            'VatTu' => $this->vatTuStatuses,
            'DichVu' => $this->dichVuStatuses
        ];

        return view('invoice.index', compact('invoices', 'statusOptions'));
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $invoice = DB::table('HoaDon')->where('MaHoaDon', $id)->first();
    
            if ($request->status == 'Từ Chối Đơn Hàng' && $invoice->LoaiGiaoDich == 'Banking') {
                DB::table('XuLyVanDe')->insert([
                    'MaHoaDon' => $id,
                    'TrangThai' => 'Chờ xử lý',
                    'MoTa' => 'Hoàn tiền đơn hàng đã chuyển khoản trước',
                ]);
            }
    
            DB::table('HoaDon')
                ->where('MaHoaDon', $id)
                ->update(['TrangThai' => $request->status]);
    
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    

    public function getDetail($id)
    {
        $invoice = DB::table('HoaDon')
            ->leftJoin('KhachHang', 'HoaDon.MaKhachHang', '=', 'KhachHang.MaKhachHang')
            ->leftJoin('ChiTietHoaDon', 'HoaDon.MaHoaDon', '=', 'ChiTietHoaDon.MaHoaDon')
            ->leftJoin('VatTu', 'ChiTietHoaDon.MaVatTu', '=', 'VatTu.MaVatTu')
            ->leftJoin('DichVu', 'ChiTietHoaDon.MaDichVu', '=', 'DichVu.MaDichVu')
            ->select(
                'HoaDon.*',
                'KhachHang.HoTen as TenKhachHang',
                'ChiTietHoaDon.*',
                'VatTu.TenVatTu', 
                'VatTu.DonGiaBan', 
                'VatTu.HinhAnh as VatTuHinhAnh', 
                'DichVu.TenDichVu',
                'DichVu.DonGia',
                'DichVu.HinhAnh as DichVuHinhAnh' 
            )
            ->where('HoaDon.MaHoaDon', $id)
            ->get();

        return view('invoice.detail', compact('invoice'));
    }
    public function show($id)
    {
        $invoice = DB::table('HoaDon')
            ->leftJoin('KhachHang', 'HoaDon.MaKhachHang', '=', 'KhachHang.MaKhachHang')
            ->leftJoin('ChiTietHoaDon', 'HoaDon.MaHoaDon', '=', 'ChiTietHoaDon.MaHoaDon')
            ->leftJoin('VatTu', 'ChiTietHoaDon.MaVatTu', '=', 'VatTu.MaVatTu')
            ->leftJoin('DichVu', 'ChiTietHoaDon.MaDichVu', '=', 'DichVu.MaDichVu')
            ->leftJoin('LichKham', 'HoaDon.MaLichKham', '=', 'LichKham.MaLichKham')
            ->select(
                'HoaDon.*',
                'KhachHang.HoTen as TenKhachHang',
                'ChiTietHoaDon.*',
                'VatTu.TenVatTu',
                'DichVu.TenDichVu',
                'LichKham.NgayKham',
                'LichKham.GioKham',
                'LichKham.DiaChi',
                'LichKham.ChuanDoan',
                'LichKham.ChiPhiKham',
                'DichVu.HinhAnh as DichVuHinhAnh',
                'VatTu.HinhAnh as VatTuHinhAnh',
                'DichVu.DonGia',
                'VatTu.DonGiaBan'
            )
            ->where('HoaDon.MaHoaDon', $id)
            ->get();
    
        return response()->json([
            'invoice' => $invoice
        ]);
    }
    

}