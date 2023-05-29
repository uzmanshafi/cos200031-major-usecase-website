<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Page 2</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="styles/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="score_page">

<div class="score_container">
<h2>Score Input</h2>
    <p>Archer: <?php echo isset($_POST["archerName"]) ? $_POST["archerName"] : ""; ?></p>
    <p>Equipment: <?php echo isset($_POST["archerEquipment"]) ? $_POST["archerEquipment"] : ""; ?></p>
    <form id="scoreInputForm" method="POST" action="submit_scores.php">
        <label for="ends">Choose number of ends:</label>
        <select id="ends" name="ends">
            <option selected disabled>Choose number of ends</option>
            <option value="5">5</option>
            <option value="6">6</option>
        </select>

        <div id="endsContainer"></div>

        <div id="keypad">
            <button class="keypad-btn" type="button" value="X">X</button>
            <button class="keypad-btn" type="button" value="10">10</button>
            <button class="keypad-btn" type="button" value="9">9</button>
            <button class="keypad-btn" type="button" value="8">8</button>
            <button class="keypad-btn" type="button" value="7">7</button>
            <button class="keypad-btn" type="button" value="6">6</button>
            <button class="keypad-btn" type="button" value="5">5</button>
            <button class="keypad-btn" type="button" value="4">4</button>
            <button class="keypad-btn" type="button" value="3">3</button>
            <button class="keypad-btn" type="button" value="2">2</button>
            <button class="keypad-btn" type="button" value="1">1</button>
            <button class="keypad-btn" type="button" value="M">M</button>
        </div>

        <input type="hidden" id="archer_id" name="archer_id" value="<?php echo $_POST["archer_id"]; ?>" />
        <input type="hidden" id="round_id" name="round_id" value="<?php echo $_POST["round_id"]; ?>" />
        <input type="submit" value="Submit Scores">
    </form>
</div>
    
    <script>
        var currentArrow = null;

        $(document).ready(function() {
            $('#keypad').hide();

            $('#ends').change(function() {
                var ends = $('#ends').val();
                $('#endsContainer').empty();
                // We'll start by just displaying the first end
                appendEnd(1);
                $('#keypad').show();
            });

            function appendEnd(num) {
                $('#endsContainer').append("<div id='end" + num + "'><h3>End " + num + "</h3><div class='endInputs'></div><p class='totalScore'>Total Score: 0</p></div>");
                for (var j = 1; j <= 6; j++) {
                    $("#end" + num + " .endInputs").append("<input type='text' id='end" + num + "arrow" + j + "' name='end" + num + "arrow" + j + "' readonly>");
                }
            }

            $(document).on('focus', 'input', function() {
                currentArrow = $(this);
            });

            $('.keypad-btn').click(function() {
                if (currentArrow && currentArrow.val() == "") {
                    var score = $(this).val() === "X" ? 10 : ($(this).val() === "M" ? 0 : $(this).val());
                    currentArrow.val(score);
                    var end = currentArrow.parent().parent();
                    var totalScore = end.find('.totalScore');
                    totalScore.text("Total Score: " + (parseInt(totalScore.text().split(":")[1]) + parseInt(score)));
                    // Check if this is the last arrow of the end
                    if (currentArrow.index() == 5) {
                        // If there are less ends than the selected ends, append the next one
                        if ($('#endsContainer > div').length < $('#ends').val()) {
                            appendEnd($('#endsContainer > div').length + 1);
                        }
                    }
                    currentArrow = currentArrow.parent().find('input').eq(currentArrow.index() + 1);
                }
            });
        });
    </script>

</body>

</html>