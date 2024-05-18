<!DOCTYPE html>
<html>
    <head>
        <title>New Football Team</title>
        <link rel="stylesheet" href="layout.css">
    </head>
    <body>
        <header>
            <h3>CSYM019 - Premier League Results</h3>
        </header>
        <nav>
            <ul>
                <li><a href="./index.php">Premier League Report</a></li>
                <li><a href="./entryForm.php">Add New Football Team</a></li>
            </ul>
        </nav>
        <main>
            <h3>Football Teams Entery Form</h3>
            <div class="sketchc">
            <form id="add-team-form" action="entryForm.php" method="POST">
                
            <input type="text" name="team" placeholder="Team Name" required> <br><br>
            <input type="text" name="manager" placeholder="Manager Name" required><br><br>
            <input type="number" name="played" placeholder="Played" required><br><br>
            <input type="number" name="won" placeholder="Won" required><br><br>
            <input type="number" name="drawn" placeholder="Drawn" required><br><br>
            <input type="number" name="lost" placeholder="Lost" required><br><br>
            <input type="number" name="goalsfor" placeholder="For" required><br><br>
            <input type="number" name="against" placeholder="Against" required><br><br>
            <input type="number" name="gd" placeholder="Goal Difference" required><br><br>
            <input type="number" name="points" placeholder="Points" required><br><br>
            <button type="submit">Submit</button>
        </form>
</div>
        </main>
        <footer>&copy; CSYM019 2024</footer>
    </body>
</html>


<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "league";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO teams (team, played, won, drawn, lost, goalsfor, against, gd, points, manager) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("siiiiiiiis", $team, $played, $won, $drawn, $lost, $goalsfor, $against, $gd, $points, $manager);

    // Set parameters and execute
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

    if ($stmt->execute()) {
        echo "<p>New team added successfully!</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conn->close();

    // Redirect back to index.php after 2 seconds
    header("refresh:2;url=index.php");
}
?>

</body>
</html>
