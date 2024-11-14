<?php
    try {
        $con = new PDO("mysql:host=localhost;dbname=dbvoltmart", "root", "");

        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit();
    }
?>
