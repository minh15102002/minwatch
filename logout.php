<?php
    session_start();
    unset($_SESSION['logged_user']);
    unset($_SESSION['user_id']);
    unset($_SESSION['role']);

    header("location:index.php");
    exit;