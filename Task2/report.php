<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags for character set and viewport -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- Title of the page -->
    <title>Premier League Report</title>
     <!-- Link to external stylesheet -->
    <link rel="stylesheet" href="layout.css">
     <!-- Link to Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<header>
     <!-- Header displaying the title -->
    <h3>CSYM019 - Premier League Results</h3>
</header>
<nav>
    <!-- Navigation menu -->
    <ul>
        <!-- Links to other pages -->
        <li><a href="./report.php">Premier League Report</a></li>
        <li><a href="./entryForm.php">Add New Football Team</a></li>
    </ul>
</nav>
<main>
    <!-- Main content -->
    <h3>Football Teams Selection Form</h3>
     <!-- Success message for edit -->
    <div id="editSuccessMessage" style="display: none; color: green;">Successfully edited!</div>
     <!-- Form for selecting teams -->
    <div class="sketch">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="teamsForm">
         <!-- Hidden input field for deleting a team -->
         <input type="hidden" name="delete_team_iden" id="delete_team_iden">
          <!-- Table for displaying team data -->
            <table>
                 <!-- Table headers -->
                <thead>
                <tr>
                     <!-- Checkbox for selecting all rows -->
                    <th><input type="checkbox" id="select-all"></th>
                     <!-- Column headers -->
                    <th>Position</th>
                    <th>Team</th>
                    <th>Won</th>
                    <th>Drawn</th>
                    <th>Lost</th>
                    <th>For</th>
                    <th>Against</th>
                    <th>GD</th>
                    <th>Points</th>
                    <th>Remaining</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <!-- Table body -->
                <?php
                // Database connection
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "league";

                // Referance :  MySQLi Extension Documentation. Available online at: [MySQLi Extension Documentation](https://www.php.net/manual/en/book.mysqli.php)
                $conn = new mysqli($servername, $username, $password, $dbname);
                
                // Check connection
                if ($conn->connect_error) {
                    echo "<p> Connection Failed<p>";
                    die("Connection failed: " . $conn->connect_error);
                }

                // Handle deletion of selected records
                if ($_SERVER["REQUEST_METHOD"] == "POST") { // Check if the request method is POST
                    if (isset($_POST['delete_selected']) && isset($_POST['teams']) && is_array($_POST['teams'])) { // Check if 'delete_selected' field is set and 'teams' field is set and is an array
                        $selected_teams = $_POST['teams']; // Retrieve the selected teams from the form data
                        foreach ($selected_teams as $team_id) { // Loop through each selected team ID
                            $sql = "DELETE FROM teams WHERE id = $team_id"; // Construct SQL query to delete the team with the specified ID
                            $conn->query($sql); // Execute the SQL query to delete the team
                        }
                        header("Location: " . $_SERVER["PHP_SELF"]); // Redirect back to the current page after successful deletion
                        exit; // Exit the script to prevent further execution
                    }
                }
                             
                // Initialize teams data array
                $teams_data = [];

                // Handle report generation
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['generate_report']) && isset($_POST['teams']) && is_array($_POST['teams'])) {
                    // Check if the request method is POST and the form has been submitted to generate a report
                    // Also, check if the 'teams' field is set and is an array
                
                    $selected_teams = $_POST['teams']; // Retrieve the selected teams from the form data
                
                    // Fetch data for selected teams
                    foreach ($selected_teams as $team_id) {
                        // Loop through each selected team ID
                        $sql = "SELECT * FROM teams WHERE id = $team_id"; // Construct SQL query to fetch data for the team with the specified ID
                        $result = $conn->query($sql); // Execute the SQL query
                        if ($result->num_rows > 0) { // Check if any rows are returned from the query
                            $row = $result->fetch_assoc(); // Fetch the row of data from the result set
                            $teams_data[] = $row; // Add the fetched data to the $teams_data array
                        }
                    }
                }
                
if ($_SERVER["REQUEST_METHOD"] == "POST") { // Check if the request method is POST
    if (isset($_POST['delete_selected']) && isset($_POST['teams']) && is_array($_POST['teams'])) { // Check if 'delete_selected' field is set and 'teams' field is set and is an array
        $selected_teams = $_POST['teams']; // Retrieve the selected teams from the form data
        foreach ($selected_teams as $team_id) { // Loop through each selected team ID
            $sql = "DELETE FROM teams WHERE id = $team_id"; // Construct SQL query to delete the team with the specified ID
            $conn->query($sql); // Execute the SQL query to delete the team
        }
        header("Location: " . $_SERVER["PHP_SELF"]); // Redirect back to the current page after successful deletion
        exit; // Exit the script to prevent further execution
    }
}             
                    // Handle individual deletion
                  // Referance :  Exception Handling in PHP. Available online at: [Exception Handling in PHP](https://www.php.net/manual/en/language.exceptions.php)
                    if (isset($_POST['delete_team_iden'])) {
                        try {
                            // Establish database connection
                            // Assuming $conn is already initialized earlier
                            
                            // Retrieve the team ID to be deleted from the POST data
                            $team_id = $_POST['delete_team_iden'];
                            
                            // Construct SQL query to delete the team with the specified ID from the 'teams' table
                            $sql = "DELETE FROM teams WHERE id = $team_id";
                            
                            // Execute the SQL query
                            if ($conn->query($sql) === TRUE) {
                                // If deletion is successful, redirect back to the current page to reflect changes
                                header("Location: " . $_SERVER["PHP_SELF"]);
                                exit;
                            } else {
                                // If there's an error during deletion, throw an exception with the error message
                                throw new Exception("Error deleting record: " . $conn->error);
                            }
                        } catch (Exception $e) {
                            // Catch any exceptions thrown during the deletion process and display the error message
                            echo "Error: " . $e->getMessage();
                        }
                    }
                                                 
// Check if the form has been submitted using POST method and if the 'edit_team' field is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_team'])) {
    // Retrieve the data submitted via POST
    $team_id = $_POST['team_id'];
    $team = $_POST['team'];
    $won = $_POST['won'];
    $drawn = $_POST['drawn'];
    $lost = $_POST['lost'];
    $goalsfor = $_POST['goalsfor'];
    $against = $_POST['against'];
    $gd = $_POST['gd'];
    $points = $_POST['points'];
    $remaining = $_POST['remaining'];

    // Construct the SQL query to update the team information in the database
    $sql = "UPDATE teams SET 
            team='$team', 
            won='$won', 
            drawn='$drawn', 
            lost='$lost', 
            goalsfor='$goalsfor', 
            against='$against', 
            gd='$gd', 
            points='$points', 
            remaining = '$remaining'
            WHERE id=$team_id";

    // Execute the SQL query
    $conn->query($sql);

    // Redirect back to the current page after successful update
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit;
}

// SQL query to fetch teams from the database sorted by points in descending order
$sql = "SELECT id, team, won, drawn, lost, goalsfor, against, gd, points , remaining FROM teams ORDER BY points DESC";
$result = $conn->query($sql);

// Check if there are any rows returned from the query
        if ($result->num_rows > 0) {
            // Variable to keep track of team position
            $position = 1;
            // Loop through each row of the result set
            while ($row = $result->fetch_assoc()) {
                // Display each team's information in a table row
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
                echo "<td>" . $row["remaining"] . "</td>";
                // Buttons for editing and deleting team data
                echo "<td><button type='button' name='editbuttonaction' onclick='editTeam(" . json_encode($row) . ")'>Edit</button>
                <button type='button' name='deletebuttonaction' onclick='deleteTeam(" . $row["id"] . ")'>Delete</button></td>";
                echo "</tr>";
            }
        } else {
            // If no teams are found in the database, display a message
            echo "<tr><td colspan='11'>No teams found</td></tr>";
        }
        // Close the database connection
        $conn->close();
                ?>
                </tbody>
            </table>
            <input type="submit" value="Create Report" id ="createreportbutton" name="generate_report"/>
        </form>
        <br>
    </div>

    <?php if (!empty($teams_data)): ?> <!-- Check if $teams_data is not empty -->
    <div id="charts-container" style="width: 50%; height: 50%;"> <!-- Display a div element with ID "charts-container" -->
        <?php foreach ($teams_data as $index => $team): ?> <!-- Iterate over each element in $teams_data -->
            <!-- Display team name -->
            <h4><?php echo $team['team']; ?></h4>
            <!-- Create canvas element for pie chart with unique ID -->
            <canvas id="pieChart<?php echo $index; ?>"></canvas>
        <?php endforeach; ?>
        <!-- If there are more than one team, create canvas element for bar chart -->
        <?php if (count($teams_data) > 1): ?>
            <canvas id="barChart"></canvas>
        <?php endif; ?>
    </div>
    <!-- JavaScript code for chart creation -->
    <script>
        // Encode PHP array $teams_data to JSON format
        const teamsData = <?php echo json_encode($teams_data); ?>;

        // Loop through each team data and create pie chart
        teamsData.forEach((team, index) => {
            // Get canvas context for pie chart
            const pieCtx = document.getElementById('pieChart' + index).getContext('2d');
            // Calculate total matches
            const totalMatches = team.won + team.drawn + team.lost + team.remaining;

            // Data for pie chart
            const pieData = {
    labels: ['Won', 'Drawn', 'Lost', 'Remaining'], // Labels for each segment of the pie chart
    datasets: [{ // Array of datasets, containing data and styling information for the chart
        data: [team.won, team.drawn, team.lost, team.remaining], // Array of numerical data values for each segment
        backgroundColor: ['#006400', '#F4BC1C', '#8b0000', '#1260CC'], // Array of background colors for each segment
    }]
};
            // Create new pie chart instance
            new Chart(pieCtx, { // Creates a new Chart instance with the specified canvas context (pieCtx)
    type: 'pie', // Specifies the type of chart to be created (pie chart)
    data: pieData, // Specifies the data to be used for rendering the chart (defined earlier in the code)
    maintainAspectRatio: false, // Specifies whether to maintain the aspect ratio of the chart (set to false)
    options: { // Specifies additional options for configuring the chart's appearance and behavior
        responsive: true, // Specifies whether the chart should be responsive (resize to fit its container)
        plugins: { // Specifies plugins to be used for the chart (in this case, legend and tooltip plugins)
            legend: { // Configures the legend plugin
                position: 'top', // Specifies the position of the legend (top of the chart)
            },
            tooltip: { // Configures the tooltip plugin
                callbacks: { // Specifies callback functions for customizing tooltip behavior
                    label: function (context) { // Configures the label callback for tooltips
                        const label = context.label || ''; // Retrieves the label of the current tooltip item
                        const value = context.raw; // Retrieves the raw value of the current tooltip item
                        const percentage = ((value / totalMatches) * 100).toFixed(2); // Calculates the percentage of the total matches
                        return `${label}: ${value} (${percentage}%)`; // Returns the customized tooltip label
                    }
                }
            }
        }
    }
});
        });

        // If there are more than one team, create bar chart
        if (teamsData.length > 1) {
            // Get canvas context for bar chart
            const barCtx = document.getElementById('barChart').getContext('2d');
            // Data for bar chart
                    const barData = {
                   labels: teamsData.map(team => team.team), // Array of labels for the bars (team names)
                   datasets: [ // Array of datasets, each representing a set of bars
                {
                    label: 'Won', // Label for the first dataset
                    data: teamsData.map(team => team.won), // Array of numerical data values for the first dataset (number of matches won for each team)
                    backgroundColor: '#006400' // Background color for the bars in the first dataset (green)
                },
                {
                    label: 'Drawn', // Label for the second dataset
                    data: teamsData.map(team => team.drawn), // Array of numerical data values for the second dataset (number of matches drawn for each team)
                    backgroundColor: '#F4BC1C' // Background color for the bars in the second dataset (yellow)
                },
                {
                    label: 'Lost', // Label for the third dataset
                    data: teamsData.map(team => team.lost), // Array of numerical data values for the third dataset (number of matches lost for each team)
                    backgroundColor: '#8b0000' // Background color for the bars in the third dataset (dark red)
                },
                {
                    label: 'Remaining', // Label for the fourth dataset
                    data: teamsData.map(team => team.remaining), // Array of numerical data values for the fourth dataset (number of matches remaining for each team)
                    backgroundColor: '#1260CC' // Background color for the bars in the fourth dataset (blue)
                }
            ]
        };
                     // Create new bar chart instance
                        new Chart(barCtx, { // Creates a new Chart instance with the specified canvas context (barCtx)
                type: 'bar', // Specifies the type of chart to be created (bar chart)
                data: barData, // Specifies the data to be used for rendering the chart (defined earlier in the code)
                options: { // Specifies additional options for configuring the chart's appearance and behavior
                    responsive: true, // Specifies whether the chart should be responsive (resize to fit its container)
                    scales: { // Specifies scale options for the axes
                        x: { // Configures the x-axis
                            stacked: false // Specifies whether bars should be stacked on the x-axis (set to false)
                        },
                        y: { // Configures the y-axis
                            stacked: false // Specifies whether bars should be stacked on the y-axis (set to false)
                        }
                    }
                }
            });

        }
    </script>
<?php endif; ?>


<!-- Edit Team Modal -->
<div id="editModal" style="display:none;">
    <!-- Form for editing team data -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <!-- Hidden input field to store the team ID -->
        <input type="hidden" name="team_id" id="edit_team_id">
        <!-- Input field for team name -->
        <label>Team: <input type="text" name="team" id="edit_team"></label><br>
        <!-- Input field for number of matches won -->
        <label>Won: <input type="number" name="won" id="edit_won"></label><br>
        <!-- Input field for number of matches drawn -->
        <label>Drawn: <input type="number" name="drawn" id="edit_drawn"></label><br>
        <!-- Input field for number of matches lost -->
        <label>Lost: <input type="number" name="lost" id="edit_lost"></label><br>
        <!-- Input field for goals scored -->
        <label>For: <input type="number" name="goalsfor" id="edit_goalsfor"></label><br>
        <!-- Input field for goals conceded -->
        <label>Against: <input type="number" name="against" id="edit_against"></label><br>
        <!-- Input field for goal difference -->
        <label>GD: <input type="number" name="gd" id="edit_gd"></label><br>
        <!-- Input field for points -->
        <label>Points: <input type="number" name="points" id="edit_points"></label><br>
        <!-- Input field for remaining matches -->
        <label>Remaining: <input type="number" name="remaining" id="edit_remaining"></label><br>
        <!-- Button to submit the form and save changes -->
        <input type="submit" name="edit_team" value="Save Changes">
    </form>
</div>
</main>
<!-- Footer indicating the copyright -->
<footer>&copy; CSYM019 2024</footer>
<script>
// Event listener for the 'select-all' checkbox
document.getElementById('select-all').addEventListener('change', function() {
    // Select all checkboxes with the class 'select-row' and set their checked status to match the 'select-all' checkbox
    var checkboxes = document.querySelectorAll('.select-row');
    for (var checkbox of checkboxes) {
        checkbox.checked = this.checked;
    }
    // Show or hide the 'delete-selected' button based on whether any checkboxes are checked
    document.getElementById('delete-selected').style.display = this.checked ? 'inline-block' : 'none';
});

// Event listener for individual checkboxes with class 'select-row'
document.querySelectorAll('.select-row').forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        // Check if any checkbox with class 'select-row' is checked
        var anyChecked = document.querySelectorAll('.select-row:checked').length > 0;
        // Show or hide the 'delete-selected' button based on whether any checkboxes are checked
        document.getElementById('delete-selected').style.display = anyChecked ? 'inline-block' : 'none';
    });
});

// Function to populate the edit modal with team data
function editTeam(team) {
    // Populate form fields with team data
    document.getElementById('edit_team_id').value = team.id;
    document.getElementById('edit_team').value = team.team;
    document.getElementById('edit_won').value = team.won;
    document.getElementById('edit_drawn').value = team.drawn;
    document.getElementById('edit_lost').value = team.lost;
    document.getElementById('edit_goalsfor').value = team.goalsfor;
    document.getElementById('edit_against').value = team.against;
    document.getElementById('edit_gd').value = team.gd;
    document.getElementById('edit_points').value = team.points;
    document.getElementById('edit_remaining').value = team.remaining;

    // Show the edit modal
    document.getElementById('editModal').style.display = 'block';
}

// Event listener for form submission
document.querySelector('form[action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"]').addEventListener('submit', function(event) {
    // After form submission, show the success message if it was a successful edit
    document.getElementById('editSuccessMessage').style.display = <?php echo isset($_POST['edit_team']) ? 'block' : 'none'; ?>;
});

// Function to delete a team
function deleteTeam(id) {
    // Display a confirmation dialog before proceeding with deletion
    const confirmation = confirm("Are you sure you want to delete this team?");
    if (confirmation) {
        // Set the value of the hidden input field to the team ID to be deleted
        document.getElementById('delete_team_iden').value = id;
        // Submit the form for team deletion
        document.getElementById('teamsForm').submit();
    }
}
</script>
</body>
<!--
References:

1. PHP Official Documentation. Available online at: [PHP Official Documentation](https://www.php.net/manual/en/)
2. MySQLi Extension Documentation. Available online at: [MySQLi Extension Documentation](https://www.php.net/manual/en/book.mysqli.php)
3. Exception Handling in PHP. Available online at: [Exception Handling in PHP](https://www.php.net/manual/en/language.exceptions.php)
4. PHP Header Function. Available online at: [PHP Header Function](https://www.php.net/manual/en/function.header.php)
5. PHP Arrays. Available online at: [PHP Arrays](https://www.php.net/manual/en/language.types.array.php)
6. Chart.js library
 -->
</html>
