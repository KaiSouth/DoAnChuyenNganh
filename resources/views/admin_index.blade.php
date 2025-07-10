<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Kaiadmin - Bootstrap 5 Admin Dashboard</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link
      rel="icon"
      href="{{ asset('admin/assets/img/kaiadmin/favicon.ico') }}"
      type="image/x-icon"
    />

    <!-- Fonts and icons -->
    <script src="{{asset('admin/assets/js/plugin/webfont/webfont.min.js')}}"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["{{asset('admin/assets/css/fonts.min.css')}}"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{asset('admin/assets/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/css/plugins.min.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/css/kaiadmin.min.css')}}" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{asset('admin/assets/css/demo.css')}}  )" />
  </head>
  <body>
    <div class="wrapper">
       @include('partials.sidebar')


      <div class="main-panel">
   

        <div class="container">
          <div class="page-inner">
            <div
              class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
            >
              <div>
                <h3 class="fw-bold mb-3">Dashboard</h3>

              </div>

            </div>

            <!-- start -->
            <div class="row">
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div
                          class="icon-big text-center icon-primary bubble-shadow-small"
                        >
                          <i class="fas fa-users"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Số Lượng User</p>
                          <h4 class="card-title">{{ $khachHangCount }}</h4>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div
                          class="icon-big text-center icon-info bubble-shadow-small"
                        >
                          <i class="fas fa-user-check"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Số Lượng Pet</p>
                          <h4 class="card-title">{{ $thuCungCount }}</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div
                          class="icon-big text-center icon-success bubble-shadow-small"
                        >
                          <i class="fas fa-luggage-cart"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Số Lượng Vật Tư</p>
                          <h4 class="card-title">{{ $vatTuCount }}</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-warning bubble-shadow-small">
                                    <i class="fas fa-concierge-bell"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Số Lượng Dịch vụ</p>
                                    <h4 class="card-title">{{ $dichVuCount }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div
                          class="icon-big text-center icon-secondary bubble-shadow-small"
                        >
                          <i class="far fa-check-circle"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Số Lượng Hóa Đơn</p>
                          <h4 class="card-title">{{ $hoaDonCount }}</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-8">
                <div class="card card-round">
                  <div class="card-header">
                    <div class="card-head-row">
                      <div class="card-title">User Statistics</div>
                      <div class="card-tools">
                        <a href="#" class="btn btn-label-success btn-round btn-sm me-2">
                          <span class="btn-label">
                            <i class="fa fa-pencil"></i>
                          </span>
                          Export
                        </a>
                        <a href="#" class="btn btn-label-info btn-round btn-sm">
                          <span class="btn-label">
                            <i class="fa fa-print"></i>
                          </span>
                          Print
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="chart-container" style="min-height: 375px">
                      <canvas id="statisticsCharts"></canvas>
                    </div>
                    <div id="myChartLegend"></div>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                  <div class="card card-primary card-round">
                      <div class="card-header">
                          <div class="card-head-row">
                              <div class="card-title">Current Quarter Stats</div>

                          </div>
                          <div class="card-category">Statistics for Quarter {{ $currentQuarter }}</div>
                      </div>
                      <div class="card-body pb-0">
                          <div class="mb-4 mt-2">
                              <h2 >Total Sales in Q{{ $currentQuarter }}:  {{ number_format($quarterlySalesData['totalSales'], 2) }} VND</h2>
                          </div>

                      </div>
                  </div>

                  <div class="card card-round">
                      <div class="card-body pb-0">
                          <div class="h1 fw-bold float-end text-primary">+++</div>
                          <h2 class="mb-2">New User: {{ $quarterlySalesData['newSubscribers'] }}</h2>
                          <p class="text-muted">Users add more</p>
                      </div>
                  </div>
              </div>


            </div>

            <div class="row">
              <div class="col-md-4">
                  <div class="card card-round">
                      <div class="card-body">
                          <div class="card-head-row card-tools-still-right">
                              <div class="card-title">New Customers</div>
                          </div>
                          <div class="card-list py-4">
                              @foreach($newCustomers as $customer)
                                  <div class="item-list">
                                      <div class="avatar">
                                          <img src="{{ asset('admin/assets/img/sauro.jpg') }}" alt="Avatar" class="avatar-img rounded-circle">
                                      </div>
                                      <div class="info-user ms-3">
                                          <div class="username">{{ $customer->HoTen }}</div>
                                          <div class="status">{{ $customer->Email }}</div> <!-- Hoặc bất kỳ trường nào bạn muốn hiển thị -->
                                      </div>

                                      <button class="btn btn-icon btn-link btn-danger op-8">
                                          <i class="fas fa-ban"></i>
                                      </button>
                                  </div>
                              @endforeach
                          </div>
                      </div>
                  </div>
              </div>

              <div class="col-md-8">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row card-tools-still-right">
                            <div class="card-title">Transaction History</div>

                        </div>
                    </div>

                    <!-- Dropdown for filtering -->
                    <div class="d-flex justify-content-end p-3">
                        <select class="form-select w-auto" id="transactionFilter" onchange="filterTransactions(this.value)">
                            <option value="all">All</option>
                            <option value="Cod">COD</option>
                            <option value="Banking">Banking</option>
                           
                        </select>
                    </div>

                    <!-- Table -->
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0" id="transactionTable">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">Payment Number</th>
                                    <th scope="col" class="text-end">Date & Time</th>
                                    <th scope="col" class="text-end">Amount</th>
                                    <th scope="col" class="text-end">Status</th>
                                    <th scope="col" class="text-end">Transaction Type</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transactions as $transaction)
                                    <tr class="transaction-row"
                                        data-status="{{ $transaction->TrangThai }}"
                                        data-type="{{ $transaction->LoaiGiaoDich }}">
                                        <th scope="row">
                                            <button class="btn btn-icon btn-round btn-success btn-sm me-2">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            Payment from #{{ $transaction->MaHoaDon }}
                                        </th>
                                        <td class="text-end">{{ \Carbon\Carbon::parse($transaction->NgayXuatHoaDon)->format('M d, Y') }}</td>
                                        <td class="text-end">{{ number_format($transaction->TongTien, 0, ',', '.') }} VND</td>
                                        <td class="text-end">
                                            <span class="badge badge-{{ $transaction->TrangThai == 'Completed' ? 'success' : ($transaction->TrangThai == 'Pending' ? 'warning' : 'danger') }}">
                                                {{ $transaction->TrangThai }}
                                            </span>
                                        </td>
                                        <td class="text-end">{{ $transaction->LoaiGiaoDich }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
          </div>
           <!-- End -->


        </div>

        
      </div>

      <!-- Custom template | don't include it in your project! -->

      <!-- End Custom template -->
    </div>
    <!--   Core JS Files   -->
    <script src="{{asset('admin/assets/js/core/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/core/popper.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/core/bootstrap.min.js')}}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{asset('admin/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>

    <!-- Chart JS -->
    <script src="{{asset('admin/assets/js/plugin/chart.js/chart.min.js')}}"></script>

    <!-- jQuery Sparkline -->
    <script src="{{asset('admin/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js')}}"></script>

    <!-- Chart Circle -->
    <script src="{{asset('admin/assets/js/plugin/chart-circle/circles.min.js')}}"></script>

    <!-- Datatables -->
    <script src="{{asset('admin/assets/js/plugin/datatables/datatables.min.js')}}"></script>

    <!-- jQuery Vector Maps -->
    <script src="{{asset('admin/assets/js/plugin/jsvectormap/jsvectormap.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/plugin/jsvectormap/world.js')}}"></script>

    <!-- Sweet Alert -->
    <script src="{{asset('admin/assets/js/plugin/sweetalert/sweetalert.min.js')}}"></script>

    <!-- Kaiadmin JS -->
    <script src="{{asset('admin/assets/js/kaiadmin.min.js')}}"></script>

    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="{{asset('admin/assets/js/setting-demo.js')}}"></script>
    <script src="{{asset('admin/assets/js/demo.js')}}"></script>
    <script>
        function filterTransactions(filter) {
            const rows = document.querySelectorAll('.transaction-row');
            rows.forEach(row => {
                const status = row.getAttribute('data-status');
                const type = row.getAttribute('data-type');

                // Show all rows if "all" filter is selected
                if (filter === 'all') {
                    row.style.display = '';
                } else if (status === filter || type === filter) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
    <script>
        var userStatisticsData = @json($userStatisticsData);
        // Statistics Chart (Area Chart)
        var ctx = document.getElementById("statisticsCharts").getContext("2d");
        var statisticsChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [
                    {
                        label: "Số Lượng Hóa Đơn",
                        data: userStatisticsData.activeUsers,
                        backgroundColor: "rgba(29, 122, 243, 0.2)",
                        borderColor: "#1d7af3",
                        fill: true
                    },
                    {
                        label: "Số Lượng Thú Cưng mới",
                        data: userStatisticsData.newVisitors,
                        backgroundColor: "rgba(253, 175, 75, 0.2)",
                        borderColor: "#fdaf4b",
                        fill: true
                    },
                    {
                        label: "Số Lượng Khách Hàng mới",
                        data: userStatisticsData.subscribers,
                        backgroundColor: "rgba(243, 84, 93, 0.2)",
                        borderColor: "#f3545d",
                        fill: true
                    }
                ]
            }
        });
    </script>

  </body>
</html>