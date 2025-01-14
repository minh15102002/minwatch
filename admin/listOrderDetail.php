<?php
    require_once "inc/sidebar.php";
    require_once "inc/header.php";
    require_once "../class/Order.php";
    require_once "../class/OrderDetail.php";

    $conn =  new Database();
    $pdo = $conn->getConnect();

    if(empty($_GET['page']))
        $page = 1;
    else
        $page = $_GET['page'];
    $ppp = 5; // sản phẩm trên 1 trang

    $limit = $ppp;
    $offset = ($page-1)*$ppp; // tính lấy 4 sp tiếp theo
    $data_order = Order::getAll($pdo, $limit, $offset);

    $max = Order::countAllOrder($pdo);
    $maxPages = ceil($max / $ppp);

    $order_id = $_GET["order_id"];

    // data của 1 đơn hàng
    $data_order = OrderDetail::getOrder($pdo, $order_id);
    // data của chi tiết đơn hàng
    $data = OrderDetail::getOrderDetail($pdo, $order_id);
    // data thông tin của tk đặt đơn hàng đó
    $data_user = OrderDetail::getInfoCustomer($pdo, $order_id);

    $a = "Đang chờ xác nhận";
    $b = "Đã xác nhận";

    $status="";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $status = $_POST['status']=='confirmed'?1:0;
        Order::updateStatus($pdo, $order_id, $status);
    }
?>
    <div class="container-fluid">
        <!-- <h1 class="h3 mb-2 text-gray-800">Chi tiết đơn hàng</h1> -->
        <div class="text-end my-2">
            <a href="listOrder.php" class="btn btn-success btn-icon-split" style="width: 200px;">
                <span class="text">Danh sách đơn hàng</span>
            </a>   
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Chi tiết đơn hàng</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <span class="fs-6"><b>Mã đơn hàng:</b> <?=$order_id?></span>
                            <span class="fs-6 mx-5"><b>Ngày lập: </b><?=$data_order->order_date?></span>
                        </div>
                        <form method="post">
                        <div class="d-flex justify-content-end align-items-center">
                            <span class="fs-6 mx-5"><b>Trạng thái: </b></span>
                                <select name="status" class="form-select" aria-label="Default select example" style="width: 200px;">
                                <?php if($data_order->status): ?>
    <option selected value="confirmed"><?=$b?></option>
    <option value="confirm"><?=$a?></option>
<?php else: ?>
    <option value="confirmed"><?=$b?></option>
    <option selected value="confirm"><?=$a?></option>
<?php endif; ?>
                                </select>
                                <button type="submit" class="btn btn-success btn-icon-split ms-3">
                                    <span class="text">Cập nhật trạng thái</span>
                                </button>
                            </div>
                        </form>
                    </div>
                    <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Mã sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Giá trị sản phẩm</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data as $order): ?>
                                <tr>
                                    <td><?=$order->product_id?></td>
                                    <td><?=$order->product_name?></td>
                                    <td><?=$order->quantity?></td>
                                    <td><?= number_format($order->price, 0, ',', '.')?> VNĐ</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div>
                        <span class="fs-6 float-end"><b>Tồng tiền:</b> <?=number_format($data_order->total_price, 0, ',', '.')?> VNĐ</span>
                    </div>
                </div>
            </div>

        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Thông tin đơn hàng</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="d-flex justify-content-between mb-3">
                            <div class="col-md-6">
                                <h6 class="my-2 font-weight-bold text-primary">Thông tin người đặt</h6>
                                <div>
                                    <span class="fs-6"><b>Mã khách hàng:  </b><?=$data_user->id?> </span>
                                    <span class="fs-6 float-end"><b>Tên khách hàng:  </b><?=$data_user->name?></span>
                                </div>
                                <div>
                                    <span class="fs-6"><b>Email:  </b><?=$data_user->email?></span>
                                    <span class="fs-6 float-end"><b>Số điện thoại:  </b><?=$data_user->phone?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="my-2 font-weight-bold text-primary">Thông tin người nhận</h6>
                                <div>
                                    <span class="fs-6"><b>Tên người nhận:  </b><?=$data_order->recipient_name?></span>
                                    <span class="fs-6 float-end"><b>Số điện thoại:  </b><?=$data_order->recipient_phone?></span>
                                </div>
                                <div class="fs-6"><b>Địa chỉ:  </b><?=$data_order->recipient_address?></div>
                                <?php if(!empty($data_order->note)):?>
                                    <div class="fs-6"><b>note:  </b><?=$data_order->note?></div>
                                <?php endif;?>
                                <div class="fs-6"><b>Phương thức thanh toán:  </b><?=$data_order->payment_method?></div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= $page == 1 ? '#' : 'listOrder.php?&page='.($page-1) ?>" aria-disabled="<?= $page == 1 ? 'true' : 'false' ?>">Previous</a>
                </li>

                <?php for ($i = 1; $i <= $maxPages; $i++): ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="listOrder.php?&page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <li class="page-item <?= $page == $maxPages ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= $page == $maxPages ? '#' : 'listOrder.php?&page='.($page+1) ?>" aria-disabled="<?= $page == $maxPages ? 'true' : 'false' ?>">Next</a>
                </li>
            </ul>
        </nav>

    </div>

</div>

<!-- Footer -->
<?php
    require "inc/footer.php";
?> 