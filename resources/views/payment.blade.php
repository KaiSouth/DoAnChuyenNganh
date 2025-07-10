<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <title>PET SHOP - Thanh toán</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Roboto:wght@700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar Start -->
    @include('partials._navbar', ['user_id' => session('user_id')])
    <!-- Navbar End -->


    <!-- Payment Start -->
    <div class="container-fluid pt-5">
        <div class="container">
            <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px;">
                <h6 class="text-primary text-uppercase">Thanh toán</h6>
                <h1 class="display-5 text-uppercase mb-0">Chọn phương thức thanh toán</h1>
            </div>
            <div class="row g-5">
                <div class="col-lg-7">
                    <form action="{{ route('placeOrder') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <h4 class="mb-3">Thông tin giao hàng</h4>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Họ và tên" value="{{ $customer->HoTen ?? '' }}" required>
                                <label for="name">Họ và tên</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Email" value="{{ $customer->Email ?? '' }}" required>
                                <label for="email">Email</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="tel" class="form-control" id="phone" name="phone"
                                    placeholder="Số điện thoại" value="{{ $customer->SDT ?? '' }}" required>
                                <label for="phone">Số điện thoại</label>
                            </div>
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Địa chỉ" id="address" name="address" style="height: 100px" required>{{ $customer->DiaChi ?? '' }}</textarea>
                                <label for="address">Địa chỉ</label>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h4 class="mb-3">Phương thức thanh toán</h4>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="cod"
                                    value="COD" checked>
                                <label class="form-check-label" for="cod">
                                    Thanh toán khi nhận hàng (COD)
                                </label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="paymentMethod"
                                    id="onlinePayment" value="Banking">
                                <label class="form-check-label" for="onlinePayment">
                                    Thanh toán online
                                </label>
                            </div>
                        </div>
                        <button id="confirmButton" class="btn btn-primary w-100 py-3" type="submit">Xác nhận đặt hàng</button>
                    </form>
                </div>
                <div class="col-lg-5">
                    <div class="bg-light p-4 mb-4">
                        <h4 class="text-uppercase mb-4">Tóm tắt đơn hàng</h4>
                        <!-- Tóm tắt tổng hợp đơn hàng -->
                        <div class="d-flex justify-content-between mb-3">
                            <h6 class="text-uppercase">Tổng tiền hàng</h6>
                            <h6>{{ number_format($totalProductAmount, 0, ',', '.') }} VNĐ</h6>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <h6 class="text-uppercase">Tổng tiền dịch vụ</h6>
                            <h6>{{ number_format($totalServiceAmount, 0, ',', '.') }} VNĐ</h6>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <h6 class="text-uppercase">Tổng tiền khám</h6>
                            <h6>{{ number_format($totalAppointmentAmount, 0, ',', '.') }} VNĐ</h6>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <h6 class="text-uppercase">Phí vận chuyển</h6>
                            <h6>{{ number_format($shippingFee, 0, ',', '.') }} VNĐ</h6>
                        </div>
                        <hr class="mt-0">
                        <div class="d-flex justify-content-between mb-3">
                            <h5 class="text-uppercase">Tổng cộng</h5>
                            <h5>{{ number_format($totalWithShipping, 0, ',', '.') }} VNĐ</h5>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Payment End -->


    <!-- Footer Start -->
    @include('partials.footer')
    <!-- Footer End -->

    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Thanh toán</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Nội dung modal -->
                <img id="qrCodeImage" alt="QR Code" class="img-fluid">
                <p>Số tiền: <span id="modalAmount"></span> VNĐ</p>
            </div>
        </div>
    </div>
</div>


    <!-- Modal thanh toán -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary py-3 fs-4 back-to-top"><i class="bi bi-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

    <script>

 document.addEventListener('DOMContentLoaded', function() {
    const onlinePayment = document.getElementById('onlinePayment');
    const paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
    const confirmButton = document.getElementById('confirmButton');
    const COD =document.getElementById('cod');
    let checkTransactionInterval;
    let currentTransactionId;

    onlinePayment.addEventListener('change', function() {
        if (this.checked) {
            confirmButton.disabled = true;
            const totalAmount = {{ $totalWithShipping }};
            currentTransactionId = Math.random().toString(36).substr(2, 9);
            const description = `Thanh toan petshop ${currentTransactionId}`;

            const qrUrl = `https://img.vietqr.io/image/970422-9331012003-print.png?amount=${totalAmount}&addInfo=${description}&accountName=PET SHOP`;

            document.getElementById('qrCodeImage').src = qrUrl;
            document.getElementById('modalAmount').textContent = new Intl.NumberFormat('vi-VN').format(totalAmount);
            paymentModal.show();

            startTransactionCheck(description, totalAmount, currentTransactionId);
        }
    });

    async function submitOrder() {
        try {
            const formData = new FormData();
            formData.append('name', document.getElementById('name').value);
            formData.append('email', document.getElementById('email').value);
            formData.append('phone', document.getElementById('phone').value);
            formData.append('address', document.getElementById('address').value);
            formData.append('transaction_id', currentTransactionId);
            formData.append('_token', '{{ csrf_token() }}');

            const response = await fetch('{{ route("placeOrderOnline") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'  // Thêm header này
                },
                body: formData
            });

            if (!response.ok) {
                const errorText = await response.text();
                console.error('Server response:', errorText);
                throw new Error('Server response was not ok');
            }

            const result = await response.json();
            if (result.success) {
                alert('Đặt hàng thành công!');
                window.location.href = '{{route('cart')}}';
            } else {
                throw new Error(result.message || 'Có lỗi xảy ra');
            }
        } catch (error) {
            console.error('Lỗi:', error);
            alert('Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại!');
        }
    }

    function startTransactionCheck(description, amount, transactionId) {
        let checkCount = 0;
        const maxChecks = 90;

        checkTransactionInterval = setInterval(async () => {
            checkCount++;
            try {
                const response = await fetch("https://script.google.com/macros/s/AKfycbw-317FryQM0bDq6hyZ_GbB4VC8dR2EosDvnV1HRy4Y8bvyvDXuJ48xzo4dx4aJ3OVj/exec");
                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();
                const transaction = data.data.find(trans =>
                    trans["Mô tả"].includes(transactionId) &&
                    trans["Giá trị"] >= amount
                );

                if (transaction) {
                    clearInterval(checkTransactionInterval);
                    paymentModal.hide();
                    await submitOrder();
                }
            } catch (error) {
                console.error("Lỗi kiểm tra giao dịch:", error);
            }

            if (checkCount >= maxChecks) {
                clearInterval(checkTransactionInterval);
                alert('Hết thời gian chờ thanh toán!');
                paymentModal.hide();
            }
        }, 5000);
    }

    // Cleanup khi modal đóng
    document.getElementById('paymentModal').addEventListener('hidden.bs.modal', function () {
        if (checkTransactionInterval) {
            clearInterval(checkTransactionInterval);
        }
    });
    COD.addEventListener('change',function(){
        if(this.checked){
            confirmButton.disabled = false;
        }
    })
});



// Dropdown menu script (giữ nguyên)
document.querySelector('.nav-item.dropdown').addEventListener('mouseover', function() {
    this.querySelector('.dropdown-menu-custom').style.display = 'block';
});
document.querySelector('.nav-item.dropdown').addEventListener('mouseout', function() {
    this.querySelector('.dropdown-menu-custom').style.display = 'none';
});

    </script>
</body>

</html>
