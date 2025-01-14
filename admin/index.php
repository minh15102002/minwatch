<?php
require "inc/init.php";
require "inc/sidebar.php";
require "inc/header.php";
require_once "../class/Database.php";
require_once "../class/Order.php";
require_once "../class/Product.php";
require_once "../class/Auth.php";

$conn = new Database();
$pdo = $conn->getConnect();

$total_revenue = Order::totalRevenue($pdo);
$total_product = Product::totalProduct($pdo);
$total_order = Order::totalOrder($pdo);
$total_user = Auth::totalUser($pdo);

$dailyRevenue = Order::getDailyRevenue($pdo);

$order_dates = [];
$revenues = [];
foreach ($dailyRevenue as $row) {
    $order_dates[] = $row['order_date'];
    $revenues[] = $row['daily_revenue'];
}
?>

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1"> Tong doanh thu</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($total_revenue, 0, ',', '.') ?> VNĐ</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Đơn hàng</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_order ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Sản phẩm</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_product ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Người dùng</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_user ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Doanh thu theo ngày</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="dailyRevenueChart" style="width: 100%; height: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Biểu đồ doanh thu theo danh mục sản phẩm -->
    <div style="margin-top: 30px;">
        
        <div id="bar"></div>
        <!-- <div id="line"></div> -->
        <div id="donut"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <style>
        #bar, #line, #donut {
            margin-top: 20px;
        }
    </style>

    <script>
        // Biểu đồ Doanh thu theo ngày
        // const ctx = document.getElementById('dailyRevenueChart').getContext('2d');
        // const dailyRevenueChart = new Chart(ctx, {
        //     type: 'line',
        //     data: {
        //         labels: <?= json_encode($order_dates) ?>,
        //         datasets: [{
        //             label: 'Doanh thu hàng ngày',
        //             data: <?= json_encode($revenues) ?>,
        //             borderColor: 'rgba(75, 192, 192, 1)',
        //             backgroundColor: 'rgba(75, 192, 192, 0.2)',
        //             borderWidth: 1
        //         }]
        //     },
        //     options: {
        //         scales: {
        //             y: {
        //                 beginAtZero: true
        //             }
        //         }
        //     }
        // });

        // Biểu đồ Bar
        var optionsBar = {
            series: [{
                name: 'Đã thanh toán',
                data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
            }, {
                name: 'Đã hủy',
                data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
            }],
            chart: {
                type: 'bar',
                height: 350
            },
            xaxis: {
                categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct']
            }
        };

        var chartBar = new ApexCharts(document.querySelector('#bar'), optionsBar);
        chartBar.render();


        // Biểu đồ Donut
        var optionDonut = {
            chart: {
                type: 'donut',
                width: '100%',
                height: 400
            },
            series: [21, 23, 19, 14, 6],
            labels: ['Đồng hồ nam', 'Đồng hồ nữ', 'Đồng hồ đôi', 'Phụ kiện', 'Khác']
        };

        var donut = new ApexCharts(document.querySelector("#donut"), optionDonut);
        donut.render();
    </script>
</div>

<?php
require "inc/footer.php";
?>

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>