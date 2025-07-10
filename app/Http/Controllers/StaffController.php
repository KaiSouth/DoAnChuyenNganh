<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $activeTab = $request->input('tab', 'bacsi'); // Default tab is 'bacsi'
        
        $page = $request->input($activeTab === 'bacsi' ? 'bacsi_page' : 'nhanvien_page', 1);
        
        $bacSis = DB::table('BacSi')
            ->where('Deleted', false) // Filter for non-deleted staff
            ->when($search, function ($query, $search) {
                return $query->where('HoTen', 'LIKE', "%$search%")
                            ->orWhere('ChuyenMon', 'LIKE', "%$search%");
            })
            ->paginate(5, ['*'], 'bacsi_page', $activeTab === 'bacsi' ? $page : 1);
        
        $nhanViens = DB::table('NhanVien')
            ->where('Deleted', false) // Filter for non-deleted staff
            ->when($search, function ($query, $search) {
                return $query->where('TenNhanVien', 'LIKE', "%$search%")
                            ->orWhere('ChucVu', 'LIKE', "%$search%");
            })
            ->paginate(5, ['*'], 'nhanvien_page', $activeTab === 'nhanvien' ? $page : 1);
        
        return view('Staff.index', compact('bacSis', 'nhanViens', 'search', 'activeTab'));
    }

    
    public function create()
    {
        return view('Staff.create');
    }

    public function store(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'staffType' => 'required|in:bacsi,nhanvien',
            'TaiKhoan' => 'required|string|max:50', 
            'MatKhau' => 'required|string|min:6|max:255', // Validate MatKhau
        ]);
 // Validate TaiKhoan
            $hashedPassword=Hash::make($request->input('MatKhau'));
        try {
            $staffType = $request->input('staffType');
            
            if ($staffType === 'bacsi') {
                $data = [
                    'HoTen' => $request->input('HoTen'),
                    'ChuyenMon' => $request->input('ChuyenMon'),
                    'NgaySinh' => $request->input('NgaySinh'),
                    'GioiTinh' => $request->input('GioiTinh'),
                    'SDT' => $request->input('SDT'),
                    'LuongTheoGio' => $request->input('LuongTheoGio'),
                    'Email' => $request->input('Email'),
                    'TaiKhoan' => $request->input('TaiKhoan'), // Add TaiKhoan
                    'MatKhau' => $hashedPassword  // Store the MatKhau as plain text
                ];
                
                // Log để debug
                \Log::info('Dữ liệu bác sĩ:', $data);
                
                DB::table('BacSi')->insert($data);
                
            } elseif ($staffType === 'nhanvien') {
                $data = [
                    'TenNhanVien' => $request->input('TenNhanVien'),
                    'ChucVu' => $request->input('ChucVu'),
                    'SDT' => $request->input('SDT'),
                    'Email' => $request->input('Email'),
                    'LuongTheoGio' => $request->input('LuongTheoGio'),
                    'TaiKhoan' => $request->input('TaiKhoan'), // Add TaiKhoan
                    'MatKhau' => $hashedPassword // Store the MatKhau as plain text
                ];
                
                // Log để debug
                \Log::info('Dữ liệu nhân viên:', $data);
                
                DB::table('NhanVien')->insert($data);
            }

            return response()->json([
                'success' => true,
                'message' => 'Thêm nhân sự thành công'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Lỗi khi thêm nhân sự: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }


    public function edit($staffType, $id)
    {
        if ($staffType === 'bacsi') {
            $staff = DB::table('BacSi')->where('MaBacSi', $id)->first();
            return view('Staff.edit', compact('staff', 'staffType'));
        } elseif ($staffType === 'nhanvien') {
            $staff = DB::table('NhanVien')->where('MaNhanVien', $id)->first();
            return view('Staff.edit', compact('staff', 'staffType'));
        }
    }

    public function update(Request $request)
{
    $request->validate([
        'staffType' => 'required|in:bacsi,nhanvien',
        'id' => 'required',
    ]);

    try {
        $staffType = $request->input('staffType');
        $id = $request->input('id');
        
        // Lấy thông tin password từ request
        $password = $request->input('MatKhau');

        // Tạo một mảng dữ liệu để cập nhật
        $updateData = $request->except(['_token', 'staffType', 'id']);

        // Nếu password không rỗng, hash nó trước khi cập nhật
        if (!empty($password)) {
            $updateData['MatKhau'] = Hash::make($password);  // Hash mật khẩu
        } else {
            // Nếu password rỗng, xóa trường 'MatKhau' khỏi mảng dữ liệu
            unset($updateData['MatKhau']);
        }

        // Cập nhật dữ liệu vào bảng tương ứng
        if ($staffType === 'bacsi') {
            DB::table('BacSi')->where('MaBacSi', $id)->update($updateData);
        } elseif ($staffType === 'nhanvien') {
            DB::table('NhanVien')->where('MaNhanVien', $id)->update($updateData);
        }

        return response()->json(['success' => true, 'message' => 'Cập nhật thành công']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()], 500);
    }
}

    

    public function destroy(Request $request)
    {
        $staffType = $request->input('staffType');
        $id = $request->input('id');
    
        if ($staffType === 'bacsi') {
            // Set Deleted column to true instead of deleting
            DB::table('BacSi')->where('MaBacSi', $id)->update(['Deleted' => true]);
        } elseif ($staffType === 'nhanvien') {
            // Set Deleted column to true instead of deleting
            DB::table('NhanVien')->where('MaNhanVien', $id)->update(['Deleted' => true]);
        }
    
        return response()->json(['success' => true, 'message' => 'Đánh dấu nhân sự là đã xóa thành công']);
    }
    
    public function getStaffDetail(Request $request)
    {
        $staffType = $request->input('staffType');
        $id = $request->input('id');

        try {
            if ($staffType === 'bacsi') {
                $staff = DB::table('BacSi')->where('MaBacSi', $id)->first();
            } elseif ($staffType === 'nhanvien') {
                $staff = DB::table('NhanVien')->where('MaNhanVien', $id)->first();
            }

            if ($staff) {
                return response()->json([
                    'success' => true,
                    'data' => $staff,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy nhân sự',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage(),
            ], 500);
        }
    }

}