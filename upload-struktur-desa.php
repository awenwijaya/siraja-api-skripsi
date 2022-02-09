<?php
    require_once 'koneksi.php';
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $image = $_FILES['image']['name'];
        $upload_path = 'struktur/'.$image;
        $desa_id = $_POST['desa_id'];
        $tmp_name = $_FILES['image']['tmp_name'];
        try{
            move_uploaded_file($tmp_name, $upload_path);
            $sql = "UPDATE tb_desa SET file_struktur_pem = '$upload_path' WHERE desa_id = '$desa_id';";
            if(mysqli_query($koneksi, $sql)) {
                $response['error'] = false;
            }
        }
        catch(Exception $e) {
            $response['error'] = true;
            $response['message'] = $e->getMessage();
        }
        echo json_encode($response);
    }
?>