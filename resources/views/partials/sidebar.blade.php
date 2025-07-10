<div class="sidebar" data-background-color="dark">
  <div class="sidebar-logo">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="dark">
      <a href="" class="logo">
        <img src="{{ asset('Image/th.jpg' ) }}" alt="navbar brand" class="navbar-brand" height="80" />
      </a>
      <div class="nav-toggle">
        <button class="btn btn-toggle toggle-sidebar">
          <i class="gg-menu-right"></i>
        </button>
        <button class="btn btn-toggle sidenav-toggler">
          <i class="gg-menu-left"></i>
        </button>
      </div>
      <button class="topbar-toggler more">
        <i class="gg-more-vertical-alt"></i>
      </button>
    </div>
    <!-- End Logo Header -->
  </div>
  <div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
      <ul class="nav nav-secondary">
        <!-- Dashboard -->

        @if(session('role') == 'manager')
        <li class="nav-item active">
          <a href="{{ route('quanly') }}" class="collapsed">
              <i class="fas fa-home"></i>
              <p>Dashboard</p>
              <span class="caret"></span>
          </a>
      </li>

    @endif
        <!-- Nhân viên -->
        @if(session('role') == 'employee')
        <li class="nav-section">
          <h4 class="text-section">Nhân viên</h4>
        </li>
        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#employee">
            <i class="fas fa-user-tie"></i>
            <p>Nhân viên</p>
            <span class="caret"></span>
          </a>
          <div class="" id="employee">
            <ul class="nav nav-collapse">
              <li class="staff-layout">
                <a href="{{route('employee.dashboard',['id'=>session('manage_id')])}}">
                  <span class="sub-item">Xem lịch làm việc</span>
                </a>
              </li>

              <li class="staff-layout">
                <a href="{{route(('customers.index'))}}">
                  <span class="sub-item">Quản lý Thông tin khách hàng</span>
                </a>
              </li>
              <li class="staff-layout">
                <a href="{{route('invoice.index')}}">
                  <span class="sub-item">Quản lý Hóa đơn</span>
                </a>
              </li>
              <li class="staff-layout">
                <a href="{{route('promotions.index')}}">
                  <span class="sub-item">Quản lý Khuyến mãi</span>
                </a>
              </li>
              <li class="staff-layout">
                <a href="{{route('products_services.index')}}">
                  <span class="sub-item">Quản lý Vật tư và Dịch vụ</span>
                </a>
              </li>
              <li class="doctor-layout">
                <a href="{{route('issues.index')}}">
                  <span class="sub-item">Xem các vấn đề của khách hàng</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        @endif

        @if(session('role') == 'doctor')
        <!-- Bác sĩ -->
        <li class="nav-section">
          <h4 class="text-section">Bác sĩ</h4>
        </li>
        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#doctor">
            <i class="fas fa-user-md"></i>
            <p>Bác sĩ</p>
            <span class="caret"></span>
          </a>

          <div class="" id="doctor">
            <ul class="nav nav-collapse">

            <li class="doctor-layout">
                <a href="{{ route('doctor.dashboard',['id'=>session('manage_id')])}}">
                  <span class="sub-item">Xem lịch làm việc</span>
                </a>
              </li>

              <li class="doctor-layout">
                <a href="{{ route('doctor.schedule.byId', ['maBacSi' => session('manage_id')]) }}">
                  <span class="sub-item">Quản lý Lịch làm việc</span>
                </a>
              </li>



              <li class="doctor-layout">
                <a href="{{route('pet.list')}}">
                  <span class="sub-item">Xem Hồ sơ thú cưng</span>
                </a>
              </li>


            </ul>
          </div>
        </li>
        @endif

        <!-- Admin -->
        @if(session('role') == 'manager')
        <li class="nav-section">
            <h4 class="text-section">Admin</h4>
        </li>
        <li class="nav-item">
            <a data-bs-toggle="collapse" href="#admin">
                <i class="fas fa-cogs"></i>
                <p>Quản trị viên</p>
                <span class="caret"></span>
            </a>
            <div class="" id="admin">
                <ul class="nav nav-collapse">
                    <li class="admin-layout">
                        <a href="{{route('admin.assignments.index')}}">
                            <span class="sub-item">Phân công công việc</span>
                        </a>
                    </li>
                    <li class="admin-layout">
                        <a href="{{route('staff.index')}}">
                            <span class="sub-item">Quản lý Thông tin nhân viên</span>
                        </a>
                    </li>
                    <li class="admin-layout">
                        <a href="{{route('promotions.index')}}">
                            <span class="sub-item">Quản lý Khuyến mãi</span>
                        </a>
                    </li>
                    <li class="admin-layout">
                    <a href="{{route('products_services.index')}}">
                    <span class="sub-item">Quản lý Vật tư/Dịch vụ</span>
                    </a>
                        </li>
                        <li class="admin-layout">
                            <a href="{{route('suppliers.index')}}">
                            <span class="sub-item">Quản lý Nhà cung cấp</span>
                            </a>
                        </li>
                        <li class="admin-layout">
                            <a href="{{route('StockEntry.index')}}">
                            <span class="sub-item">Quản lý Nhập kho</span>
                            </a>
                        </li>
                        <li class="admin-layout">
                            <a href="{{route('invoice.index')}}">
                                <span class="sub-item">Quản lý Hóa đơn</span>
                            </a>
                        </li>
                        <li class="admin-layout">
                            <a href="{{route('pet.list')}}">
                                <span class="sub-item">Quản lý thông tin thú cưng</span>
                            </a>
                        </li>

                        <li class="admin-layout">
                            <a href="{{route('issues.index')}}">
                                <span class="sub-item">Quản lý các vấn đề khách hàng</span>
                            </a>
                        </li>
                </ul>
            </div>
        </li>
        @endif

        <!-- Nút Đăng Xuất -->
        <li class="nav-item">
          <a href="{{ route('logout') }}" class="nav-link">
            <i class="fas fa-sign-out-alt"></i>
            <p>Đăng Xuất</p>
          </a>
        </li>

      </ul>
    </div>
  </div>
</div>
