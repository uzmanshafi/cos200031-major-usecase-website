<?php
session_start();
require_once "settings.php";

$conn = @mysqli_connect($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$rounds = $conn->query("SELECT r.id, r.round_name, SUM(rr.ends * rr.arrows_per_end) as total_arrows FROM rounds r INNER JOIN ranges rr ON r.id = rr.round_id GROUP BY r.id, r.round_name");
$archers = $conn->query("SELECT a.id, a.first_name, a.last_name, et.equipment_name FROM archers a INNER JOIN equipment_types et ON a.default_equipment_id = et.id");

if (!$rounds || !$archers) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Page 1</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="styles/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="index_container">
    <form id="selectForm" action="page2.php" method="post">
        <label for="round_id">Choose a round:</label>
        <select id="round_id" name="round_id">
            <option value="" disabled selected>Choose a round</option>
            <?php while ($row = $rounds->fetch_assoc()) : ?>
                <option value="<?= $row['id'] ?>"><?= $row['round_name'] ?>, <?= $row['total_arrows'] ?> Arrows</option>
            <?php endwhile; ?>
        </select>

        <label for="archer_id">Choose an archer:</label>
        <select id="archer_id" name="archer_id">
            <option value="" disabled selected>Choose an archer</option>
            <?php while ($row = $archers->fetch_assoc()) : ?>
                <option value="<?= $row['id'] ?>" data-equipment="<?= $row['equipment_name'] ?>"><?= $row['first_name'] ?> <?= $row['last_name'] ?></option>
            <?php endwhile; ?>
        </select>

        <div id="archerInfo"></div>

        <input type="hidden" id="archerName" name="archerName" />
        <input type="hidden" id="archerEquipment" name="archerEquipment" />

        <input type="submit" value="Done">
    </form>
    </div>

    <script>
        $('#archer_id').change(function() {
        var selectedOption = $(this).find('option:selected');
        var fullName = selectedOption.text();
        var equipment = selectedOption.data('equipment');
        if (equipment) {
            console.log('Full Name:', fullName); // Debugging line
            console.log('Equipment:', equipment); // Debugging line
            $('#archerInfo').html('<h2>Archer Details </h2> <p>Name: ' + fullName + '<br> Equipment: ' + equipment + ' </p>');
            $('#archerName').val(fullName);
            $('#archerEquipment').val(equipment);
        } else {
            $('#archerInfo').empty();
            $('#archerName').val('');
            $('#archerEquipment').val('');
        }
        });
    </script>

</body>

</html>

<!-- this was create by uzman shafi for a swinburne assignment. this should not be used to plagarise any future assignments by other students. this should be seen as an educational material -->