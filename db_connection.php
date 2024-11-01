<?php
    /*
        $host = 'localhost'; // Assuming XAMPP, so localhost
        $dbname = 'voltmart'; // Your database name
        $username = 'root'; // Default XAMPP username
        $password = ''; // Default XAMPP password is empty 
    */
    $con = mysqli_connect("localhost", "root", "", "databasetestingraihan");

    if (mysqli_connect_errno()) {
        echo "Gagal konek ke database: " . mysqli_connect_error();
        exit();
    }
    /*
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
} */
?>
