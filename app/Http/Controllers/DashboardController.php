<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Đếm số lượng cho các mục chính
        $khachHangCount = DB::table('KhachHang')->count();
        $thuCungCount = DB::table('ThuCung')->count();
        $vatTuCount = DB::table('VatTu')->count();
        $dichVuCount = DB::table('DichVu')->count();
        $hoaDonCount = DB::table('HoaDon')->count();

        $userStatisticsData = $this->getUserStatistics();  // Gọi hàm lấy thống kê người dùng
        $quarterlyStats = $this->getQuarterlyStats();

        // Kiểm tra nếu $quarterlyStats có giá trị thì gán vào các biến sử dụng
        if ($quarterlyStats) {
            $currentQuarter = $quarterlyStats['currentQuarter'];
            $quarterlySalesData = [
                'totalSales' => $quarterlyStats['totalSales'],
                'newSubscribers' => $quarterlyStats['newSubscribers']
            ];
        } else {
            // Trong trường hợp không có dữ liệu, có thể gán giá trị mặc định
            $currentQuarter = null;
            $quarterlySalesData = [
                'totalSales' => 0,
                'newSubscribers' => 0
            ];
        }

        // Lấy danh sách 10 khách hàng mới nhất
        $newCustomers = DB::table('KhachHang')
            ->orderBy('ngaydangki', 'desc')
            ->limit(9)
            ->get();
        $transactions = DB::table('HoaDon')
        ->orderBy('NgayXuatHoaDon', 'desc')
        ->limit(10)
        ->get();
        return view('admin_index', compact(
            'khachHangCount',
            'thuCungCount',
            'vatTuCount',
            'dichVuCount',
            'hoaDonCount',
            'newCustomers',
            'transactions',
            'userStatisticsData',
            'quarterlySalesData',
            'currentQuarter'

        ));
    }
    public function getUserStatistics()
    {
        // Lấy số lượng khách hàng đăng ký mới mỗi tháng
        $subscribers = DB::table('KhachHang')
            ->select(DB::raw('MONTH(ngaydangki) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('ngaydangki', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Lấy số lượng thú cưng mới mỗi tháng
        $newPets = DB::table('ThuCung')
            ->select(DB::raw('MONTH(ngaydangki) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('ngaydangki', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Lấy số lượng hóa đơn (active users) mỗi tháng
        $activeUsers = DB::table('HoaDon')
            ->select(DB::raw('MONTH(NgayXuatHoaDon) as month'), DB::raw('COUNT(DISTINCT MaKhachHang) as count'))
            ->whereYear('NgayXuatHoaDon', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Điền giá trị cho các tháng chưa có dữ liệu
        $subscribers = $this->fillMissingMonths($subscribers);
        $newPets = $this->fillMissingMonths($newPets);
        $activeUsers = $this->fillMissingMonths($activeUsers);

        return [
            'subscribers' => array_values($subscribers),
            'newVisitors' => array_values($newPets),
            'activeUsers' => array_values($activeUsers),
        ];
    }

    protected function fillMissingMonths($data)
    {
        $fullData = array_fill(1, 12, 0);  // Khởi tạo một mảng với 12 tháng, giá trị mặc định là 0
        foreach ($data as $month => $count) {
            $fullData[$month] = $count;
        }
        return $fullData;  // Trả về mảng đã được điền dữ liệu đầy đủ 12 tháng
    }
    private function getQuarterlyStats()
    {
        // Lấy quý hiện tại
        $currentMonth = date('n');
        $currentQuarter = ceil($currentMonth / 3);
    
        // Tính doanh thu và số người đăng ký mới trong quý hiện tại
        $totalSales = DB::table('HoaDon')
            ->whereRaw('QUARTER(NgayXuatHoaDon) = ?', [$currentQuarter])
            ->sum('TongTien');
    
        $newSubscribers = DB::table('KhachHang')
            ->whereRaw('QUARTER(ngaydangki) = ?', [$currentQuarter])
            ->count();
    
        return [
            'currentQuarter' => $currentQuarter,
            'totalSales' => $totalSales,
            'newSubscribers' => $newSubscribers
        ];
    }


}
