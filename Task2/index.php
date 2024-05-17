<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premier League Report</title>
    <link rel="stylesheet" href="layout.css">
    <link rel="stylesheet" href="styles.css">
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<header>
    <h3>CSYM019 - Premier League Results</h3>
</header>
<nav>
    <ul>
        <li><a href="./index.php">Premier League Report</a></li>
        <li><a href="./sampleEntryForm.html">Add New Football Team</a></li>
    </ul>
</nav>
<main>
    <h3>Sample Football Teams Selection Form</h3>

    <div class="sketch">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <table>
                <thead>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th>Position</th>
                    <th>Team</th>
                    <th>Won</th>
                    <th>Drawn</th>
                    <th>Lost</th>
                    <th>For</th>
                    <th>Against</th>
                    <th>GD</th>
                    <th>Points</th>
                </tr>
                </thead>
                <tbody>
                <?php
                // Database connection
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "league";

                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    echo "<p> Connection Failed<p>";
                    die("Connection failed: " . $conn->connect_error);
                }

                // Check if the form has been submitted and teams are selected
                $teams_data = [];
                if (isset($_POST['generate_report']) && isset($_POST['teams']) && is_array($_POST['teams'])) {
                    $selected_teams = $_POST['teams'];

                    // Fetch data for selected teams
                    foreach ($selected_teams as $team_id) {
                        $sql = "SELECT * FROM teams WHERE id = $team_id";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $teams_data[] = $row;
                        }
                    }

                    // Generate HTML table for selected teams
                    echo "<h2>Selected Teams Report</h2>";
                    echo "<table border='1'>";
                    echo "<tr><th>Team</th><th>Won</th><th>Drawn</th><th>Lost</th><th>For</th><th>Against</th><th>GD</th><th>Points</th></tr>";
                    foreach ($teams_data as $team) {
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
                }

                // Fetch and display teams
                $sql = "SELECT id, position, team, won, drawn, lost, goalsfor, against, gd, points FROM teams";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td><input type='checkbox' name='teams[]' class='select-row' value='" . $row["id"] . "'></td>";
                        echo "<td>" . $row["position"] . "</td>";
                        echo "<td>" . $row["team"] . "</td>";
                        echo "<td>" . $row["won"] . "</td>";
                        echo "<td>" . $row["drawn"] . "</td>";
                        echo "<td>" . $row["lost"] . "</td>";
                        echo "<td>" . $row["goalsfor"] . "</td>";
                        echo "<td>" . $row["against"] . "</td>";
                        echo "<td>" . $row["gd"] . "</td>";
                        echo "<td>" . $row["points"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>No teams found</td></tr>";
                }

                $conn->close();
                ?>
                </tbody>
            </table>
            <input type="submit" value="Create Report" name="generate_report"/>
        </form>
    </div>

    <?php if (!empty($teams_data)): ?>
        <div id="charts-container">
            <?php foreach ($teams_data as $index => $team): ?>
                <h4><?php echo $team['team']; ?></h4>
                <canvas id="pieChart<?php echo $index; ?>" width="200" height="200"></canvas>
            <?php endforeach; ?>
            <?php if (count($teams_data) > 1): ?>
                <canvas id="barChart"></canvas>
            <?php endif; ?>
        </div>
        <script>
            const teamsData = <?php echo json_encode($teams_data); ?>;

            teamsData.forEach((team, index) => {
                const pieCtx = document.getElementById('pieChart' + index).getContext('2d');
                const totalMatches = team.won + team.drawn + team.lost;

                // Prepare data for pie chart
                const pieData = {
                    labels: ['Won', 'Drawn', 'Lost'],
                    datasets: [{
                        data: [team.won, team.drawn, team.lost],
                        backgroundColor: ['#36a2eb', '#ffcd56', '#ff6384'],
                    }]
                };

                // Create pie chart
                new Chart(pieCtx, {
                    type: 'pie',
                    data: pieData,
                    maintainAspectRatio: false,
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                        const label = context.label || '';
                                        const value = context.raw;
                                        const percentage = ((value / totalMatches) * 100).toFixed(2);
                                        return `${label}: ${value} (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            });

            // Only create bar chart if more than one team is selected
            if (teamsData.length > 1) {
                const barCtx = document.getElementById('barChart').getContext('2d');
                const barData = {
                    labels: teamsData.map(team => team.team),
                    datasets: [
                        {
                            label: 'Won',
                            data: teamsData.map(team => team.won),
                            backgroundColor: '#36a2eb'
                        },
                        {
                            label: 'Drawn',
                            data: teamsData.map(team => team.drawn),
                            backgroundColor: '#ffcd56'
                        },
                        {
                            label: 'Lost',
                            data: teamsData.map(team => team.lost),
                            backgroundColor: '#ff6384'
                        }
                    ]
                };

                // Create bar chart
                new Chart(barCtx, {
                    type: 'bar',
                    data: barData,
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                stacked: false
                            },
                            y: {
                                stacked: false
                            }
                        }
                    }
                });
            }
        </script>
    <?php endif; ?>
</main>
<footer>&copy; CSYM019 2024</footer>
<script>
    document.getElementById('select-all').addEventListener('change', function() {
        var checkboxes = document.querySelectorAll('.select-row');
        for (var checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    });
</script>
</body>
</html>
