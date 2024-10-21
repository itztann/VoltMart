<?php
$host = 'localhost'; // Assuming XAMPP, so localhost
$dbname = 'voltmart'; // Your database name
$username = 'root'; // Default XAMPP username
$password = ''; // Default XAMPP password is empty

try {
    // Establishing the connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // If successful, echo a success message (you can remove this later)
    echo "Connected successfully to the database!";
} catch(PDOException $e) {
    // If there's an error, it will be displayed here
    echo "Connection failed: " . $e->getMessage();
}
?>
