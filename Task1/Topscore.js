// Function to make an Ajax request to the specified URL and execute a callback function with the retrieved data
function makeAjaxRequest(url, callback) {
    // Create a new XMLHttpRequest object
    var xhr = new XMLHttpRequest();
    // Define a function to handle state changes of the request
    xhr.onreadystatechange = function() {
        // When the request is completed
        if (xhr.readyState === 4) {
            // If the request was successful
            if (xhr.status === 200) {
                try {
                    // Parse the response JSON data
                    var data = JSON.parse(xhr.responseText);
                    // Call the callback function with the retrieved data
                    callback(null, data);
                } catch (error) {
                    // If parsing the response JSON data fails, call the callback function with the error
                    callback(error, null);
                }
            } else {
                // If the request fails, call the callback function with an error
                callback(new Error('Request failed'), null);
            }
        }
    };
    // Open the request with the specified method and URL
    xhr.open('GET', url, true);
    // Send the request
    xhr.send();
}

// Fetch top scorers data from a JSON file and update the table periodically
function fetchTopScorersData() {
    // Make an Ajax request to retrieve data from the 'League.json' file
    makeAjaxRequest('League.json', function(error, data) {
        if (error) {
            // If an error occurs during the request, log the error
            console.error('Error fetching top scorers data:', error);
        } else {
            // If data is successfully retrieved, display the top scorers
            displayTopScorers(data.top_scorers);
            // Set a timeout to fetch the data again after 1 hour (3600000 milliseconds)
            setTimeout(fetchTopScorersData, 3600000);
        }
    });
}

// Display top scorers data in a table
function displayTopScorers(data) {
    // Get the table element
    var table = document.getElementById('top-scorers-table');
    // Create table header with column names
    table.innerHTML = '<thead><tr><th>Name</th><th>Team</th><th>Goals</th><th>Assists</th><th>Played</th><th>Goals/90</th><th>Mins/Goal</th><th>Total Shots</th><th>Goal Conversion</th><th>Shot Accuracy</th></tr></thead>';
    // Create a new tbody element
    var tbody = document.createElement('tbody');

    // Iterate over each player data and create table rows
    data.forEach(function(player) {
        var row = `<tr>
                        <td>${player.name}</td>
                        <td>${player.team}</td>
                        <td>${player.goals}</td>
                        <td>${player.assists}</td>
                        <td>${player.played}</td>
                        <td>${player.goals_per_90}</td>
                        <td>${player.mins_per_goal}</td>
                        <td>${player.total_shots}</td>
                        <td>${player.goal_conversion}</td>
                        <td>${player.shot_accuracy}</td>
                    </tr>`;
        // Append each row to the tbody
        tbody.innerHTML += row;
    });

    // Append the tbody to the table
    table.appendChild(tbody);
}

// Initialize the top scorers functionality
function initTopScorers() {
    // Start fetching top scorers data
    fetchTopScorersData();
}

// Call the init function when the window loads
window.onload = function() {
    try {
        // Initialize the top scorers functionality
        initTopScorers();
    } catch (error) {
        // If an error occurs during initialization, log the error
        console.error('An error occurred:', error);
    }
};
