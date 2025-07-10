<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListProductController;
use App\Http\Controllers\DetailProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ProductServiceController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StockEntryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\DuyController;
use App\Http\Controllers\LuanController;
use Illuminate\Support\Facades\DB;

// Đăng nhập và Đăng ký
Route::get('/login', [DuyController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [DuyController::class, 'handleLogin'])->name('login.handle');
Route::get('/register', [DuyController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [DuyController::class, 'handleRegister'])->name('register.handle');
Route::get('/logout', [DuyController::class, 'logout'])->name('logout');
Route::get('/logoutUser', [DuyController::class, 'logoutUser'])->name('logoutUser');


//Custom phân quyền
Route::get('/authCustom-login', [DuyController::class, 'authCustomshowLoginForm'])->name('authCustom.login.form');
Route::post('/authCustom-login', [DuyController::class, 'authCustomhandleLogin'])->name('authCustom.login.handle');

// Đặt lịch khám chỉ dành cho người dùng đã đăng nhập
Route::middleware('auth.custom')->group(function () {
    Route::get('/dat-lich-kham', [DuyController::class, 'showAppointmentForm'])->name('appointment.form');
    Route::post('/dat-lich-kham', [DuyController::class, 'handleAppointment'])->name('appointment.handle');
});

// Các route khác
Route::get('/detailserviceproduct/{id}', [DetailProductController::class, 'show'])->name('detailserviceproduct');
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/listproduct', [ListProductController::class, 'index'])->name('listproduct');
Route::post('/filter', [ListProductController::class, 'filter'])->name('filter');
Route::post('/search', [ListProductController::class, 'search'])->name('search');
Route::post('/get-categories', [ListProductController::class, 'getCategories'])->name('get-categories');
Route::get('/about', [HomeController::class,'about'])->name('about');

Route::get('/service', function () {
    return view('service');
})->name('service');

Route::middleware(['auth.custom.role'])->group(function () {
    Route::get('/quanly', [DashboardController::class, 'index'])->name('quanly');
});


// Promotions
//nhân viên
Route::get('promotions', [PromotionController::class, 'index'])->middleware('auth.custom.role:employee,manager')->name('promotions.index');
Route::get('promotions/{id}', [PromotionController::class, 'show'])->middleware('auth.custom.role:employee,manager')->name('promotions.show');
//admin
Route::post('promotions', [PromotionController::class, 'store'])->middleware('auth.custom.role:manager')->name('promotions.store');
Route::get('promotions/{id}/edit', [PromotionController::class, 'edit'])->middleware('auth.custom.role:manager')->name('promotions.edit');
Route::put('promotions/{id}', [PromotionController::class, 'update'])->middleware('auth.custom.role:manager')->name('promotions.update');
Route::delete('promotions/{id}', [PromotionController::class, 'destroy'])->middleware('auth.custom.role:manager')->name('promotions.destroy');
Route::get('promotions/{promotionId}/details/{detailId}/edit', [PromotionController::class, 'editDetail'])->middleware('auth.custom.role:manager')->name('promotions.editDetail');
Route::put('promotions/{promotionId}/details/{detailId}', [PromotionController::class, 'updateDetail'])->middleware('auth.custom.role:manager')->name('promotions.updateDetail');
Route::get('promotions/{promotionId}/details/add', [PromotionController::class, 'addDetail'])->middleware('auth.custom.role:manager')->name('promotions.addDetail');
Route::post('promotions/{promotionId}/details', [PromotionController::class, 'storeDetail'])->middleware('auth.custom.role:manager')->name('promotions.storeDetail');
Route::delete('promotions/{promotionId}/details/{detailId}', [PromotionController::class, 'deleteDetail'])->middleware('auth.custom.role:manager')->name('promotions.deleteDetail');
Route::put('promotions/{id}/edit/updateCTRKM', [PromotionController::class, 'updateCtrKM'])
    ->middleware('auth.custom.role:manager')
    ->name('promotions.updateCtrKM');


// Products and Services
//nhân viên
Route::get('products-services', [ProductServiceController::class, 'index'])->middleware('auth.custom.role:employee,manager')->name('products_services.index');
Route::get('products-services/edit/{itemType}/{id}', [ProductServiceController::class, 'edit'])->middleware('auth.custom.role:employee,manager')->name('products_services.edit');
Route::get('products-services/trash', action: [ProductServiceController::class, 'trash'])->middleware('auth.custom.role:employee,manager')->name('products_services.trash');

//admin
Route::post('products-services/add-item', [ProductServiceController::class, 'store'])->middleware('auth.custom.role:manager')->name('products_services.store');
Route::post('products-services/undo-delete', [ProductServiceController::class, 'undoDelete'])->middleware('auth.custom.role:manager')->name('products_services.undo-delete');
Route::post('products-services/delete-item', [ProductServiceController::class, 'softDelete'])->middleware('auth.custom.role:manager')->name('products_services.softDelete');
Route::post('products-services/update/{itemType}/{id}', [ProductServiceController::class, 'update'])->middleware('auth.custom.role:manager')->name('products_services.update');

// Suppliers
//nhân viên
Route::get('suppliers', [SupplierController::class, 'index'])->middleware('auth.custom.role:employee,manager')->name('suppliers.index');
Route::get('suppliers/{id}/edit', [SupplierController::class, 'edit'])->middleware('auth.custom.role:employee,manager')->name('suppliers.edit');
//admin
Route::post('suppliers/store', [SupplierController::class, 'store'])->middleware('auth.custom.role:manager')->name('suppliers.store');
Route::post('suppliers/update/{id}', [SupplierController::class, 'update'])->middleware('auth.custom.role:manager')->name('suppliers.update');
Route::delete('suppliers/{id}', [SupplierController::class, 'destroy'])->middleware('auth.custom.role:manager')->name('suppliers.destroy');

// Staff
//admin
Route::get('staff', [StaffController::class, 'index'])->middleware('auth.custom.role:manager')->name('staff.index');
Route::get('staff/detail', [StaffController::class, 'getStaffDetail'])->middleware('auth.custom.role:manager')->name('staff.detail');
Route::get('staff/create', [StaffController::class, 'create'])->middleware('auth.custom.role:manager')->name('staff.create');
Route::post('staff/store', [StaffController::class, 'store'])->middleware('auth.custom.role:manager')->name('staff.store');
Route::get('staff/edit/{staffType}/{id}', [StaffController::class, 'edit'])->middleware('auth.custom.role:manager')->name('staff.edit');
Route::post('staff/update', [StaffController::class, 'update'])->middleware('auth.custom.role:manager')->name('staff.update');
Route::post('staff/destroy', [StaffController::class, 'destroy'])->middleware('auth.custom.role:manager')->name('staff.destroy');

// Stock Entry
//nhân viên
Route::get('StockEntry', [StockEntryController::class, 'index'])->middleware('auth.custom.role:employee,manager')->name('StockEntry.index');
Route::post('StockEntry/store', [StockEntryController::class, 'store'])->middleware('auth.custom.role:employee,manager')->name('StockEntry.store');
Route::get('StockEntry/{id}/edit', [StockEntryController::class, 'edit'])->middleware('auth.custom.role:employee,manager')->name('StockEntry.edit');
Route::post('StockEntry/update/{id}', [StockEntryController::class, 'update'])->middleware('auth.custom.role:employee,manager')->name('StockEntry.update');
Route::delete('StockEntry/{id}', [StockEntryController::class, 'destroy'])->middleware('auth.custom.role:employee,manager')->name('StockEntry.destroy');
Route::get('StockEntry/create', [StockEntryController::class, 'create'])->middleware('auth.custom.role:employee,manager')->name('StockEntry.create');
Route::get('StockEntry/suppliers/{supplierId}/materials', [StockEntryController::class, 'getMaterialsBySupplier'])->middleware('auth.custom.role:employee,manager');
Route::get('StockEntry/{id}/details', [StockEntryController::class, 'show'])->middleware('auth.custom.role:employee,manager')->name('StockEntry.show');

// Invoices
//nhân viên
Route::get('invoices', [InvoiceController::class, 'index'])->middleware('auth.custom.role:employee,manager')->name('invoice.index');
Route::get('invoices/{id}', [InvoiceController::class, 'show'])->middleware('auth.custom.role:employee,manager')->name('invoice.details');
Route::post('invoices/{id}/update-status', [InvoiceController::class, 'updateStatus'])->middleware('auth.custom.role:employee,manager')->name('invoice.updateStatus');

// Issues
//nhân viên
Route::get('issues', [IssueController::class, 'index'])->middleware('auth.custom.role:employee,manager')->name('issues.index');
Route::get('issues/{id}', [IssueController::class, 'show'])->middleware('auth.custom.role:employee,manager');
//admin
Route::get('issues/{id}/resolve', [IssueController::class, 'resolveIssue'])->middleware('auth.custom.role:manager');
Route::post('issues/{id}/resolve', [IssueController::class, 'storeResolvedIssue'])->middleware('auth.custom.role:manager');

//duy
Route::post('/place-order-online', [DuyController::class, 'placeOrderOnline'])->name('placeOrderOnline');

Route::prefix('admin')->middleware('auth.custom.role:manager,doctor')->group(function () {
    // Liệt kê tất cả các phân công công việc
    Route::get('/assignments', [DuyController::class, 'adminIndex'])->name('admin.assignments.index');
    // Hiển thị form thêm mới phân công công việc
    Route::get('/assignments/create', [DuyController::class, 'adminCreate'])->name('admin.assignments.create');
    // Xử lý lưu phân công công việc mới
    Route::post('/assignments', [DuyController::class, 'adminStore'])->name('admin.assignments.store');
    // Hiển thị form chỉnh sửa phân công công việc
    Route::get('/assignments/{id}/edit', [DuyController::class, 'adminEdit'])->name('admin.assignments.edit');
    // Xử lý cập nhật phân công công việc
    Route::put('/assignments/{id}', [DuyController::class, 'adminUpdate'])->name('admin.assignments.update');
    Route::get('/assignments/{id}/detail', [DuyController::class, 'adminDetailLichKham'])->name('admin.assignments.detailLichKham');
});

Route::get('/admin/assignments/getAvailableVets', [DuyController::class, 'getAvailableVets'])->name('admin.assignments.getAvailableVets');
Route::get('/admin/assignments/check-available-doctors', [DuyController::class, 'checkAvailableDoctors']);
Route::get('/admin/assignments/search', [DuyController::class, 'adminSearchAssignments'])->name('admin.assignments.search');
Route::get('/check-available-time', [DuyController::class, 'checkAvailableTime'])->name('check.available.time');

Route::prefix('admin/doctors')
    ->name('admin.doctors.')
    ->middleware('auth.custom.role:manager')
    ->group(function () {
        // Hiển thị danh sách bác sĩ
        Route::get('/', [DuyController::class, 'showDoctors'])->name('index');
        // Thêm bác sĩ mới
        Route::get('/create', [DuyController::class, 'createDoctor'])->name('create');
        Route::post('/create', [DuyController::class, 'storeDoctor'])->name('store');
        // Chỉnh sửa thông tin bác sĩ
        Route::get('/edit/{maBacSi}', [DuyController::class, 'editDoctor'])->name('edit');
        Route::post('/edit/{maBacSi}', [DuyController::class, 'updateDoctor'])->name('update');
        // Xóa bác sĩ
        Route::delete('/delete/{maBacSi}', [DuyController::class, 'deleteDoctor'])->name('delete');
        // Tìm kiếm bác sĩ
        Route::get('/search', [DuyController::class, 'searchDoctor'])->name('search');
});

Route::prefix('admin/nhanvien')
    ->name('admin.nhanvien.')
    ->middleware('auth.custom.role:manager')
    ->group(function () {
        // Hiển thị danh sách nhân viên
        Route::get('/', [DuyController::class, 'NhanVienindex'])->name('index');
        // Thêm nhân viên mới
        Route::get('/create', [DuyController::class, 'NhanViencreate'])->name('create');
        Route::post('/create', [DuyController::class, 'NhanVienstore'])->name('store');
        // Chỉnh sửa thông tin nhân viên
        Route::get('/edit/{maNhanVien}', [DuyController::class, 'NhanVienedit'])->name('edit');
        Route::post('/edit/{maNhanVien}', [DuyController::class, 'NhanVienupdate'])->name('update');
        // Xóa nhân viên
        Route::delete('/delete/{maNhanVien}', [DuyController::class, 'NhanViendestroy'])->name('delete');
        // Tìm kiếm nhân viên
        Route::get('/search', [DuyController::class, 'NhanViensearch'])->name('search');
});

//Quản lý thú cưng
Route::middleware('auth.custom.role:manager,doctor,employee')->group(function () {
    Route::get('/pets', [DuyController::class, 'petList'])->name('pet.list');
    Route::get('/pets/create', [DuyController::class, 'createPetForm'])->name('pet.create');
    Route::get('/petsDetails/{id}', [DuyController::class, 'petDetails'])->name('pet.details');
    Route::post('/pets/save', [DuyController::class, 'savePet'])->name('pet.save');
    Route::get('/pets/search', [DuyController::class, 'searchPets'])->name('pet.search');
    Route::get('/giong-loai/create', [DuyController::class, 'createGiongLoaiForm'])->name('giong-loai.create');
    Route::post('/giong-loai/save', [DuyController::class, 'saveGiongLoai'])->name('giong-loai.save');
    Route::delete('/giong-loai/delete/{id}', [DuyController::class, 'deleteGiongLoai'])->name('giong-loai.delete');
    Route::get('/giong-loai/search', [DuyController::class, 'searchGiongLoai'])->name('giong-loai.search');
});

//Bác sĩ
Route::get('/doctor-schedule/{maBacSi}', [DuyController::class, 'showDoctorScheduleById'])
    ->middleware('auth.custom.role:doctor')
    ->name('doctor.schedule.byId');
Route::post('/assignments/confirm/{id}', [DuyController::class, 'confirmAssignment'])
    ->middleware('auth.custom.role:doctor')
    ->name('confirm.assignment');
Route::post('/assignments/reject/{id}', [DuyController::class, 'rejectAssignment'])
    ->middleware('auth.custom.role:doctor')
    ->name('reject.assignment');
Route::get('/pets/{id}', [DuyController::class, 'thongtinDieuTri'])->name('petData');

Route::post('/cap-nhat-ghi-chu/{id}', [DuyController::class, 'capNhatGhiChu'])->name('cap-nhat-ghi-chu');
Route::put('/doctorUpdate/{id}', [DuyController::class, 'doctorUpdate'])->name('doctor.update');

Route::get('/doctor/{id}/schedule/{type?}', [DuyController::class, 'showDoctorSchedule'])
    ->middleware('auth.custom.role:doctor')
    ->name('doctor.schedule');
Route::get('/doctor/{id}/dashboard', [DuyController::class, 'doctorDashboard'])
    ->middleware('auth.custom.role:doctor')
    ->name('doctor.dashboard');




//Nhân viên
Route::get('/customers/{id}', [DuyController::class, 'showCustomerDetails'])->middleware('auth.custom.role:employee,manager')->name('customers.details');
Route::post('/customers/{id}/update', [DuyController::class, 'updateCustomer'])->middleware('auth.custom.role:employee,manager')->name('customers.update');
Route::get('/customers', [DuyController::class, 'Customerindex'])->middleware('auth.custom.role:employee,manager')->name('customers.index');
Route::delete('/customers/{id}', [DuyController::class, 'Customerdelete'])->middleware('auth.custom.role:employee,manager')->name('customers.delete');

// Employee Dashboard Route
Route::middleware(['auth.custom.role:employee'])->group(function () {
    Route::get('/employee/{id}/dashboard', [DuyController::class, 'employeeDashboard'])
        ->name('employee.dashboard');
});
//Route::get('/employee/{id}/work-schedule', [DuyController::class, 'showWorkSchedule'])->name('work.schedule');
Route::get('/employee/{id}/work-schedule/{type?}', [DuyController::class, 'showWorkSchedule'])->name('work.schedule');



Route::get('/api/loai-vat-tu', [ProductServiceController::class, 'getLoaiVatTu']);
Route::get('/api/loai-dich-vu', [ProductServiceController::class, 'getLoaiDichVu']);
Route::get('/api/nha-cung-cap', [ProductServiceController::class, 'getNhaCungCap']);



// Trần Thành Luân
Route::get('/bookingService', [LuanController::class, 'createBookingService'])->name('bookingService.create');
Route::get('/showBookingService', [LuanController::class, 'showBookingService'])->name('bookingService.show');
Route::post('/bookingService', [LuanController::class, 'storeBookingService'])->name('bookingService.store');
Route::post('/save-selected-services', [LuanController::class, 'saveSelectedServices'])->name('saveSelectedServices');
Route::get('/get-selected-services', [LuanController::class, 'getSelectedServices'])->name('getSelectedServices');
Route::post('/appointment/store', [LuanController::class, 'storeAppointment'])->name('appointment.store');
Route::get('/product', [LuanController::class, 'showProductList'])->name('product');
Route::get('/detailproduct/{id}', [LuanController::class, 'showProductDetail'])->name('detailproduct');
Route::get('/detailservice/{id}', [LuanController::class, 'showServiceDetail'])->name('detailservice');
Route::get('/listproduct', [ListProductController::class, 'index'])->name('listproduct');
Route::get('/cart', [LuanController::class, 'showCart'])->name('cart');
Route::post('/add-to-cart', [LuanController::class, 'addToCart'])->name('addToCart');
Route::post('/checkout', [LuanController::class, 'checkout'])->name('checkout');
Route::delete('/cart/remove-item', [LuanController::class, 'removeItem'])->name('cart.removeItem');
Route::patch('/cart/update-quantity/{id}', [LuanController::class, 'updateQuantity'])->name('cart.updateQuantity');
Route::delete('/cart/clear', [LuanController::class, 'clearCart'])->name('cart.clear');
Route::post('/order', [LuanController::class, 'placeOrder'])->name('placeOrder');
Route::get('/payment', [LuanController::class, 'showPayment'])->name('payment');
Route::get('/userdashboard', [LuanController::class, 'showUserDashboard'])->name('userdashboard');
Route::get('/userdashboard/profile', [LuanController::class, 'showProfile'])->name('userdashboard.profile');
Route::post('/userdashboard/profile/update', [LuanController::class, 'updateProfile'])->name('userdashboard.profile.update');
Route::get('/userdashboard/pets', [LuanController::class, 'showPets'])->name('userdashboard.pets');
Route::get('/userdashboard/pet/{id}', [LuanController::class, 'showPetDetail'])->name('userdashboard.petDetail');
Route::put('/userdashboard/pet/{id}', [LuanController::class, 'updatePet'])->name('userdashboard.updatePet');
Route::get('/userdashboard/pets/add', [LuanController::class, 'addPet'])->name('userdashboard.addPet');
Route::post('/userdashboard/pets', [LuanController::class, 'storePet'])->name('userdashboard.storePet');
Route::get('/userdashboard/orders', [LuanController::class, 'showOrders'])->name('userdashboard.orders');
Route::get('/userdashboard/orders/{id}', [LuanController::class, 'showOrderDetail'])->name('userdashboard.orderDetail');
Route::get('/userdashboard/appointments', [LuanController::class, 'showAppointments'])->name('userdashboard.appointments');
Route::get('/userdashboard/appointments/{id}', [LuanController::class, 'showAppointmentDetail'])->name('userdashboard.appointmentDetail');
Route::delete('/userdashboard/pet/{id}', [LuanController::class, 'destroy'])->name('userdashboard.petDestroy');
Route::post('/place-service-booking', [LuanController::class, 'placeServiceBooking'])->name('placeServiceBooking');
Route::delete('/userdashboard/orders/delete/{id}', [LuanController::class, 'deleteOrder'])->name('userdashboard.orderDelete');
Route::get('/userdashboard/add-pet', [LuanController::class, 'showAddPetForm'])->name('userdashboard.addPet');
Route::post('/updateAppointment', [LuanController::class, 'updateAppointment'])->name('userdashboard.updateAppointment');
Route::post('/order/cancel/{id}', [LuanController::class, 'cancelOrder'])->name('order.cancel');
