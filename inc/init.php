<?php
    // kiểm tra xem session đã được bắt đầu chưa
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    // if(isset($_SESSION['data'])){
    //     $conn =  new Database();
    //     $pdo = $conn->getConnect();
    //     // var_dump($pdo);
    //     $_SESSION['data'] = Product::getAll($pdo);
    // }

    // if(!isset($_SESSION['cart']))
    // {
    //     // $_SESSION['cart'] = [];
    //     $cart = new Cart();
    //     $_SESSION['cart'] = $cart->getItems();
    // }


