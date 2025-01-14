<?php
    // kiểm tra xem session đã được bắt đầu chưa
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }


