<?php
// SSH tunnel connection credentials
$sshHost = '';
$sshPort = 22;
$sshUsername = '';
$privateKeyPath = ''; // Path to private key file

// Database connection credentials
$databaseHost = ''; // Localhost since we're using SSH tunneling
$databasePort = 3306; // Local port that you have set up for database access
$databaseName = 'hapi';
$databaseUsername = '';
$databasePassword = '';

// Establish an SSH connection with key-based authentication
$sshConnection = ssh2_connect($sshHost, $sshPort);
if (ssh2_auth_pubkey_file($sshConnection, $sshUsername, $publicKeyPath, $privateKeyPath, $passphrase) === false) {
    die('SSH authentication failed.');
}

// Create a port forwarding (SSH tunnel)
$databasePortForwarded = ssh2_tunnel($sshConnection, $databaseHost, $databasePort);
if ($databasePortForwarded === false) {
    die('SSH tunneling failed.');
}

// Establish a connection to the database through the SSH tunnel
$databaseConnection = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName, $databasePortForwarded);
if ($databaseConnection === false) {
    die('Database connection failed: ' . mysqli_connect_error());
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the maturity level and maturity score from the request
    $maturityLevel = $_POST["maturityLevel1"];
    $maturityScore = $_POST["maturityScore1"];
    $LOB = $_POST["LOB"];


    // Prepare the SQL query to insert data into the table
    $sql = "INSERT INTO Maturity (LOB, maturityLevel, maturityScore) VALUES ('$LOB', '$maturityLevel', $maturityScore);";

    // Execute the query
    if (mysqli_query($databaseConnection, $sql)) {
        echo "Data inserted successfully.";
    } else {
        echo "Error inserting data: " . mysqli_error($databaseConnection);
    }
}

// Close the database connection
mysqli_close($databaseConnection);
?>
