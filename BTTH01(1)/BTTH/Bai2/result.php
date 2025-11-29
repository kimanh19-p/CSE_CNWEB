<?php
$score = 0;
$total = 0;

foreach ($_POST as $key => $value) {
    if (strpos($key, "correct") === 0) {
        $total++;
    }
}

foreach ($_POST as $key => $value) {
    if (strpos($key, "correct") !== false) continue;

    $index = str_replace("q", "", $key);

    $user_answer = $_POST["q$index"];
    if (!is_array($user_answer)) $user_answer = [];

    $correct = $_POST["correct$index"];
    $correct_answers = array_map('trim', explode(',', $correct));

    sort($user_answer);
    sort($correct_answers);

    if ($user_answer == $correct_answers) $score++;
}

$point = ($score / $total) * 10;

echo "<h2>Số câu làm đúng : $score / $total</h2>";
echo "<h2>Điểm bài làm : " . round($point, 2) . " / 10</h2>";
?>
