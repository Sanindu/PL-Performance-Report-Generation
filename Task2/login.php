<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") { // Checks if the request method is POST
    // Database connection
    $servername = "localhost"; // Server name or IP address
    $username = "root"; // Username for database connection
    $password = ""; // Password for database connection
    $dbname = "league"; // Database name

    $conn = new mysqli($servername, $username, $password, $dbname); // Establishes a new MySQLi connection

    // Check connection
    if ($conn->connect_error) { // Checks if the connection failed
        die("Connection failed: " . $conn->connect_error); // Stops script execution and outputs error message
    }

    // Get user input
    $username = $_POST['username']; // Retrieves username from POST data
    $password = $_POST['password']; // Retrieves password from POST data

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?"); // Prepares SQL query with placeholders
    $stmt->bind_param("ss", $username, $password); // Binds parameters to the prepared statement
    $stmt->execute(); // Executes the prepared statement
    $result = $stmt->get_result(); // Gets the result set from the executed statement

    if ($result->num_rows == 1) { // Checks if there is exactly one row in the result set
        // Login successful, send "success"
        echo "success"; // Outputs "success" indicating successful login
    } else {
        // Invalid credentials, send "error"
        echo "error"; // Outputs "error" indicating invalid credentials
    }

    $stmt->close(); // Closes the prepared statement
    $conn->close(); // Closes the database connection
}
// References:
//PHP Manual. (n.d.). Prepared Statements. Retrieved from https://www.php.net/manual/en/mysqli.quickstart.prepared-statements.php
//PHP Manual. (n.d.). MySQLi. Retrieved from https://www.php.net/manual/en/book.mysqli.php
?>