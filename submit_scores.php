<?php
session_start();
require_once "settings.php";

$conn = @mysqli_connect($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if archer_id and round_id are being posted
if (!isset($_POST['archer_id']) || !isset($_POST['round_id'])) {
    die("Archer ID or Round ID not posted.");
}

$archer_id = $_POST['archer_id'];
$round_id = $_POST['round_id'];
$ends = $_POST['ends'];
$totalScoreAll = 0;

for($i = 1; $i <= $ends; $i++) {
    $totalScore = 0;
    for($j = 1; $j <= 6; $j++) {
        $arrow = $_POST['end' . $i . 'arrow' . $j];
        $arrow_score = ($arrow == 'X') ? 10 : (($arrow == 'M') ? 0 : $arrow);
        $totalScore += $arrow_score;
    }
    $totalScoreAll += $totalScore;
}

$score_date = date("Y-m-d");

$stmt = $conn->prepare("INSERT INTO scores (archer_id, round_id, score_date, total_score) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iisi", $archer_id, $round_id, $score_date, $totalScoreAll);
$stmt->execute();

// Get the last score id
$last_score_id = $conn->insert_id;

// Set session variables
$_SESSION['last_score_id'] = $last_score_id;
$_SESSION['archer_id'] = $archer_id;
$_SESSION['round_id'] = $round_id;
$_SESSION['score_date'] = $score_date;
$_SESSION['total_score'] = $totalScoreAll;

$stmt->close();
$conn->close();
header('Location: success.php');
?>
