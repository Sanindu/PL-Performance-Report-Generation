# Football Teams Performance Report Application

This application displays football team data from a database in a table, allowing users to generate reports on selected teams. The reports include team information, a pie chart of match statistics, and a bar chart comparing multiple teams. The application is secured with a login system to ensure that only authorized users can access its features.

### Login
![](https://github.com/Sanindu/Premier-League-Site/blob/main/login.gif)

### Performance comparison using Chart.js
![](https://github.com/Sanindu/Premier-League-Site/blob/main/view_chart.gif)

### Add New Record
![](https://github.com/Sanindu/Premier-League-Site/blob/main/new_rec.gif)

### Edit Record
![](https://github.com/Sanindu/Premier-League-Site/blob/main/edit_rec.gif)

Features <br />
JSON Schema <br />
JSON schema (Leagueschema.json) to validate League.json. <br />
Ensured realistic data types and restrictions for each data element. <br />

JavaScript and HTML <br />

League.html: Displays the Premier League Teams Table. <br />
Topscorers.html: Displays the Premier League Top Scorers table. <br />
Automatically update data at realistic intervals using setTimeout. <br />

Ensured no delay in loading data when the page first opened - AJAX. <br />
Formated HTML professionally using CSS. <br />

Included icons for each reported game/match, reflecting wins (green icons) and losses (blue icons) in the last six games. <br />
Used JavaScript to calculate total points based on wins (3 points) and draws (1 point). <br />

# Task 2: Generate Teams Performance Report
Display Teams Data <br />
Display all football teams data stored in the database in an HTML table. <br />
Order the table in ascending order based on current points. <br />
Each row contains a checkbox for selecting the team for the report. <br />
The first cell in the table header contains a checkbox to select/deselect all teams.

# Generate Report

On clicking the "Generate Report" button, a report page is displayed with:
A table showing selected football teams' information.
A pie chart using Chart.js, showing percentages of matches played (wins, losses, draws, and remaining games).
A bar chart comparing selected teams if more than one team is selected.

# Secure Application
A login page allows authorized users to enter their username and password to access the application features.

# How to Run

This guide will walk you through setting up and running the project.

## Prerequisites

- A local web server environment like [XAMPP](https://www.apachefriends.org/index.html) or [MAMP](https://www.mamp.info/en/) with PHP and MySQL.
- A web browser to access the project.
- Basic knowledge of navigating your file system using the command line.

## Steps to Run the Project

### 1. Clone the Repository

Clone the repository to your local machine using the following command:

```
git clone https://github.com/Sanindu/PL-Performance-Report-Generation.git
```
### 2. Navigate to the Project Directory
Move into the project directory:

```
cd PL-Performance-Report-Generation
```
### 3. Setup Local Web Server
Ensure you have a local web server environment that supports PHP and MySQL. You can use XAMPP or MAMP.

### 4. Place Project Files in the Web Server Directory
Move the project files to the appropriate web server directory:

For XAMPP, place the project in the htdocs folder (e.g., C:\xampp\htdocs\PL-Performance-Report-Generation).
For MAMP, place the project in the htdocs folder (/Applications/MAMP/htdocs/PL-Performance-Report-Generation).
Example for XAMPP:

```
cp -r PL-Performance-Report-Generation /path/to/xampp/htdocs/PL-Performance-Report-Generation
```
### 5. Import the Database
To set up the database using the included dump.sql file: <br>

Start the Database Server: Use the XAMPP/MAMP control panel to start the MySQL server. <br>

Access phpMyAdmin: Open your web browser and go to: <br>

```
http://localhost/phpmyadmin
```
Create a New Database: In phpMyAdmin, create a new database (e.g., pl_performance_report). Ensure the correct collation (e.g., utf8_general_ci) is set.

Import the SQL File: <br>

With the new database selected, go to the "Import" tab. <br>
Click "Choose File" and select the dump.sql file from the project directory. <br>
Click "Go" to import the database structure and data. <br>

### 6. Start the Web Server
Start the Apache server from the XAMPP/MAMP control panel.

### 7. Access the Project in Your Browser
Open a web browser and navigate to:

```
http://localhost/PL-Performance-Report-Generation
```
