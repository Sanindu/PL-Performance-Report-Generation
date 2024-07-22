# Basic Football Teams Performance Report Application (PHP, HTML, CSS, JS, MYSQL)
Introduction
This application displays football team data from a database in an HTML table, allowing users to generate reports on selected teams. The reports include team information, a pie chart of match statistics, and a bar chart comparing multiple teams. The application is secured with a login system to ensure only authorized users can access its features.

Features
JSON Schema
JSON schema (Leagueschema.json) to validate League.json.
Ensured realistic data types and restrictions for each data element.

JavaScript and HTML

League.html: Displays the Premier League Teams Table.
Topscorers.html: Displays the Premier League Top Scorers table.
Automatically update data at realistic intervals using setTimeout.

Ensured no delay in loading data when the page first opened - AJAX.
Formated HTML professionally using CSS.

Included icons for each reported game/match, reflecting wins (green icons) and losses (blue icons) in the last six games.
Used JavaScript to calculate total points based on wins (3 points) and draws (1 point).

# Task 2: Generate Teams Performance Report
Display Teams Data
Display all football teams data stored in the database in an HTML table.
Order the table in ascending order based on current points.
Each row contains a checkbox for selecting the team for the report.
The first cell in the table header contains a checkbox to select/deselect all teams.

# Generate Report

On clicking the "Generate Report" button, a report page is displayed with:
A table showing selected football teams' information.
A pie chart using Chart.js, showing percentages of matches played (wins, losses, draws, and remaining games).
A bar chart comparing selected teams if more than one team is selected.

# Secure Application
A login page allows authorized users to enter their username and password to access the application features.
