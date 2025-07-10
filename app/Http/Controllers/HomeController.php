<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Cloudinary\Cloudinary;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log; // Thêm Log

class HomeController extends Controller
{
    // Hàm index để lấy dữ liệu và trả về view
    public function index()
    {
        // Query dữ liệu từ bảng 'vattu'
        $today = now()->format('Y-m-d'); // Giữ nguyên cách dùng này
        $vattu = DB::table('VatTu')
            ->leftJoin('chitietchuongtrinhgiamgia', 'VatTu.MaVatTu', '=', 'chitietchuongtrinhgiamgia.MaVatTu')
            ->leftJoin('chuongtrinhgiamgia', 'chitietchuongtrinhgiamgia.MaChuongTrinhGiamGia', '=', 'chuongtrinhgiamgia.MaChuongTrinhGiamGia')
            ->select('VatTu.*', 'chitietchuongtrinhgiamgia.PhanTramGiam', 'chitietchuongtrinhgiamgia.GiamToiDa', 'chuongtrinhgiamgia.NgayBatDau', 'chuongtrinhgiamgia.NgayKetThuc')
            ->where('Deleted', false)
            ->get(10)
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
                $item->isDiscountActive = $isDiscountActive;
                return $item;
            });
        $bacsi = DB::table('bacsi')->limit(10)->get();
        return view('index', compact('vattu', 'bacsi'));
    }

    public function about(){
        $bacsi = DB::table('bacsi')->limit(10)->get();
        return view('about',['bacsi'=>$bacsi]);
    }


}
