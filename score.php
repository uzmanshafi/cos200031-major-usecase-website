<?php
// Connect to the database
$host = 'feenx-mariadb.swin.edu.au';
$user = 's103177240';
$pass = 'thinhdang';
$db = 's103177240_db';

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch round details
$roundId = $_POST['round'];
$resultRoundDetails = $conn->query("SELECT ends FROM round_details WHERE round_id = $roundId");
$roundDetails = $resultRoundDetails->fetch_assoc();

// Fetch archer equipment
$archerId = $_POST['archer'];
$resultArcherEquipment = $conn->query("SELECT default_equipment_id FROM archers WHERE id = $archerId");
$archerEquipment = $resultArcherEquipment->fetch_assoc();

// TODO: You would usually display this info to the user and potentially let them edit it
?>

<!DOCTYPE html>
<html>
<body>
    <form action="submit_score.php" method="POST">
        <?php for ($i = 1; $i <= $roundDetails['ends']; $i++): ?>
        <label for="end<?php echo $i; ?>">End <?php echo $i; ?>:</label>
        <input type="number" id="end<?php echo $i; ?>" name="end<?php echo $i; ?>">
        <?php endfor; ?>
        
        <input type="hidden" name="archer" value="<?php echo $archerId; ?>">
        <input type="hidden" name="round" value="<?php echo $roundId; ?>">
        <input type="submit" value="Submit Scores">
    </form>
</body>
</html>
