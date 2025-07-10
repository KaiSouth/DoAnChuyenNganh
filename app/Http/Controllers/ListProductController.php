<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class ListProductController extends Controller
{
    public function index(Request $request)
    {
        // Lấy ngày hiện tại
        $today = now()->format('Y-m-d'); // Hoặc sử dụng Carbon::today()
        
        // Lấy danh sách vật tư và thêm thuộc tính type
        $vattu = DB::table('vattu')
            ->join('loaivattu', 'vattu.MaLoaiVatTu', '=', 'loaivattu.MaLoaiVatTu')
            ->leftJoin('nhacungcap', 'vattu.MaNhaCungCap', '=', 'nhacungcap.MaNhaCungCap')
            ->leftJoin('chitietchuongtrinhgiamgia', 'vattu.MaVatTu', '=', 'chitietchuongtrinhgiamgia.MaVatTu')
            ->leftJoin('chuongtrinhgiamgia', 'chitietchuongtrinhgiamgia.MaChuongTrinhGiamGia', '=', 'chuongtrinhgiamgia.MaChuongTrinhGiamGia')
            ->select('vattu.*', 'loaivattu.TenLoaiVatTu', 'nhacungcap.TenNhaCungCap', 'chitietchuongtrinhgiamgia.PhanTramGiam', 'chitietchuongtrinhgiamgia.GiamToiDa','chuongtrinhgiamgia.*')
            ->where('vattu.Deleted', false)
            ->distinct('vattu.MaVatTu') // Đảm bảo không có duplicate theo MaVatTu
            ->get()
            ->map(function ($item) {
                $price = isset($item->DonGiaBan) ? $item->DonGiaBan : 0;

                // Kiểm tra ngày hợp lệ của chương trình giảm giá
                $isDiscountValid = isset($item->NgayBatDau, $item->NgayKetThuc)
                    && now()->between($item->NgayBatDau, $item->NgayKetThuc);

                if ($isDiscountValid && $item->PhanTramGiam > 0) {
                    $discountAmount = ($price * $item->PhanTramGiam) / 100;
                    $item->GiaSauGiam = max($price - $discountAmount, 0); // Không cho phép giá âm
                } else {
                    $item->GiaSauGiam = $price;
                }

                $item->type = 'vat_tu';
                return $item;
            });
        
        $dichvu = DB::table('dichvu')
            ->join('loaidichvu', 'dichvu.MaLoaiDichVu', '=', 'loaidichvu.MaLoaiDichVu')
            ->leftJoin('chitietchuongtrinhgiamgia', 'dichvu.MaDichVu', '=', 'chitietchuongtrinhgiamgia.MaDichVu')
            ->select('dichvu.*', 'loaidichvu.TenLoaiDichVu', 'chitietchuongtrinhgiamgia.PhanTramGiam', 'chitietchuongtrinhgiamgia.GiamToiDa', 'dichvu.DonGia as DonGiaBan') // alias DonGia thành DonGiaBan
            ->where('dichvu.Deleted', false)
            ->distinct('dichvu.MaDichVu') // Đảm bảo không có duplicate theo MaDichVu
            ->get()
            ->map(function ($item) {
                // Sử dụng DonGiaBan sau khi đã alias
                $price = isset($item->DonGiaBan) ? $item->DonGiaBan : 0;
                $isDiscountValid = isset($item->NgayBatDau, $item->NgayKetThuc)
                && now()->between($item->NgayBatDau, $item->NgayKetThuc);

                if (   $isDiscountValid &&$item->PhanTramGiam > 0) {
                    $discountAmount = ($price * $item->PhanTramGiam) / 100;
                    $item->GiaSauGiam = $price - $discountAmount;
                    if ($item->GiaSauGiam < 0) {
                        $item->GiaSauGiam = 0;
                    }
                } else {
                    $item->GiaSauGiam = $price;
                }
                
                $item->type = 'dich_vu';
                return $item;
            });
        
        // Gộp hai danh sách và phân trang thủ công
        $combined = $vattu->merge($dichvu);
        $page = $request->input('page', 1);
        $perPage = 9;
        $total = $combined->count();
        $offset = ($page - 1) * $perPage;
        $currentPageItems = $combined->slice($offset, $perPage)->all();
        
        $paginatedItems = new LengthAwarePaginator(
            $currentPageItems,
            $total,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
        
        return view('listproduct', [
            'vattu' => $paginatedItems,
            'loaivattu' => DB::table('loaivattu')->get(),
            'dichvu' => $paginatedItems,
            'loaidichvu' => DB::table('loaidichvu')->get()
        ]);
    }
    
    public function filter(Request $request)
    {
        $type = $request->input('type');
        $categories = $request->input('categories', []);
        $page = $request->input('page', 1);
    
        if ($type == 'vat_tu') {
            $query = DB::table('vattu')
                ->join('loaivattu', 'vattu.MaLoaiVatTu', '=', 'loaivattu.MaLoaiVatTu')
                ->leftJoin('nhacungcap', 'vattu.MaNhaCungCap', '=', 'nhacungcap.MaNhaCungCap')
                ->leftJoin('chitietchuongtrinhgiamgia', 'vattu.MaVatTu', '=', 'chitietchuongtrinhgiamgia.MaVatTu')
                ->leftJoin('chuongtrinhgiamgia', 'chitietchuongtrinhgiamgia.MaChuongTrinhGiamGia', '=', 'chuongtrinhgiamgia.MaChuongTrinhGiamGia')
                ->select('vattu.*', 'loaivattu.TenLoaiVatTu', 'nhacungcap.TenNhaCungCap', 
                         'chitietchuongtrinhgiamgia.PhanTramGiam', 'chitietchuongtrinhgiamgia.GiamToiDa', 
                         'chuongtrinhgiamgia.NgayBatDau', 'chuongtrinhgiamgia.NgayKetThuc')
                ->where('vattu.Deleted', false);
    
            if (!empty($categories)) {
                $query->whereIn('vattu.MaLoaiVatTu', $categories);
            }
    
            $products = $query->paginate(9);
    
            // Biến đổi dữ liệu cho phản hồi
            $transformedProducts = $products->items();
            foreach ($transformedProducts as $product) {
                $price = isset($product->DonGiaBan) ? $product->DonGiaBan : 0;
    
                $isDiscountValid = isset($product->NgayBatDau, $product->NgayKetThuc) 
                    && now()->between($product->NgayBatDau, $product->NgayKetThuc);
    
                if ($isDiscountValid && $product->PhanTramGiam > 0) {
                    $discountAmount = ($price * $product->PhanTramGiam) / 100;
                    $product->GiaSauGiam = max($price - $discountAmount, 0);
                } else {
                    $product->GiaSauGiam = $price;
                }
    
                $product->type = 'vat_tu';
                $product->Ten = $product->TenVatTu;
                $product->Gia = $product->GiaSauGiam;
            }
    
            return response()->json([
                'data' => $transformedProducts,
                'pagination' => [
                    'total' => $products->total(),
                    'per_page' => $products->perPage(),
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'from' => $products->firstItem(),
                    'to' => $products->lastItem()
                ]
            ]);
        } elseif ($type == 'dich_vu') {
            $query = DB::table('dichvu')
                ->join('loaidichvu', 'dichvu.MaLoaiDichVu', '=', 'loaidichvu.MaLoaiDichVu')
                ->leftJoin('chitietchuongtrinhgiamgia', 'dichvu.MaDichVu', '=', 'chitietchuongtrinhgiamgia.MaDichVu')
                ->leftJoin('chuongtrinhgiamgia', 'chitietchuongtrinhgiamgia.MaChuongTrinhGiamGia', '=', 'chuongtrinhgiamgia.MaChuongTrinhGiamGia')
                ->select('dichvu.*', 'loaidichvu.TenLoaiDichVu', 
                         'chitietchuongtrinhgiamgia.PhanTramGiam', 'chitietchuongtrinhgiamgia.GiamToiDa', 
                         'chuongtrinhgiamgia.NgayBatDau', 'chuongtrinhgiamgia.NgayKetThuc', 
                         'dichvu.DonGia as DonGiaBan')
                ->where('dichvu.Deleted', false);
    
            if (!empty($categories)) {
                $query->whereIn('loaidichvu.MaLoaiDichVu', $categories);
            }
    
            $products = $query->paginate(9);
    
            // Biến đổi dữ liệu cho phản hồi
            $transformedProducts = $products->items();
            foreach ($transformedProducts as $product) {
                $price = isset($product->DonGiaBan) ? $product->DonGiaBan : 0;
    
                $isDiscountValid = isset($product->NgayBatDau, $product->NgayKetThuc) 
                    && now()->between($product->NgayBatDau, $product->NgayKetThuc);
    
                if ($isDiscountValid && $product->PhanTramGiam > 0) {
                    $discountAmount = ($price * $product->PhanTramGiam) / 100;
                    $product->GiaSauGiam = max($price - $discountAmount, 0);
                } else {
                    $product->GiaSauGiam = $price;
                }
    
                $product->type = 'dich_vu';
                $product->Ten = $product->TenDichVu;
                $product->Gia = $product->GiaSauGiam;
            }
    
            return response()->json([
                'data' => $transformedProducts,
                'pagination' => [
                    'total' => $products->total(),
                    'per_page' => $products->perPage(),
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'from' => $products->firstItem(),
                    'to' => $products->lastItem()
                ]
            ]);
        }
    
        return response()->json([
            'data' => [],
            'pagination' => [
                'total' => 0,
                'per_page' => 9,
                'current_page' => 1,
                'last_page' => 1,
                'from' => 0,
                'to' => 0
            ]
        ]);
    }
    
    
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $page = $request->input('page', 1);
        $perPage = 9;
    
        $vattu = DB::table('vattu')
            ->join('loaivattu', 'vattu.MaLoaiVatTu', '=', 'loaivattu.MaLoaiVatTu')
            ->leftJoin('nhacungcap', 'vattu.MaNhaCungCap', '=', 'nhacungcap.MaNhaCungCap')
            ->leftJoin('chitietchuongtrinhgiamgia', 'vattu.MaVatTu', '=', 'chitietchuongtrinhgiamgia.MaVatTu')
            ->leftJoin('chuongtrinhgiamgia', 'chitietchuongtrinhgiamgia.MaChuongTrinhGiamGia', '=', 'chuongtrinhgiamgia.MaChuongTrinhGiamGia')
            ->where('vattu.Deleted', false)
            ->where('vattu.TenVatTu', 'LIKE', "%{$keyword}%")
            ->select('vattu.*', 'loaivattu.TenLoaiVatTu', 'nhacungcap.TenNhaCungCap', 
                     'chitietchuongtrinhgiamgia.PhanTramGiam', 'chitietchuongtrinhgiamgia.GiamToiDa', 
                     'chuongtrinhgiamgia.NgayBatDau', 'chuongtrinhgiamgia.NgayKetThuc')
            ->distinct('vattu.MaVatTu')
            ->get()
            ->map(function ($item) {
                $price = $item->DonGiaBan ?? 0;
    
                $isDiscountValid = isset($item->NgayBatDau, $item->NgayKetThuc) 
                    && now()->between($item->NgayBatDau, $item->NgayKetThuc);
    
                if ($isDiscountValid && $item->PhanTramGiam > 0) {
                    $discountAmount = ($price * $item->PhanTramGiam) / 100;
                    $item->GiaSauGiam = max($price - $discountAmount, 0);
                } else {
                    $item->GiaSauGiam = $price;
                }
    
                $item->type = 'vat_tu';
                return $item;
            });
    
        $dichvu = DB::table('dichvu')
            ->join('loaidichvu', 'dichvu.MaLoaiDichVu', '=', 'loaidichvu.MaLoaiDichVu')
            ->leftJoin('chitietchuongtrinhgiamgia', 'dichvu.MaDichVu', '=', 'chitietchuongtrinhgiamgia.MaDichVu')
            ->leftJoin('chuongtrinhgiamgia', 'chitietchuongtrinhgiamgia.MaChuongTrinhGiamGia', '=', 'chuongtrinhgiamgia.MaChuongTrinhGiamGia')
            ->where('dichvu.Deleted', false)
            ->where('dichvu.TenDichVu', 'LIKE', "%{$keyword}%")
            ->select('dichvu.*', 'loaidichvu.TenLoaiDichVu', 
                     'chitietchuongtrinhgiamgia.PhanTramGiam', 'chitietchuongtrinhgiamgia.GiamToiDa', 
                     'chuongtrinhgiamgia.NgayBatDau', 'chuongtrinhgiamgia.NgayKetThuc', 
                     'dichvu.DonGia as DonGiaBan')
            ->distinct('dichvu.MaDichVu')
            ->get()
            ->map(function ($item) {
                $price = $item->DonGiaBan ?? 0;
    
                $isDiscountValid = isset($item->NgayBatDau, $item->NgayKetThuc) 
                    && now()->between($item->NgayBatDau, $item->NgayKetThuc);
    
                if ($isDiscountValid && $item->PhanTramGiam > 0) {
                    $discountAmount = ($price * $item->PhanTramGiam) / 100;
                    $item->GiaSauGiam = max($price - $discountAmount, 0);
                } else {
                    $item->GiaSauGiam = $price;
                }
    
                $item->type = 'dich_vu';
                return $item;
            });
    
        $combined = $vattu->merge($dichvu);
    
        $total = $combined->count();
        $offset = ($page - 1) * $perPage;
        $currentPageItems = $combined->slice($offset, $perPage)->all();
    
        $paginatedItems = new LengthAwarePaginator(
            $currentPageItems,
            $total,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
    
        return response()->json([
            'data' => $paginatedItems->items(),
            'pagination' => [
                'total' => $paginatedItems->total(),
                'per_page' => $paginatedItems->perPage(),
                'current_page' => $paginatedItems->currentPage(),
                'last_page' => $paginatedItems->lastPage(),
                'from' => $paginatedItems->firstItem(),
                'to' => $paginatedItems->lastItem()
            ]
        ]);
    }
    
    public function getCategories(Request $request)
    {
        $type = $request->input('type');
        if ($type == 'vat_tu') {
            $categories = DB::table('loaivattu')->get(); // Lấy danh sách loại vật tư
        } elseif ($type == 'dich_vu') {
            $categories = DB::table('loaidichvu')->get(); // Lấy danh sách loại dịch vụ
        } else {
            $categories = [];
        }
        return response()->json($categories);
    }

}
