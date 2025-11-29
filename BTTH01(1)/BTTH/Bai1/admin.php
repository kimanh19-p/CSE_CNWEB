<?php
session_start();
require_once 'flowers.php';

// Khởi tạo dữ liệu vào session (nếu chưa có)
if (!isset($_SESSION['flowers'])) {
    $_SESSION['flowers'] = $flowers;
}

// helper: tìm index theo id
function findIndexById($arr, $id) {
    foreach ($arr as $i => $item) {
        if ($item['id'] == $id) return $i;
    }
    return false;
}

// Xử lý actions: add, edit, delete
$action = $_GET['action'] ?? null;

// XỬ LÝ THÊM
if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $desc = $_POST['desc'] ?? '';
    $img = $_POST['img'] ?? ''; // fallback nếu không upload

    // xử lý upload nếu có
    if (!empty($_FILES['imgfile']['name'])) {
        $targetDir = 'images/';
        $filename = preg_replace('/[^A-Za-z0-9\-\_\.]/', '-', basename($_FILES['imgfile']['name']));
        $targetPath = $targetDir . $filename;
        if (move_uploaded_file($_FILES['imgfile']['tmp_name'], $targetPath)) {
            $img = $targetPath;
        }
    }

    // lấy id mới = max id + 1
    $ids = array_column($_SESSION['flowers'], 'id');
    $newId = $ids ? max($ids) + 1 : 1;
    $_SESSION['flowers'][] = ['id'=>$newId,'name'=>$name,'desc'=>$desc,'img'=>$img];
    header('Location: admin.php');
    exit;
}

// XỬ LÝ SỬA
if ($action === 'edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $name = $_POST['name'] ?? '';
    $desc = $_POST['desc'] ?? '';
    $img = $_POST['img'] ?? '';

    // xử lý upload thay ảnh
    if (!empty($_FILES['imgfile']['name'])) {
        $targetDir = 'images/';
        $filename = preg_replace('/[^A-Za-z0-9\-\_\.]/', '-', basename($_FILES['imgfile']['name']));
        $targetPath = $targetDir . $filename;
        if (move_uploaded_file($_FILES['imgfile']['tmp_name'], $targetPath)) {
            $img = $targetPath;
        }
    }

    $idx = findIndexById($_SESSION['flowers'], $id);
    if ($idx !== false) {
        $_SESSION['flowers'][$idx]['name'] = $name;
        $_SESSION['flowers'][$idx]['desc'] = $desc;
        if ($img) $_SESSION['flowers'][$idx]['img'] = $img;
    }
    header('Location: admin.php');
    exit;
}

// XỬ LÝ XÓA
if ($action === 'delete') {
    $id = intval($_GET['id'] ?? 0);
    $idx = findIndexById($_SESSION['flowers'], $id);
    if ($idx !== false) {
        array_splice($_SESSION['flowers'], $idx, 1);
    }
    header('Location: admin.php');
    exit;
}

// Lấy dữ liệu hiển thị
$list = $_SESSION['flowers'];
// Nếu edit form
$editItem = null;
if (isset($_GET['action']) && $_GET['action'] === 'showedit' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $idx = findIndexById($list, $id);
    if ($idx !== false) $editItem = $list[$idx];
}
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Admin - Quản lý hoa</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body{font-family:Arial, sans-serif;max-width:1000px;margin:20px auto;padding:0 10px;}
    table{
          width:100%;
          border-collapse:collapse;
          margin-bottom:20px;}
    th,td{
          border:1px solid #ddd;
          padding:8px;text-align:left;
          }
    img.thumb{
          width:80px;
          height:60px;
          object-fit:cover;
          border-radius:4px;
          }
    form.inline{
          display:flex;
          gap:8px;
          flex-wrap:wrap;
          align-items:center;}
    .actions a{
          margin-right:8px;
    }
    .button{
          background:#2b7cff;
          color:#fff;padding:6px 10px;
          border-radius:6px;
          text-decoration:none;}
    .button1{
          background: #2b7c2b;ff;
          color:#fff;padding:6px 10px;
          border-radius:6px;
          text-decoration:none;}
       .button2{
          background: #d13b12ff;ff;
          color:#fff;padding:6px 10px;
          border-radius:6px;
          text-decoration:none;}
    .danger{background:#e74c3c;}
  </style>
</head>
<body>
<h1>Admin - Quản lý danh sách hoa</h1>
<p><a class="button" href="index.php">Xem trang User</a></p>

<h2>Danh sách (<?= count($list)+1 ?>)</h2>
<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Tên</th>
      <th>Mô tả</th>
      <th>Ảnh</th>
      <th>Hành động</th>
    </tr>
  </thead>
  <tbody>
 <?php foreach ($flowers as $key => $flower): ?>
        <tr>
            <td><?php echo $key + 1; ?></td>
            <td><?php echo $flower['name']; ?></td>
            <td><?php echo $flower['desc']; ?></td>
            <td><img src="<?php echo $flower['img']; ?>" width="80"></td>
            <td>
                <button class="button1" type="submit">Sửa</button>
                 <button class="button2" type="submit">Xóa</button>
                  
                 
            </td>
        </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<hr>

<h2>Thêm hoa mới</h2>
<form action="admin.php?action=add" method="post" enctype="multipart/form-data" class="inline">
  <input name="name" placeholder="Tên hoa" required>
  <input name="desc" placeholder="Mô tả" style="width:40%;">
  <input type="text" name="img" placeholder="Đường dẫn ảnh (ví dụ images/ten.jpg)">
  <input type="file" name="imgfile" accept="image/*">
  <button class="button" type="submit">Thêm</button>
</form>

<?php if ($editItem): ?>
<hr>
<h2>Chỉnh sửa: ID <?= $editItem['id'] ?></h2>
<form action="admin.php?action=edit" method="post" enctype="multipart/form-data" class="inline">
  <input type="hidden" name="id" value="<?= $editItem['id'] ?>">
  <input name="name" value="<?= htmlspecialchars($editItem['name']) ?>" required>
  <input name="desc" value="<?= htmlspecialchars($editItem['desc']) ?>" style="width:40%;">
  <input type="text" name="img" value="<?= htmlspecialchars($editItem['img']) ?>">
  <input type="file" name="imgfile" accept="image/*">
  <button class="button" type="submit">Lưu</button>
  <a href="admin.php">Hủy</a>
</form>
<?php endif; ?>

</body>
</html>
