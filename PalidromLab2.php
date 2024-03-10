<!DOCTYPE html>
<html>
<head>
    <title>Combined Palindrome Checker and Website Visit Counter</title>
</head>
<body>
    <h2>Palindrome Checker</h2>
    <form method="post">
        <label for="number">Enter a number:</label>
        <input type="text" id="number" name="number" required>
        <button type="submit">Check</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $number = $_POST["number"];
        $reversed = strrev($number);

        if ($number == $reversed) {
            echo "<script>alert('It\'s a Palindrome Number!!');</script>";
        } else {
            echo "<script>alert('It\'s Not a Palindrome Number.');</script>";
        }
    }

    // Visit Counter
	$visits = 1;

	if (isset($_COOKIE['visits'])) {
		$visits = $_COOKIE['visits'] + 1;
	}
	
	setcookie('visits', $visits, time() + 3600 * 24 * 30); 
	
	echo "<h2>In this Website</h2>";
	echo "Welcome to the website! This is visit number $visits.";
    ?>
</body>
</html>
