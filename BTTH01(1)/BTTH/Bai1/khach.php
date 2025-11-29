<?php
// index.php
require_once 'flowers.php';
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Danh sách hoa - User</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body{font-family: Arial, sans-serif; max-width:1000px;margin:20px auto;padding:0 10px;}
    .grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:20px;}
    .card{border:1px solid #ddd;padding:12px;border-radius:8px;box-shadow:0 1px 3px rgba(0,0,0,.05);}
    .card img{width:100%;height:180px;object-fit:cover;border-radius:6px;}
    .card h3{margin:10px 0 6px;}
    .card p{margin:0;color:#555;}
    header{display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;}
    a.button{background:#2b7cff;color:#fff;padding:8px 12px;border-radius:6px;text-decoration:none;}
  </style>
</head>
<body>
<header>
  <h1>14 Loại hoa</h1>
  <div><a class="button" href="admin.php">Vào trang Admin</a></div>
</header>

<div class="grid">
  <?php foreach ($flowers as $f): ?>
  <article class="card">
    <img src="<?= htmlspecialchars($f['img']) ?>" alt="<?= htmlspecialchars($f['name']) ?>">
    <h3><?= htmlspecialchars($f['name']) ?></h3>
    <p><?= htmlspecialchars($f['desc']) ?></p>
  </article>
  <?php endforeach; ?>
</div>

</body>
</html>
