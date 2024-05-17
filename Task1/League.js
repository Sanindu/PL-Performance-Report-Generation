function fetchData(callback) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'League.json', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            const data = JSON.parse(xhr.responseText);
            callback(data);
        } else {
            console.error('Error fetching data');
        }
    };
    xhr.send();
}

function calculatePoints(won, drawn) {
    return won * 3 + drawn;
}

function updateLeagueTable(data) {
    const table = document.getElementById('league-table');
    table.innerHTML = ''; // Clear previous content

    // Create table header
    const header = table.insertRow();
    ['Team', 'Played', 'Won', 'Drawn', 'Lost', 'Goals For', 'Goals Against', 'Goal Difference', 'Points'].forEach(text => {
        const cell = header.insertCell();
        cell.innerText = text;
    });

    // Create table rows
    data.premier_league_table.forEach(team => {
        const row = table.insertRow();
        ['team', 'played', 'won', 'drawn', 'lost', 'for', 'against', 'gd', 'points'].forEach(key => {
            const cell = row.insertCell();
            cell.innerText = team[key];
        });
    });
}

function updateTopScorersTable(data) {
    const table = document.getElementById('topscorers-table');
    table.innerHTML = ''; // Clear previous content

    // Create table header
    const header = table.insertRow();
    ['Name', 'Team', 'Goals', 'Assists', 'Played', 'Goals per 90', 'Mins per Goal', 'Total Shots', 'Goal Conversion', 'Shot Accuracy'].forEach(text => {
        const cell = header.insertCell();
        cell.innerText = text;
    });

    // Create table rows
    data.top_scorers.forEach(player => {
        const row = table.insertRow();
        ['name', 'team', 'goals', 'assists', 'played', 'goals_per_90', 'mins_per_goal', 'total_shots', 'goal_conversion', 'shot_accuracy'].forEach(key => {
            const cell = row.insertCell();
            cell.innerText = player[key];
        });
    });
}

function updateTables() {
    fetchData(data => {
        data.premier_league_table.forEach(team => {
            team.points = calculatePoints(team.won, team.drawn); // Update points dynamically
        });
        console.log("Coming here 0");
        updateTopScorersTable(data);
        console.log("Coming here 1");
        updateLeagueTable(data);
        console.log("Coming here 2");

    });

    setTimeout(updateTables, 3); // Update every 30 seconds
}

document.addEventListener('DOMContentLoaded', updateTables);
