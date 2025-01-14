<?php
    require_once "inc/sidebar.php";
    require_once "inc/header.php";
    require_once "../class/Auth.php";

    $conn =  new Database();
    $pdo = $conn->getConnect();

    if(empty($_GET['page']))
        $page = 1;
    else
        $page = $_GET['page'];
    $ppp = 5; // sản phẩm trên 1 trang

    $limit = $ppp;
    $offset = ($page-1)*$ppp; // tính lấy 4 sp tiếp theo
    $data_user = Auth::getAllUser($pdo, $limit, $offset);

    $max = Auth::countAllUser($pdo);
    $maxPages = ceil($max / $ppp);

?>
    <div class="container-fluid">
        <!-- <h1 class="h3 mb-2 text-gray-800">Danh sách đơn hàng</h1> -->

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Danh sách người dùng</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                        <thead class="table-secondary">
                            <tr>
                                <th>Mã User</th>
                                <th>Email</th>
                                <th>Tên User</th>
                                <th>Số điện thoại </th>
                                <th>role</th>
                                <th colspan="3">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data_user as $user): ?>
                                <tr>
                                    <td><?=$user->id?></td>
                                    <td><?=$user->email?></td>
                                    <td><?=$user->name?></td>
                                    <td><?=$user->phone?></td>
                                    <td><?=$user->role?></td>
                                    <td align="center">
                                        <a href="deleteUser.php?id=<?=$user->id?>">Xóa</a>
                                    </td>
                                    <td align="center">
                                        <a href="editUser.php?id=<?=$user->id?>">Sửa</a>
                                    </td>
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
                    <a class="page-link" href="<?= $page == 1 ? '#' : 'listUser.php?page='.($page-1) ?>" aria-disabled="<?= $page == 1 ? 'true' : 'false' ?>">Previous</a>
                </li>

                <?php for ($i = 1; $i <= $maxPages; $i++): ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="listUser.php?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <li class="page-item <?= $page == $maxPages ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= $page == $maxPages ? '#' : 'listUser.php?page='.($page+1) ?>" aria-disabled="<?= $page == $maxPages ? 'true' : 'false' ?>">Next</a>
                </li>
            </ul>
        </nav>

    </div>

</div>

<!-- Footer -->
<?php
    require "inc/footer.php";
?>
