<?php
    try {
        $con = new PDO("mysql:host=sql202.infinityfree.com;dbname=if0_37638191_dbvoltmart ", "if0_37638191", "nBvECic0QQAJ4i");

        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //echo "Connected successfully"; // Pesan koneksi berhasil (opsional)
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit();
    }
?>
