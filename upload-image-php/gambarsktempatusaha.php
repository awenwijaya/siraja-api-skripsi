<?php
    require_once 'koneksi.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $image = $_FILES['image']['name'];
        $upload_path = 'images/'.$image; 
        $nama_tempat_usaha = $_POST['nama_tempat_usaha'];
        $tmp_name = $_FILES['image']['tmp_name'];
        try {
            move_uploaded_file($tmp_name, $upload_path);
            $sql = "UPDATE tb_tempat_usaha SET foto = '$file_path' WHERE nama_usaha = '$nama_tempat_usaha';";
            if(mysqli_query($koneksi, $sql)) {
                $response['error'] = false;
            }
        }
        catch(Exception $e) {
            $response['error']=true;
            $response['message']=$e->getMessage();
        }
        echo json_encode($response);
    }
?>