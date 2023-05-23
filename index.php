<?php
// Connect to the database
$host = 'feenix-mariadb.swin.edu.au';
$user = 's103177240';
$pass = 'thinhdang';
$db = 's103177240_db';

$conn = @mysqli_connect($host, $user, $pass, $db);

if (!$conn) 
{
    echo "<p>Database connection failure</p>";
} 
else {
    // Query to fetch rounds
$resultRounds = $conn->query("SELECT id, round_name FROM rounds");
$rounds = $resultRounds->fetch_all(MYSQLI_ASSOC);

// Query to fetch archers
$resultArchers = $conn->query("SELECT id, first_name, last_name FROM archers");
$archers = $resultArchers->fetch_all(MYSQLI_ASSOC);
}

?>

<!DOCTYPE html>
<html>
<body>
    <form action="score.php" method="POST">
        <label for="round">Choose Rounds:</label>
        <select id="round" name="round">
            <?php foreach ($rounds as $round): ?>
            <option value="<?php echo $round['id']; ?>"><?php echo $round['round_name']; ?></option>
            <?php endforeach; ?>
        </select>

        <label for="archer">Select an archer:</label>
        <select id="archer" name="archer">
            <?php foreach ($archers as $archer): ?>
            <option value="<?php echo $archer['id']; ?>"><?php echo $archer['first_name'] . ' ' . $archer['last_name']; ?></option>
            <?php endforeach; ?>
        </select>
        
        <input type="submit" value="Next">
    </form>
</body>
</html>
