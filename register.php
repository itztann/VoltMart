<?php
require_once 'db_connection.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="registerStyle.css">
</head>
<body>
    <form action="register.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" placeholder="Username" required><br><br> 

        <label for="password">Password:</label>
        <input type="password" name="password" placeholder="Password" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" placeholder="Please use your real life email (for forgot password)" required><br><br>

        <button type="submit" name="registerButton">Register</button>
        <button type="button" class="loginButton" onclick="location.href='login.php'">Already have an account? Login here</button>
    </form>

    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Mengambil input dan memastikan tidak ada karakter berbahaya
            $username = htmlspecialchars($_POST['username']);
            $password = $_POST['password'];
            $email = htmlspecialchars($_POST['email']);

            if (empty($username) || empty($password) || empty($email)) {
                echo "Username, password, dan email harus diisi!";
            } else {
                // Mengecek apakah username atau email sudah terdaftar
                $stmt = $con->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                $countdata = $stmt->rowCount();

                if ($countdata > 0) {
                    echo "Username or email already registered!";
                } else {
                    // Hashing password menggunakan password_hash
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // Menyimpan data pengguna baru
                    $query = $con->prepare("INSERT INTO users (username, passwords, email) VALUES (:username, :password, :email)");
                    $query->bindParam(':username', $username);
                    $query->bindParam(':password', $hashed_password);
                    $query->bindParam(':email', $email);

                    if ($query->execute()) {
                        echo "Pendaftaran berhasil! Silakan login.";
                        header('Location: login.php');
                        exit();
                    } else {
                        echo "Terjadi kesalahan, coba lagi.";
                    }
                }
            }
        }
    ?>
</body>
</html>
