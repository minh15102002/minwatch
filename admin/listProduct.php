<?php
    require_once "inc/sidebar.php";
    require_once "inc/header.php";
    
    // require "inc/init.php";
    // require "class/Cart.php";
    // require "class/CartItem.php";
    $conn =  new Database();
    $pdo = $conn->getConnect();
    // $data_product = Product::getAll($pdo);

    if(empty($_GET['page']))
        $page = 1;
    else
        $page = $_GET['page'];
    $ppp = 10; // sản phẩm trên 1 trang

    $limit = $ppp;
    $offset = ($page-1)*$ppp; // tính lấy 4 sp tiếp theo
    $data_product = Product::getAllProduct($pdo, $limit, $offset);

    $max = Product::countAllProduct($pdo);
    $maxPages = ceil($max / $ppp);
?>
    <div class="container-fluid">
        <!-- <h1 class="h3 mb-2 text-gray-800">Danh sách sản phẩm</h1> -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Danh sách sản phẩm</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                        <thead class="table-info">
                            <tr>
                                <th>Id</th>
                                <th>Tên sản phẩm</th>
                                <th>Hình ảnh</th>
                                <th>Giá</th>
                                <th>Thương hiệu</th>
                                <th>Danh mục</th>
                                <th colspan="3" align="center">Tác vụ</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php foreach($data_product as $product): ?>
                                <tr>
                                    <td><?=$product->product_id?></td>
                                    <td><a href="detailProduct.php?product_id=<?=$product->product_id?>"><?=$product->product_name?></a></td>
                                    <td><img src="../assets/images/img_pro/<?=$product->product_image?>" width="100"></td>
                                    <td><?= number_format($product->product_price, 0, ',', '.')?> VNĐ</td>
                                    <td><?= $product->brand_name?></td>
                                    <td><?= $product->category_name?></td>
                                    <td align="center"><a href="detailProduct.php?product_id=<?=$product->product_id?>">Xem chi tiết</a></td>
                                    <td align="center"><a href="editProduct.php?product_id=<?=$product->product_id?>">Sửa</a></td>
                                    <td align="center"><a href="deleteProduct.php?product_id=<?=$product->product_id?>">Xóa</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= $page == 1 ? '#' : 'listProduct.php?page='.($page-1) ?>" aria-disabled="<?= $page == 1 ? 'true' : 'false' ?>">Previous</a>
                </li>

                <?php for ($i = 1; $i <= $maxPages; $i++): ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="listProduct.php?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <li class="page-item <?= $page == $maxPages ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= $page == $maxPages ? '#' : 'listProduct.php?page='.($page+1) ?>" aria-disabled="<?= $page == $maxPages ? 'true' : 'false' ?>">Next</a>
                </li>
            </ul>
        </nav>

    </div>

</div>

<!-- Footer -->
<?php
    require "inc/footer.php";
?>
