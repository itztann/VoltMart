<?php
    /*
        $host = 'localhost'; // Assuming XAMPP, so localhost
        $dbname = 'voltmart'; // Your database name
        $username = 'root'; // Default XAMPP username
        $password = ''; // Default XAMPP password is empty 
    */
    $con = mysqli_connect("localhost", "root", "", "voltmart");

    if (mysqli_connect_errno()) {
        echo "Failed to Connect to database #EnglishBetter: " . mysqli_connect_error();
        exit();
    }
    
    
    try {
        $con = new PDO("mysql:host=localhost;dbname=voltmart", "root", "");
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit();
    }
    
?>
