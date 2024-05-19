<!DOCTYPE html>
<!DOCTYPE html>
<html>
<head>
    <title>New Football Team</title>
    <!-- Link to an external stylesheet -->
    <link rel="stylesheet" href="layout.css">
</head>
<body>
    <!-- Header section -->
    <header>
        <h3>CSYM019 - Premier League Results</h3>
    </header>

    <!-- Navigation section -->
    <nav>
        <ul>
            <!-- List item with a link to the 'report.php' page -->
            <li><a href="./report.php">Premier League Report</a></li>
            <!-- List item with a link to the 'entryForm.php' page (current page) -->
            <li><a href="./entryForm.php">Add New Football Team</a></li>
        </ul>
    </nav>

    <!-- Main content section -->
    <main>
        <!-- Heading for the form -->
        <h3>Football Teams Entry Form</h3>
        <!-- Container div -->
        <div class="sketchc">
            <!-- Form element with action set to 'entryForm.php' and method set to POST -->
            <form id="add-team-form" action="entryForm.php" method="POST">
                <!-- Text input for team name -->
                <input type="text" name="team" placeholder="Team Name" required> <br><br>
                <!-- Text input for manager name -->
                <input type="text" name="manager" placeholder="Manager Name" required><br><br>
                <!-- Number input for matches played -->
                <input type="number" name="played" placeholder="Played" required><br><br>
                <!-- Number input for matches won -->
                <input type="number" name="won" placeholder="Won" required><br><br>
                <!-- Number input for matches drawn -->
                <input type="number" name="drawn" placeholder="Drawn" required><br><br>
                <!-- Number input for matches lost -->
                <input type="number" name="lost" placeholder="Lost" required><br><br>
                <!-- Number input for goals scored -->
                <input type="number" name="goalsfor" placeholder="For" required><br><br>
                <!-- Number input for goals conceded -->
                <input type="number" name="against" placeholder="Against" required><br><br>
                <!-- Number input for goal difference -->
                <input type="number" name="gd" placeholder="Goal Difference" required><br><br>
                <!-- Number input for points -->
                <input type="number" name="points" placeholder="Points" required><br><br>
                <!-- Number input for remaining matches -->
                <input type="number" name="remaining" placeholder="Remaining" required><br><br>
                <!-- Submit button -->
                <button type="submit">Submit</button>
            </form>
        </div>
    </main>

    <!-- Footer section -->
    <footer>&copy; CSYM019 2024</footer>
</body>
</html>

<?php
// Check if the form has been submitted using the POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "league";

    // Create a new MySQLi connection object
    // Referance :  MySQLi Extension Documentation. Available online at: [MySQLi Extension Documentation](https://www.php.net/manual/en/book.mysqli.php)
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check if the connection was successful
    if ($conn->connect_error) {
        // If connection fails, terminate script execution and display error message
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare an SQL INSERT statement with placeholders for values
    $stmt = $conn->prepare("INSERT INTO teams (team, played, won, drawn, lost, goalsfor, against, gd, points, manager, remaining) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind parameters to the prepared statement
    $stmt->bind_param("siiiiiiiisi", $team, $played, $won, $drawn, $lost, $goalsfor, $against, $gd, $points, $manager, $remaining);

    // Set values for the parameters
    $team = $_POST['team'];
    $manager = $_POST['manager'];
    $played = $_POST['played'];
    $won = $_POST['won'];
    $drawn = $_POST['drawn'];
    $lost = $_POST['lost'];
    $goalsfor = $_POST['goalsfor'];
    $against = $_POST['against'];
    $gd = $_POST['gd'];
    $points = $_POST['points'];
    $remaining = $_POST['remaining'];

    // Execute the prepared statement
    if ($stmt->execute()) {
        // If execution is successful, display success message
        echo "<p>New team added successfully!</p>";
    } else {
        // If execution fails, display error message with details
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    // Close the prepared statement
    $stmt->close();

    // Close the database connection
    $conn->close();

    // Redirect the user to the 'report.php' page after 2 seconds
    // Referance : PHP Redirect - GeeksforGeeks. Available online at: [PHP Redirect](https://www.geeksforgeeks.org/how-to-redirect-a-page-to-another-page-in-php/)
    header("refresh:2;url=report.php");
}
?>
</body>
<!-- 
References:
1. HTML5 Documentation - Mozilla Developer Network (MDN). Available online at: [HTML5 Documentation](https://developer.mozilla.org/en-US/docs/Web/Guide/HTML/HTML5)
2. PHP Header Function - PHP Manual. Available online at: [PHP Header Function](https://www.php.net/manual/en/function.header.php)
3. PHP Redirect - GeeksforGeeks. Available online at: [PHP Redirect](https://www.geeksforgeeks.org/how-to-redirect-a-page-to-another-page-in-php/)
4. MySQLi Extension Documentation. Available online at: [MySQLi Extension Documentation](https://www.php.net/manual/en/book.mysqli.php)
-->
</html>
