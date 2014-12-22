<?php
include '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $value   = mysqli_real_escape_string($con,trim($_POST['value']));
    $name    = mysqli_real_escape_string($con,trim($_POST['name']));
    $user_id = mysqli_real_escape_string($con,trim($_POST['pk']));
    @session_start();
    if (strlen($value) != 0) {
        switch ($name) {
            case 'email':
                $value = strip_tags($value);
                if (validate_email($value)) {
                    if (update_data('users', "email = '{$value}'", "user_id = {$user_id}")) {
                        $response = array('status' => 'success', 'msg' => 'Cập nhật thành công!');
                        echo json_encode($response);
                    } else {
                        $response = array('status' => 'error', 'msg' => 'Cập nhật thất bại!');
                        echo json_encode($response);
                    }
                } else {
                    $response = array('status' => 'error', 'msg' => 'Vui lòng nhập email đúng!');
                    echo json_encode($response);
                }
                break;
            
            case 'password':
                if (validate_password($value)) {
                    $_SESSION['pass'] = $value;
                } else {
                    $response = array('status' => 'error', 'msg' => 'Mật khẩu chỉ gồm chữ cái, chữ số và các ký tự: ! @ # $ % ^ & * . - +');
                    echo json_encode($response);
                }
                break;
            
            case 'repassword':
                if ($value == $_SESSION['pass']) {
                    unset($_SESSION['pass']);
                    if (update_data('users', "password = '".SHA1($value)."'", "user_id = {$user_id}")) {
                        $response = array('status' => 'success', 'msg' => 'Cập nhật mật khẩu thành công!');
                        echo json_encode($response);
                    } else {
                        $response = array('status' => 'error', 'msg' => 'Cập nhật mật khẩu thất bại!');
                        echo json_encode($response);
                    }
                } else {
                    $response = array('status' => 'error', 'msg' => 'Mật khẩu không trùng nhau!');
                    echo json_encode($response);
                }
                break;
            
            case 'fullname':
                $value = strip_tags($value);
                if (update_data('users', "fullname = '{$value}'", "user_id = {$user_id}")) {
                    $response = array('status' => 'success', 'msg' => 'Cập nhật họ tên thành công!');
                    echo json_encode($response);
                } else {
                    $response = array('status' => 'error', 'msg' => 'Cập nhật họ tên thất bại!');
                    echo json_encode($response);
                }
                break;
            
            case 'address':
                $value = strip_tags($value);
                if (update_data('users', "address = '{$value}'", "user_id = {$user_id}")) {
                    $response = array('status' => 'success', 'msg' => 'Cập nhật địa chỉ thành công!');
                    echo json_encode($response);
                } else {
                    $response = array('status' => 'error', 'msg' => 'Cập nhật địa chỉ thất bại!');
                    echo json_encode($response);
                }
                break;
            
            case 'about':
                $value = strip_tags($value);
                if (update_data('users', "about = '{$value}'", "user_id = {$user_id}")) {
                    $response = array('status' => 'success', 'msg' => 'Cập nhật ghi chú thành công!');
                    echo json_encode($response);
                } else {
                    $response = array('status' => 'error', 'msg' => 'Cập nhật ghi chú thất bại!');
                    echo json_encode($response);
                }
                break;

            default:
                $response = array('status' => 'error', 'msg' => 'Đã xảy ra lỗi!');
                echo json_encode($response);
                break;
        }
    } else {
        $response = array('status' => 'error', 'msg' => 'Vui lòng không để trống mục này!');
        echo json_encode($response);
    }
}