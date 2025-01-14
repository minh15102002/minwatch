<?php
    require "inc/sidebar.php";
    require "inc/header.php";
    require "../class/Category.php";

    $conn =  new Database();
    $pdo = $conn->getConnect();
    
    if(empty($_GET['page']))
        $page = 1;
    else
        $page = $_GET['page'];
    $ppp = 4; // sản phẩm trên 1 trang

    $limit = $ppp;
    $offset = ($page-1)*$ppp; // tính lấy 4 sp tiếp theo
    $data = Category::pageination($pdo, $limit, $offset);

    $max = Category::countCategory($pdo);
    $maxPages = ceil($max / $ppp);
?>
    <div class="container-fluid">
        <!-- <h1 class="h3 mb-2 text-gray-800">Danh sách danh mục</h1> -->

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Danh sách danh mục</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                        <thead class="table-primary">
                            <tr>
                                <th>Id</th>
                                <th>Tên danh mục</th>
                                <th colspan="2" align="center">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data as $category): ?>
                                <tr>
                                    <td><?=$category->category_id?></td>
                                    <td><?=$category->category_name?></td>
                                    <td align="center"><a href="editCategory.php?category_id=<?=$category->category_id?>">Sửa</a></td>
                                    <td align="center"><a href="deleteCategory.php?category_id=<?=$category->category_id?>">Xóa</a></td>
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
                    <a class="page-link" href="<?= $page == 1 ? '#' : 'listCategory.php?page='.($page-1) ?>" aria-disabled="<?= $page == 1 ? 'true' : 'false' ?>">Previous</a>
                </li>

                <?php for ($i = 1; $i <= $maxPages; $i++): ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="listCategory.php?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <li class="page-item <?= $page == $maxPages ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= $page == $maxPages ? '#' : 'listCategory.php?page='.($page+1) ?>" aria-disabled="<?= $page == $maxPages ? 'true' : 'false' ?>">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<!-- Footer -->
<?php
    require "inc/footer.php";
?>