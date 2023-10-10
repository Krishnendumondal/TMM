<?php
// Include the Snowflake SDK
require 'path/to/snowflake/vendor/autoload.php'; // Path to the snowflake-sdk autoload.php file

// Database connection credentials
$account = 'your_account_name';
$username = 'your_username';
$password = 'your_password';
$database = 'your_database_name';
$warehouse = 'your_warehouse_name';
$role = 'your_role_name';
$region = 'your_snowflake_region'; // e.g., 'us-west-2'

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the maturity level, maturity score, and LOB from the request
    $maturityLevel = $_POST["maturityLevel1"];
    $maturityScore = $_POST["maturityScore1"];
    $LOB = $_POST["LOB"];

    // Create a connection to Snowflake
    $connection = snowflake\connect([
        'account' => $account,
        'user' => $username,
        'password' => $password,
        'database' => $database,
        'warehouse' => $warehouse,
        'role' => $role,
        'region' => $region,
    ]);

    // Check if the connection is successful
    if (!$connection) {
        die('Snowflake connection failed.');
    }

    // Prepare the SQL query to insert data into the table
    $sql = "INSERT INTO Maturity (LOB, maturityLevel, maturityScore) VALUES ('$LOB', '$maturityLevel', $maturityScore);";

    // Execute the query
    try {
        $connection->execute($sql);
        echo "Data inserted successfully.";
    } catch (Throwable $e) {
        echo "Error inserting data: " . $e->getMessage();
    }

    // Close the Snowflake connection
    $connection->close();
}
?>
