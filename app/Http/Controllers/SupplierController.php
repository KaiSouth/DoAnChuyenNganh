<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('NhaCungCap');
        
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('TenNhaCungCap', 'like', "%{$searchTerm}%")
                  ->orWhere('SDT', 'like', "%{$searchTerm}%")
                  ->orWhere('Email', 'like', "%{$searchTerm}%");
            });
        }
        
        $suppliers = $query->paginate(10);
        return view('suppliers.index', compact('suppliers'));
    }
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'TenNhaCungCap' => 'required|string|max:255',
                'SDT' => 'required|string|max:15',
                'Email' => 'required|email|unique:NhaCungCap,Email',
            ]);
    
            DB::table('NhaCungCap')->insert([
                'TenNhaCungCap' => $request->TenNhaCungCap,
                'SDT' => $request->SDT,
                'Email' => $request->Email,
            ]);
    
            return response()->json(['success' => true, 'message' => 'Nhà cung cấp đã được thêm thành công!']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Lỗi xác thực: ' . $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Supplier Store Error: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
    public function edit($id)
    {
        $supplier = DB::table('NhaCungCap')->where('MaNhaCungCap', $id)->first();

        if ($supplier) {
            return response()->json(['success' => true, 'supplier' => $supplier]);
        }

        return response()->json(['success' => false, 'message' => 'Nhà cung cấp không tồn tại']);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'TenNhaCungCap' => 'required|string|max:255',
            'SDT' => 'required|string|max:15',
            'Email' => 'required|email|max:255',
        ]);

        try {
            $updated = DB::table('NhaCungCap')
                ->where('MaNhaCungCap', $id)
                ->update([
                    'TenNhaCungCap' => $request->TenNhaCungCap,
                    'SDT' => $request->SDT,
                    'Email' => $request->Email,
                ]);

            if ($updated) {
                return response()->json(['success' => true, 'message' => 'Cập nhật nhà cung cấp thành công!']);
            }

            return response()->json(['success' => false, 'message' => 'Nhà cung cấp không tồn tại']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Cập nhật nhà cung cấp thất bại: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $deleted = DB::table('NhaCungCap')->where('MaNhaCungCap', $id)->delete();

            if ($deleted) {
                return response()->json(['success' => true, 'message' => 'Xóa nhà cung cấp thành công!']);
            }

            return response()->json(['success' => false, 'message' => 'Nhà cung cấp không tồn tại']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Xóa nhà cung cấp thất bại: ' . $e->getMessage()]);
        }
    }
}
