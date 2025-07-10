<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>PET SHOP - Đặt Lịch Khám</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Chăm sóc thú cưng chất lượng cao" name="keywords">
    <meta content="Cửa hàng cung cấp dịch vụ và sản phẩm chăm sóc thú cưng hàng đầu" name="description">

    <link href="{{asset('img/favicon.ico')}}" rel="icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Roboto:wght@700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{asset('js/flaticon/font/flaticon.css')}}" rel="stylesheet">

    <link href="{{asset('js/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">

    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">

    <link href="{{asset('css/style.css')}}" rel="stylesheet">

    <style>
        .appointment-form {
            background-color: #f8f9fa;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: 50px auto;
        }

        .appointment-form h2 {
            margin-bottom: 30px;
            color: #51D5CB;
            text-align: center;
        }

        .appointment-form .form-group {
            margin-bottom: 20px;
        }

        .appointment-form label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .appointment-form input,
        .appointment-form select {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            font-size: 16px;
        }

        .appointment-form button {
            width: 100%;
            padding: 12px;
            background-color: #7AB730;
            border: none;
            color: #fff;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
        }

        .appointment-form button:hover {
            background-color: #6aa029;
        }

        .alert {
            max-width: 600px;
            margin: 20px auto;
            padding: 15px;
            border-radius: 5px;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }

        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }

        .alert ul {
            margin: 0;
            padding-left: 20px;
        }

        #timeValidationMessage {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            min-width: 300px;
            text-align: center;
        }

        /* Thêm style để ẩn các lỗi validation mặc định */
        .alert-danger ul {
            display: none;
        }

        .alert {
            animation: fadeIn 0.5s;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    @include('partials._navbar', ['user_id' => session('user_id')])
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="appointment-form">
        <h2>Đặt Lịch Khám Cho Thú Cưng</h2>
        <div id="serverValidationErrors">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>

        <div id="timeValidationMessage" class="alert" style="display: none;"></div>

        <form action="{{ route('appointment.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="NgayKham">Ngày Khám:</label>
                <input type="date" id="NgayKham" name="NgayKham"
                       value="{{ old('NgayKham') }}"
                       min="{{ date('Y-m-d') }}"
                       required>
            </div>

            <div class="form-group">
                <label for="GioKham">Giờ Khám:</label>
                <input type="time" id="GioKham" name="GioKham" value="{{ old('GioKham') }}" step="1800" required>                <small class="text-muted">Thời gian khám từ 8:00 - 17:00, mỗi lượt cách nhau 30 phút</small>
                <div id="gioKhamErrorMessage" class="text-danger" style="display: none;"></div>
            </div>

            <div class="form-group">
                <label for="DiaChi">Địa Chỉ:</label>
                <select id="DiaChi" name="DiaChi" required>
                    <option value="" disabled {{ old('DiaChi') ? '' : 'selected' }}>Chọn địa chỉ</option>
                    <option value="144 Lê Trọng Tấn Tây Thạnh Tân Phú" {{ old('DiaChi') == '' ? 'selected' : '' }}>144 Lê Trọng Tấn Tây Thạnh Tân Phú</option>
                </select>
            </div>

            <div class="form-group">
                <label for="ChuanDoan">Tình Trạng:</label>
                <input type="text" id="ChuanDoan" name="ChuanDoan" value="{{ old('ChuanDoan') }}" required>
            </div>

            <div class="form-group">
                <label for="ChiPhiKham">Chi Phí Khám (VND):</label>
                <select id="ChiPhiKham" name="ChiPhiKham" required>
                    <option value="">-- Chọn Chi Phí --</option>
                    <option value="200000" {{ old('ChiPhiKham') == '200000' ? 'selected' : '' }}>200,000 VNĐ</option>
                    <option value="500000" {{ old('ChiPhiKham') == '500000' ? 'selected' : '' }}>500,000 VNĐ</option>
                    <option value="700000" {{ old('ChiPhiKham') == '700000' ? 'selected' : '' }}>700,000 VNĐ</option>
                </select>
            </div>

            <div class="form-group">
                <label for="MaBacSi">Bác Sĩ:</label>
                <select id="MaBacSi" name="MaBacSi" required>
                    <option value="">-- Chọn Bác Sĩ --</option>
                    @foreach ($bacSi as $bs)
                    <option value="{{ $bs->MaBacSi }}" {{ old('MaBacSi') == $bs->MaBacSi ? 'selected' : '' }}>
                        {{ $bs->HoTen }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="MaThuCung">Thú Cưng:</label>
                <select id="MaThuCung" name="MaThuCung" required>
                    <option value="">-- Chọn Thú Cưng --</option>
                    @foreach ($thuCung as $tc)
                    <option value="{{ $tc->MaThuCung }}" {{ old('MaThuCung') == $tc->MaThuCung ? 'selected' : '' }}>
                        {{ $tc->TenThuCung }}
                    </option>
                    @endforeach
                </select>
            </div>

            <button type="submit">Đặt Lịch Khám</button>
        </form>
    </div>

    @include('partials.footer')
    <a href="#" class="btn btn-primary py-3 fs-4 back-to-top"><i class="bi bi-arrow-up"></i></a>


    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('js/easing/easing.min.js')}}"></script>
    <script src="{{asset('js/waypoints/waypoints.min.js')}}"></script>
    <script src="{{asset('js/owlcarousel/owl.carousel.min.js')}}"></script>


    <script src="{{asset('js/main.js')}}"></script>
    <script>
        $(document).ready(function() {
            // Ẩn tất cả thông báo lỗi ban đầu
            $('.alert').hide();

            // 1. Validate thời gian khám
            function validateAppointmentTime() {
                var gioKham = $('#GioKham').val();
                if (!gioKham) {
                    showMessage('<i class="fas fa-exclamation-triangle"></i> Vui lòng chọn giờ khám', 'danger');
                    return false;
                }

                var hour = parseInt(gioKham.split(':')[0]);
                var minute = parseInt(gioKham.split(':')[1]);

                // Kiểm tra giờ làm việc (8:00-17:00)
                if (hour < 8 || hour >= 17) {
                    showMessage('<i class="fas fa-exclamation-triangle"></i> Thời gian khám phải từ 8:00 đến 17:00', 'danger');
                    $('#GioKham').val('');
                    return false;
                }

                // Kiểm tra giờ nghỉ trưa
                if (hour === 12) {
                    showMessage('<i class="fas fa-exclamation-triangle"></i> Không thể đặt lịch trong giờ nghỉ trưa (12:00 - 13:00)', 'danger');
                    $('#GioKham').val('');
                    return false;
                }

                // Kiểm tra khoảng thời gian 30 phút
                if (minute % 30 !== 0) {
                    showMessage('<i class="fas fa-exclamation-triangle"></i> Thời gian khám phải đặt theo khung giờ 30 phút (VD: 8:00, 8:30, 9:00...)', 'danger');
                    $('#GioKham').val('');
                    return false;
                }

                return true;
            }

            // 2. Hiển thị message
            function showMessage(message, type) {
                $('#timeValidationMessage')
                    .removeClass('alert-success alert-danger')
                    .addClass('alert-' + type)
                    .html(message)
                    .show();

                // Ẩn thông báo sau 5 giây
                setTimeout(function() {
                    $('#timeValidationMessage').fadeOut('slow');
                }, 5000);
            }

            // 3. Kiểm tra lịch bác sĩ
            function checkDoctorAvailability() {
                var ngayKham = $('#NgayKham').val();
                var gioKham = $('#GioKham').val();
                var maBacSi = $('#MaBacSi').val();

                if (ngayKham && gioKham && maBacSi) {
                    $.ajax({
                        url: "{{ route('check.available.time') }}",
                        type: 'GET',
                        data: {
                            NgayKham: ngayKham,
                            GioKham: gioKham,
                            MaBacSi: maBacSi
                        },
                        success: function(response) {
                            if (!response.available) {
                                showMessage(response.message, 'danger');
                                $('#GioKham').val(''); // Xóa giờ khám nếu không khả dụng
                            } else {
                                // Xóa thông báo lỗi nếu có
                                $('#timeValidationMessage').hide();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                            showMessage('<i class="fas fa-exclamation-triangle"></i> Có lỗi xảy ra khi kiểm tra thời gian', 'danger');
                        }
                    });
                }
            }

            // 4. Event Listeners

            // Khi thay đổi giờ khám
            $('#GioKham').change(function() {
                if (validateAppointmentTime()) {
                    checkDoctorAvailability();
                }
            });

            // Khi thay đổi ngày khám hoặc bác sĩ
            $('#NgayKham, #MaBacSi').change(checkDoctorAvailability);
        });
    </script>
</body>
</html>
