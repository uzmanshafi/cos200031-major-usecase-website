<?php
session_start();
require_once "settings.php";
$conn = @mysqli_connect($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$last_score_id = $_SESSION['last_score_id'];
$stmt = $conn->prepare("SELECT * FROM scores WHERE id = ?");
$stmt->bind_param("i", $last_score_id);
$stmt->execute();
$result = $stmt->get_result();
$score = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Score Submission Confirmation</title>
    <link rel="stylesheet" href="styles/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="success_page">
    <div class="success_container">
        <h1>Score Submission Successful</h1>
        <p>Your scores have been submitted successfully. Thank you for participating!</p>
        <h2>Your Submitted Scores:</h2>
        <ul>
            <li>Archer ID: <?php echo isset($_SESSION['archer_id']) ? $_SESSION['archer_id'] : ''; ?></li>
            <li>Round ID: <?php echo isset($_SESSION['round_id']) ? $_SESSION['round_id'] : ''; ?></li>
            <li>Score Date: <?php echo date('Y-m-d'); ?></li>
            <li>Total Score: <?php echo isset($_SESSION['total_score']) ? $_SESSION['total_score'] : ''; ?></li>
        </ul>
        <a href="index.php">Go Back to Home</a>
    </div>
</body>

</html>