<?php
    include 'config.php';
    $koneksi = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die(mysqli_errno());
?>