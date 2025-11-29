<?php
// Nếu người dùng bấm nút Submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Lấy dữ liệu từ form
    $ten_de_tai    = $_POST['ten_de_tai'] ?? "";
    $ten_sinh_vien = $_POST['ten_sinh_vien'] ?? "";
    $mssv          = $_POST['mssv'] ?? "";
    $giang_vien_hd = $_POST['giang_vien_hd'] ?? "";
    $nam_hoc       = $_POST['nam_hoc'] ?? "";
    $trang_thai    = $_POST['trang_thai'] ?? "";

    // Giả lập tạo thành công → Chuyển về dashboard
    header("Location: index.php?success=created");
    exit;
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm đồ án mới</title>
    <link rel="stylesheet" href="style.css">
        <style>
        /* ====== Layout chung ====== */
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 750px;
            margin: 0 auto;
            background: white;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        /* ====== Form ====== */
        form.form-add {
            margin-top: 15px;
        }

        .form-row {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
        }

        .form-row label {
            width: 170px;
            font-weight: bold;
            font-size: 14px;
        }

        .form-row input,
        .form-row select {
            flex: 1;
            padding: 8px 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            transition: 0.2s;
        }

        .form-row input:focus,
        .form-row select:focus {
            border-color: #007bff;
            box-shadow: 0 0 4px rgba(0,123,255,0.4);
            outline: none;
        }

        /* Nút tạo mới */
        .btn-primary {
            background: #007bff;
            color: white;
            padding: 10px 18px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 15px;
            transition: 0.2s;
        }

        .btn-primary:hover {
            background: #0056b3;
        }

        /* Navbar */
        .navbar {
            background: #222;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
        }

        .navbar a {
            color: #fff;
            margin-left: 12px;
            text-decoration: none;
        }

        .navbar a:hover {
            text-decoration: underline;
        }
    </style>

</head>



<body>

<div class="navbar">
    <div>Quản lý Đồ án Tốt nghiệp</div>
    <div>
        <a href="index.php">Dashboard</a>
        <a href="create.php" class="btn btn-primary">+ Thêm đồ án</a>
    </div>
</div>

<div class="container">
    <h1>Thêm đồ án mới</h1>

   <form method="POST" action="" class="form-add">

    <div class="form-row">
        <label>Tên đề tài:</label>
        <input type="text" name="ten_de_tai" required>
    </div>

    <div class="form-row">
        <label>Tên sinh viên:</label>
        <input type="text" name="ten_sinh_vien" required>
    </div>

    <div class="form-row">
        <label>MSSV:</label>
        <input type="text" name="mssv" required>
    </div>

    <div class="form-row">
        <label>Giảng viên hướng dẫn:</label>
        <input type="text" name="giang_vien_hd" required>
    </div>

    <div class="form-row">
        <label>Năm học:</label>
        <input type="text" name="nam_hoc" placeholder="2024-2025" required>
    </div>

    <div class="form-row">
        <label>Trạng thái:</label>
        <select name="trang_thai" required>
            <option value="Đang thực hiện">Đang thực hiện</option>
            <option value="Hoàn thành">Hoàn thành</option>
            <option value="Chờ duyệt">Chờ duyệt</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Tạo mới</button>
</form>


</div>

</body>
</html>
