<?php
    
        $host = 'sql202.infinityfree.com'; 
        $dbname = 'if0_37638191_dbvoltmart'; 
        $username = 'if0_37638191'; 
        $password = 'nBvECic0QQAJ4i'; 
    
    $con = mysqli_connect($host, $username, $password, $dbname);

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
