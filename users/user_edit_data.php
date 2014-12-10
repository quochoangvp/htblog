<?php
include '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $value   = mysqli_real_escape_string($con,strip_tags($_POST['value']));
    $name    = mysqli_real_escape_string($con,strip_tags($_POST['name']));
    $user_id = mysqli_real_escape_string($con,strip_tags($_POST['pk']));
    if ($name == 'email' && strlen($value) != 0) {
        if (update_data('users', "email = '{$value}'", "user_id = {$user_id}")) {
            $response = array('status' => 'success', 'msg' => 'Cập nhật thành công!');
            echo json_encode($response);
        } else {
            $response = array('status' => 'error', 'msg' => 'Cập nhật thất bại!');
            echo json_encode($response);
        }
    } elseif ($name == 'password' && strlen($value) != 0) {
        @session_start();
        $_SESSION['pass'] = $value;
    } elseif ($name = 'repassword' & strlen($size) != 0 && ) {
        @session_start();
        if (isset($_POST['pass'])) {
            $key=array_search($value,$_SESSION['pass']);
            if($key!==false) unset($_SESSION['pass'][$key]);
        } 
    }
}