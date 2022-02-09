<?php
    require_once 'koneksi.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $image = $_FILES['image']['name'];
        $upload_path = 'profilepic/'.$image; 
        $user_id = $_POST['user_id'];
        $tmp_name = $_FILES['image']['tmp_name'];
        try {
            move_uploaded_file($tmp_name, $upload_path);
            $sql = "UPDATE tb_sso SET profile_picture = '$upload_path' WHERE user_id = '$user_id';";
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