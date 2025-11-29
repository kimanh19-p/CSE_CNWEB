<?php
if (isset($_FILES['csv'])) {
    $file = $_FILES['csv']['tmp_name'];

    // Đọc toàn bộ file CSV
    $rows = array_map("str_getcsv", file($file));

    if (count($rows) > 0) {
        // Lấy dòng đầu làm header
        $header = array_shift($rows);

        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        // Hiển thị header
        echo "<tr style='background-color:#f2f2f2;'>";
        foreach ($header as $h) {
            echo "<th>" . htmlspecialchars($h) . "</th>";
        }
        echo "</tr>";

        // Hiển thị dữ liệu
        foreach ($rows as $row) {
            echo "<tr>";
            foreach ($row as $cell) {
                echo "<td>" . htmlspecialchars($cell) . "</td>";
            }
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "File CSV trống!";
    }
} else {
?>
    <!-- Form upload CSV -->
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="csv" accept=".csv">
        <button type="submit">Upload CSV</button>
    </form>
<?php
}
?>
