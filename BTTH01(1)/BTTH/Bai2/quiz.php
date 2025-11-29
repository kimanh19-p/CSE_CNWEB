<?php
if (!isset($_FILES['file'])) {
    die("Vui lòng upload file trước!");
}

$content = file_get_contents($_FILES['file']['tmp_name']);
$blocks = preg_split("/\n\s*\n/", trim($content));
$questions = [];

foreach ($blocks as $block) {
    $lines = explode("\n", trim($block));
    $question_text = array_shift($lines);  // câu hỏi
    $options = [];
    $correct = [];

    foreach ($lines as $line) {
        $line = trim($line);
        if (strpos($line, "ANSWER") === 0) {
            $correct = array_map('trim', explode(',', str_replace("ANSWER:", "", $line)));
        } else {
            // Lấy ký hiệu đáp án trước dấu chấm
            if (preg_match("/^([A-Z])\./", $line, $matches)) {
                $key = $matches[1]; // A, B, C,...
                $text = trim(substr($line, 2)); // bỏ "A. "
                $options[$key] = $text;
            }
        }
    }

    $questions[] = [
        "question" => $question_text,
        "options" => $options,
        "correct" => $correct
    ];
}
?>

<h2>Bài thi trắc nghiệm</h2>
<form action="result.php" method="POST">
<?php foreach ($questions as $i => $q): ?>
    <p><b>Câu <?= $i+1 ?>: <?= $q['question'] ?></b></p>
    <?php foreach ($q['options'] as $key => $text): ?>
        <label>
            <input type="checkbox" name="q<?= $i ?>[]" value="<?= $key ?>">
            <?= $key ?>. <?= $text ?>
        </label><br>
    <?php endforeach; ?>
    <input type="hidden" name="correct<?= $i ?>" value="<?= implode(',', $q['correct']) ?>">
    <hr>
<?php endforeach; ?>

<button type="submit">Nộp bài</button>
</form>
