@extends('userdashboard')

@section('content')
    <style>
        .appointment-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .appointment-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
        }

        .appointment-item:hover {
            transform: scale(1.02);
        }

        .appointment-info {
            flex-grow: 1;
        }

        .appointment-info .appointment-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .appointment-info .appointment-detail {
            font-size: 14px;
            margin-bottom: 5px;
        }

        .appointment-actions {
            display: flex;
            gap: 10px;
        }

        .appointment-actions .btn {
            min-width: 120px;
            padding: 6px 12px;
        }

        .modal-header {
            border-bottom: 1px solid #ddd;
        }

        .modal-body {
            padding: 20px;
        }
    </style>

    <div class="container mt-4">
        <h3 class="mb-3">Danh sách lịch khám</h3>

        <!-- Hiển thị thông báo -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="appointment-list">
            @foreach ($appointments as $appointment)
                <div class="appointment-item">
                    <div class="appointment-info">
                        <div class="appointment-title">
                            Mã Hóa Đơn: {{ $appointment->MaHoaDon ?? 'Chưa có hóa đơn' }}
                        </div>
                        <div class="appointment-detail">
                            <strong>Trạng Thái Hóa Đơn:</strong> {{ $appointment->TrangThai ?? 'Chưa có hóa đơn' }}
                        </div>
                        <div class="appointment-detail">
                            <strong>Thú Cưng:</strong> {{ $appointment->TenThuCung }}
                        </div>
                        <div class="appointment-detail">
                            <strong>Ngày Khám:</strong> {{ $appointment->NgayKham }}
                        </div>
                        <div class="appointment-detail">
                            <strong>Giờ Khám:</strong> {{ $appointment->GioKham }}
                        </div>
                    </div>

                    <div class="appointment-actions">
                        <a href="{{ route('userdashboard.appointmentDetail', ['id' => $appointment->MaLichKham]) }}" class="btn btn-primary btn-sm">Xem Chi Tiết</a>

                        @if($appointment->TrangThai == 'Chờ xác nhận')
                            <button class="btn btn-warning btn-sm update-btn"
                                    data-id="{{ $appointment->MaLichKham }}"
                                    data-ma-thu-cung="{{ $appointment->MaThuCung }}"
                                    data-ten="{{ $appointment->TenThuCung }}"
                                    data-ngay="{{ $appointment->NgayKham }}"
                                    data-gio="{{ $appointment->GioKham }}"
                                    data-toggle="modal"
                                    data-target="#updateAppointmentModal">
                                Cập nhật lịch khám
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal for updating appointment -->
    <div class="modal fade" id="updateAppointmentModal" tabindex="-1" role="dialog" aria-labelledby="updateAppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateAppointmentModalLabel">Cập nhật lịch khám</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ route('userdashboard.updateAppointment') }}" method="POST">
                        @csrf
                        <input type="hidden" name="appointment_id" id="appointment_id">
                        <div class="form-group">
                            <label for="MaThuCung">Chọn Thú Cưng:</label>
                            <select name="MaThuCung" id="MaThuCung" class="form-control">
                                @foreach ($pets as $pet)
                                    <option value="{{ $pet->MaThuCung }}">{{ $pet->TenThuCung }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="NgayKham">Ngày Khám:</label>
                            <input type="date" name="NgayKham" id="NgayKham" class="form-control"
                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="GioKham">Giờ Khám:</label>
                            <input type="time" name="GioKham" id="GioKham" class="form-control">
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Quay lại</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for handling modal data -->
    <script>
        document.querySelectorAll('.update-btn').forEach(button => {
            button.addEventListener('click', function() {
                const appointmentId = this.getAttribute('data-id');
                const petName = this.getAttribute('data-ten');
                const appointmentDate = this.getAttribute('data-ngay');
                const appointmentTime = this.getAttribute('data-gio');
                const petId = this.getAttribute('data-ma-thu-cung');
                document.getElementById('appointment_id').value = appointmentId;
                document.getElementById('MaThuCung').value = petId;
                document.getElementById('NgayKham').value = appointmentDate;
                document.getElementById('GioKham').value = appointmentTime;
            });
        });
    </script>
@endsection
