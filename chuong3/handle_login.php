<?php
// TODO 1: Khởi động session
session_start();

// TODO 2: Kiểm tra xem form đã được gửi chưa
if (isset($_POST['username']) && isset($_POST['password'])) {

    // TODO 3: Lấy dữ liệu từ form
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // TODO 4: Kiểm tra đăng nhập
    if ($user == 'admin' && $pass == '123') {

        // TODO 5: Lưu username vào SESSION
        $_SESSION['logged_user'] = $user;

        // TODO 6: Chuyển hướng sang trang welcome
        header('Location: welcome.php');
        exit;

    } else {
        // Sai tài khoản → quay lại login.html
        header('Location: login.html?error=1');
        exit;
    }

} else {
    // TODO 7: Truy cập trực tiếp file → đá về login.html
    header('Location: login.html');
    exit;
}
?>
