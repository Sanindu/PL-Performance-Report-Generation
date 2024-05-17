<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "league";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form has been submitted
if(isset($_POST['generate_report'])) {
    // Check if any teams are selected
    if(isset($_POST['teams']) && is_array($_POST['teams'])) {
        $selected_teams = $_POST['teams'];

        // Fetch data for selected teams
        $teams_data = [];
        foreach($selected_teams as $team_id) {
            $sql = "SELECT * FROM teams WHERE id = $team_id";
            $result = $conn->query($sql);
            if($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $teams_data[] = $row;
            }
        }

        // Generate HTML table for selected teams
        echo "<h2>Selected Teams Report</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Team</th><th>Won</th><th>Drawn</th><th>Lost</th><th>For</th><th>Against</th><th>GD</th><th>Points</th></tr>";
        foreach($teams_data as $team) {
            echo "<tr>";
            echo "<td>" . $team["team"] . "</td>";
            echo "<td>" . $team["won"] . "</td>";
            echo "<td>" . $team["drawn"] . "</td>";
            echo "<td>" . $team["lost"] . "</td>";
            echo "<td>" . $team["goalsfor"] . "</td>";
            echo "<td>" . $team["against"] . "</td>";
            echo "<td>" . $team["gd"] . "</td>";
            echo "<td>" . $team["points"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";

        // Display chart only if more than one team is selected
        if(count($teams_data) > 1) {
            // Generate and display pie chart using Chart.js
            echo "<h2>Matches Played Chart</h2>";
            echo "<canvas id='matchesPlayedChart'></canvas>";

            // JavaScript to generate pie chart
            echo "<script>
                var ctx = document.getElementById('matchesPlayedChart').getContext('2d');
                var matchesPlayedChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Won', 'Drawn', 'Lost'],
                        datasets: [{
                            label: 'Matches Played',
                            data: [" . implode(",", array_column($teams_data, 'won')) . "," . implode(",", array_column($teams_data, 'drawn')) . "," . implode(",", array_column($teams_data, 'lost')) . "],
                            backgroundColor: [
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(255, 99, 132, 0.2)'
                            ],
                            borderColor: [
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(255, 99, 132, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            </script>";
        }
    } else {
        echo "<p>No teams selected.</p>";
    }
}

$conn->close();
?>
