
<?php
    require_once "../class/Database.php";
    require_once "../class/Product.php";
    require_once "inc/init.php";
    ob_start(); // bắt đầu bộ đệm đầu ra, ngăn bất kỳ đầu ra nào được gửi từ trước.

    require "../class/Auth.php";

    $auth = new Auth();
    $auth->restrictAccessAdmin();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Min Admin - Dashboard</title>
    <link rel="shortcut icon" href="../assets/images/logo.png" type="image/x-icon">
    <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-secondary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
    <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Min Admin <sup>2</sup></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="index.php">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>


<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Tiện ích
</div>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
        aria-expanded="true" aria-controls="collapsePages">
        <i class="fas fa-fw fa-folder"></i>
        <span>Sản phẩm</span>
    </a>
    <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <div class="collapse-divider"></div>
            <a class="collapse-item" href="listProduct.php">Danh sách sản phẩm</a>
            <a class="collapse-item" href="addProduct.php">Thêm sản phẩm</a>
        </div>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCategory"
        aria-expanded="true" aria-controls="collapseCategory">
        <i class="fas fa-fw fa-folder"></i>
        <span>Danh mục sản phẩm</span>
    </a>
    <div id="collapseCategory" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <div class="collapse-divider"></div>
            <a class="collapse-item" href="listCategory.php">Danh sách danh mục</a>
            <a class="collapse-item" href="addCategory.php">Thêm danh mục</a>
        </div>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBrand"
        aria-expanded="true" aria-controls="collapseBrand">
        <i class="fas fa-fw fa-folder"></i>
        <span>Thương hiệu</span>
    </a>
    <div id="collapseBrand" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <div class="collapse-divider"></div>
            <a class="collapse-item" href="listBrand.php">Danh sách thương hiệu</a>
            <a class="collapse-item" href="addBrand.php">Thêm thương hiệu</a>
        </div>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOrder"
        aria-expanded="true" aria-controls="collapseOrder">
        <i class="fas fa-fw fa-folder"></i>
        <span>Đơn hàng</span>
    </a>
    <div id="collapseOrder" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <div class="collapse-divider"></div>
            <a class="collapse-item" href="listOrder.php">Danh sách đơn hàng</a>
        </div>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUser"
        aria-expanded="true" aria-controls="collapseUser">
        <i class="fas fa-fw fa-folder"></i>
        <span>Quản lý User</span>
    </a>
    <div id="collapseUser" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <div class="collapse-divider"></div>
            <a class="collapse-item" href="listUser.php">Danh sách User</a>
            <a class="collapse-item" href="addUser.php">Thêm User</a>
        </div>
    </div>
</li>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>