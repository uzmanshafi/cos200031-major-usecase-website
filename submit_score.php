<?php
// Connect to the database
$host = 'feenix-mariadb.swin.edu.au';
$user = 's103177240';
$pass = 'thinhdang';
$db = 's103177240_db';

$conn = @mysqli_connect($host, $user, $pass, $db);

// Check connection
if (!$conn) 
{
    echo "<p>Database connection failure</p>";
} 
else {

// Fetch data from POST
$archerId = $_POST['archer'];
$roundId = $_POST['round'];
$scores = [];
for ($i = 1; isset($_POST['end' . $i]); $i++) {
    $scores[] = $_POST['end' . $i];
}

// TODO: You would want to validate the scores before inserting them
// Also, you would probably want to use prepared statements instead of inserting the values directly into the query

// Insert scores into the database
foreach ($scores as $score) {
    $conn->query("INSERT INTO scores (archer_id, round_id, total_score) VALUES ($archerId, $roundId, $score)");
}
}

echo "Scores have been submitted!";
?>
