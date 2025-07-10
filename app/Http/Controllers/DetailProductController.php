<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailProductController extends Controller
{
    public function show($id, Request $request)
    {
        // Lấy type từ query string
        $type = $request->query('type');
    
        // Kiểm tra type hợp lệ
        if (!in_array($type, ['vat_tu', 'dich_vu'])) {
            abort(404, 'Loại sản phẩm không tồn tại');
        }
    
        // Lấy thông tin sản phẩm hoặc dịch vụ
        if ($type === 'vat_tu') {
            $product = DB::table('vattu')->where('MaVatTu', $id)->first();
    
            if (!$product) {
                abort(404, 'Sản phẩm không tồn tại');
            }
    
            $category = DB::table('loaivattu')
                ->where('MaLoaiVatTu', $product->MaLoaiVatTu)
                ->first();
    
            $stock = DB::table('lohang')
                ->where('MaVatTu', $id)
                ->sum('SoLuongTonKho');
    
            // Kiểm tra chương trình giảm giá
            $discount = DB::table('chitietchuongtrinhgiamgia')
                ->join('chuongtrinhgiamgia', 'chitietchuongtrinhgiamgia.MaChuongTrinhGiamGia', '=', 'chuongtrinhgiamgia.MaChuongTrinhGiamGia')
                ->where('chitietchuongtrinhgiamgia.MaVatTu', $id)
                ->where('chuongtrinhgiamgia.NgayBatDau', '<=', now())
                ->where('chuongtrinhgiamgia.NgayKetThuc', '>=', now())
                ->first();
    
            $product->GiaSauGiam = $this->calculateDiscountedPrice($product->DonGiaBan, $discount);
            $product->discount = $discount;
    
        } elseif ($type === 'dich_vu') {
            $product = DB::table('dichvu')->where('MaDichVu', $id)->first();
    
            if (!$product) {
                abort(404, 'Dịch vụ không tồn tại');
            }
    
            $category = DB::table('loaidichvu')
                ->where('MaLoaiDichVu', $product->MaLoaiDichVu)
                ->first();
    
            $stock = null;
    
            $discount = DB::table('chitietchuongtrinhgiamgia')
                ->join('chuongtrinhgiamgia', 'chitietchuongtrinhgiamgia.MaChuongTrinhGiamGia', '=', 'chuongtrinhgiamgia.MaChuongTrinhGiamGia')
                ->where('chitietchuongtrinhgiamgia.MaDichVu', $id)
                ->where('chuongtrinhgiamgia.NgayBatDau', '<=', now())
                ->where('chuongtrinhgiamgia.NgayKetThuc', '>=', now())
                ->first();
    
            $product->GiaSauGiam = $this->calculateDiscountedPrice($product->DonGia, $discount);
            $product->discount = $discount;
        }
    
        // Lấy danh sách thú cưng (nếu cần thiết cho giao diện)
        $pets = DB::table('ThuCung')
            ->where('MaKhachHang', session('user_id'))
            ->get();
    
        return view('detailproduct', [
            'product' => $product,
            'category' => $category,
            'type' => $type,
            'stock' => $stock,
            'pets' => $pets
        ]);
    }
    
    
    private function calculateDiscountedPrice($price, $discount)
    {
        if ($discount) {
            $discountAmount = ($price * $discount->PhanTramGiam) / 100;
            $priceAfterDiscount = max($price - $discountAmount, 0); // Không cho phép giá âm
            return $priceAfterDiscount;
        }
        return $price; // Không có giảm giá, trả về giá gốc
    }
    
}
