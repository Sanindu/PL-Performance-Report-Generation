<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premier League Report</title>
    <link rel="stylesheet" href="layout.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    <h3>Football Teams Selection Form</h3>
    <div id="editSuccessMessage" style="display: none; color: green;">Successfully edited!</div>
    <div class="sketch">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="teamsForm">
         <input type="hidden" name="delete_team_iden" id="delete_team_iden">
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
                    <th>Actions</th>
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

                // Handle deletion of selected records
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (isset($_POST['delete_selected']) && isset($_POST['teams']) && is_array($_POST['teams'])) {
                        $selected_teams = $_POST['teams'];
                        foreach ($selected_teams as $team_id) {
                            $sql = "DELETE FROM teams WHERE id = $team_id";
                            $conn->query($sql);
                        }
                        header("Location: " . $_SERVER["PHP_SELF"]);
                        exit;
                    }
                }

                
                    
                // Initialize teams data array
                $teams_data = [];

                // Handle report generation
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['generate_report']) && isset($_POST['teams']) && is_array($_POST['teams'])) {
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
                }
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (isset($_POST['delete_selected']) && isset($_POST['teams']) && is_array($_POST['teams'])) {
                        $selected_teams = $_POST['teams'];
                        foreach ($selected_teams as $team_id) {
                            $sql = "DELETE FROM teams WHERE id = $team_id";
                            $conn->query($sql);
                        }
                        header("Location: " . $_SERVER["PHP_SELF"]);
                        exit;
                    }
                
                    // Handle individual deletion

if (isset($_POST['delete_team_iden'])) {
    try {
        // Establish database connection
        // Assuming $conn is already initialized earlier
        
        $team_id = $_POST['delete_team_iden'];
        $sql = "DELETE FROM teams WHERE id = $team_id";
        
        // Execute query
        if ($conn->query($sql) === TRUE) {
            header("Location: " . $_SERVER["PHP_SELF"]);
            exit;
        } else {
            throw new Exception("Error deleting record: " . $conn->error);
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

                }
                

                // Handle edit form submission
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_team'])) {
                    $team_id = $_POST['team_id'];
                    $team = $_POST['team'];
                    $won = $_POST['won'];
                    $drawn = $_POST['drawn'];
                    $lost = $_POST['lost'];
                    $goalsfor = $_POST['goalsfor'];
                    $against = $_POST['against'];
                    $gd = $_POST['gd'];
                    $points = $_POST['points'];

                    $sql = "UPDATE teams SET 
                            team='$team', 
                            won='$won', 
                            drawn='$drawn', 
                            lost='$lost', 
                            goalsfor='$goalsfor', 
                            against='$against', 
                            gd='$gd', 
                            points='$points' 
                            WHERE id=$team_id";
                    $conn->query($sql);

                    header("Location: " . $_SERVER["PHP_SELF"]);
                    exit;
                }

                // Fetch and display teams sorted by points
                $sql = "SELECT id, team, won, drawn, lost, goalsfor, against, gd, points FROM teams ORDER BY points DESC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $position = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td><input type='checkbox' name='teams[]' class='select-row' value='" . $row["id"] . "'></td>";
                        echo "<td>" . $position++ . "</td>";
                        echo "<td>" . $row["team"] . "</td>";
                        echo "<td>" . $row["won"] . "</td>";
                        echo "<td>" . $row["drawn"] . "</td>";
                        echo "<td>" . $row["lost"] . "</td>";
                        echo "<td>" . $row["goalsfor"] . "</td>";
                        echo "<td>" . $row["against"] . "</td>";
                        echo "<td>" . $row["gd"] . "</td>";
                        echo "<td>" . $row["points"] . "</td>";
                        echo "<td><button type='button' name = 'editbuttonaction' onclick='editTeam(" . json_encode($row) . ")'>Edit</button>
                        <button type='button' name = 'deletebuttonaction' onclick='deleteTeam(" . $row["id"] . ")'>Delete</button>
                        
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='11'>No teams found</td></tr>";
                }

                $conn->close();
                ?>
                </tbody>
            </table>
            <input type="submit" value="Create Report" id ="createreportbutton" name="generate_report"/>
        </form>
        <br>
    </div>

    <?php if (!empty($teams_data)): ?>
        <div id="charts-container" style="width: 50%; height: 50%;">
            <?php foreach ($teams_data as $index => $team): ?>
                <h4><?php echo $team['team']; ?></h4>
                <canvas id="pieChart<?php echo $index; ?>"></canvas>
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

                const pieData = {
                    labels: ['Won', 'Drawn', 'Lost'],
                    datasets: [{
                        data: [team.won, team.drawn, team.lost],
                        backgroundColor: ['#006400', '#F4BC1C', '#8b0000'],
                    }]
                };

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

            if (teamsData.length > 1) {
                const barCtx = document.getElementById('barChart').getContext('2d');
                const barData = {
                    labels: teamsData.map(team => team.team),
                    datasets: [
                        {
                            label: 'Won',
                            data: teamsData.map(team => team.won),
                            backgroundColor: '#006400'
                        },
                        {
                            label: 'Drawn',
                            data: teamsData.map(team => team.drawn),
                            backgroundColor: '#F4BC1C'
                        },
                        {
                            label: 'Lost',
                            data: teamsData.map(team => team.lost),
                            backgroundColor: '#8b0000'
                        }
                    ]
                };

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

    <!-- Edit Team Modal -->
    <div id="editModal" style="display:none;">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="team_id" id="edit_team_id">
            <label>Team: <input type="text" name="team" id="edit_team"></label><br>
            <label>Won: <input type="number" name="won" id="edit_won"></label><br>
            <label>Drawn: <input type="number" name="drawn" id="edit_drawn"></label><br>
            <label>Lost: <input type="number" name="lost" id="edit_lost"></label><br>
            <label>For: <input type="number" name="goalsfor" id="edit_goalsfor"></label><br>
            <label>Against: <input type="number" name="against" id="edit_against"></label><br>
            <label>GD: <input type="number" name="gd" id="edit_gd"></label><br>
            <label>Points: <input type="number" name="points" id="edit_points"></label><br>
            <input type="submit" name="edit_team" value="Save Changes">
        </form>
    </div>
</main>
<footer>&copy; CSYM019 2024</footer>
<script>
    document.getElementById('select-all').addEventListener('change', function() {
        var checkboxes = document.querySelectorAll('.select-row');
        for (var checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
        document.getElementById('delete-selected').style.display = this.checked ? 'inline-block' : 'none';
    });

    document.querySelectorAll('.select-row').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            var anyChecked = document.querySelectorAll('.select-row:checked').length > 0;
            document.getElementById('delete-selected').style.display = anyChecked ? 'inline-block' : 'none';
        });
    });

    function editTeam(team) {
        document.getElementById('edit_team_id').value = team.id;
        document.getElementById('edit_team').value = team.team;
        document.getElementById('edit_won').value = team.won;
        document.getElementById('edit_drawn').value = team.drawn;
        document.getElementById('edit_lost').value = team.lost;
        document.getElementById('edit_goalsfor').value = team.goalsfor;
        document.getElementById('edit_against').value = team.against;
        document.getElementById('edit_gd').value = team.gd;
        document.getElementById('edit_points').value = team.points;

        document.getElementById('editModal').style.display = 'block';

    document.getElementById('editSuccessMessage').style.display = 'none'; // Hide the success message initially
}

document.querySelector('form[action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"]').addEventListener('submit', function(event) {
    // After form submission, show the success message if it was a successful edit
    document.getElementById('editSuccessMessage').style.display = <?php echo isset($_POST['edit_team']) ? 'block' : 'none'; ?>;
});

    

    function deleteTeam(id) {
const confirmation = confirm("Are you sure you want to delete this team?");
if (confirmation) {
    document.getElementById('delete_team_iden').value = id;

    document.getElementById('teamsForm').submit();
}
}

</script>
</body>
</html>
