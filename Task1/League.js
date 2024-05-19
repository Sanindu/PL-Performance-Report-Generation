// Function to make Ajax request
function makeAjaxRequest(url, callback) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        // Check if the request is complete
        if (xhr.readyState === 4) {
            // Check if the request was successful
            if (xhr.status === 200) {
                try {
                    // Parse the JSON response
                    var data = JSON.parse(xhr.responseText);
                    // Call the callback function with the parsed data
                    callback(null, data);
                } catch (error) {
                    // Call the callback function with the error
                    callback(error, null);
                }
            } else {
                // Call the callback function with an error if the request failed
                callback(new Error('Request failed'), null);
            }
        }
    };
    // Open a GET request to the specified URL
    xhr.open('GET', url, true);
    // Send the request
    xhr.send();
}

// Calculate points for each team
function calculatePoints(won, drawn) {
    return (won * 3) + drawn;
}

// Update the points in the league table data
function updatePoints(data) {
    // Iterate through each team and update their points
    data.forEach(function(team) {
        team.points = calculatePoints(team.won, team.drawn);
    });
}

// Fetch Premier League table data from JSON file
function fetchPremierLeagueTableData() {
    // Make an Ajax request to fetch the league table data
    makeAjaxRequest('League.json', function(error, data) {
        if (error) {
            // Log an error message if data fetching fails
            console.error('Error fetching Premier League table data:', error);
        } else {
            // Update the points for each team
            updatePoints(data.premier_league_table);
            // Display the updated league table
            displayPremierLeagueTable(data.premier_league_table);
        }
    });
}

// Display Premier League table data
function displayPremierLeagueTable(data) {
    // Get the table element by its ID
    var table = document.getElementById('premier-league-table');
    // Set the table headers
    table.innerHTML = '<thead><tr><th>Team</th><th>Played</th><th>Won</th><th>Drawn</th><th>Lost</th><th>For</th><th>Against</th><th>GD</th><th>Points</th></tr></thead>';
    // Create a new tbody element
    var tbody = document.createElement('tbody');

    // Loop through the data array and create table rows for each team
    data.forEach(function(team) {
        var row = `<tr>
                        <td>${team.team}</td>
                        <td>${team.played}</td>
                        <td>${team.won}</td>
                        <td>${team.drawn}</td>
                        <td>${team.lost}</td>
                        <td>${team.for}</td>
                        <td>${team.against}</td>
                        <td>${team.gd}</td>
                        <td>${team.points}</td>
                    </tr>`;
        // Add the row to the tbody
        tbody.innerHTML += row;
    });

    // Append the tbody to the table
    table.appendChild(tbody);
}

// Update Premier League table every 1 hour
function updateTablePeriodically() {
    // Fetch and display the Premier League table data
    fetchPremierLeagueTableData();
    // Set a timeout to update the table again after  1 hour
    setTimeout(updateTablePeriodically, 3600000);
}

// Initial setup for Premier League table
function initPremierLeagueTable() {
    // Fetch and display the Premier League table data
    fetchPremierLeagueTableData();
    // Update the Premier League table periodically
    updateTablePeriodically();
}

// Call the init function when the window loads
window.onload = function() {
    try {
        // Initialize the Premier League table setup
        initPremierLeagueTable();
    } catch (error) {
        // Log any errors that occur during initialization
        console.error('An error occurred:', error);
    }
};
