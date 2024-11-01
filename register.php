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
        <input type="text" name="text" placeholder="Username"required><br><br> 

        <label for="password">Password:</label>
        <input type="password" name="password" placeholder="Password"required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" placeholder="Please use your real life email (for forgot password)"required><br><br>

        <button type="submit">Register</button>
        <button type="button" class="loginButton" onclick="location.href='login.php'">Already have an account? Login here</button>

    </form>
        <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $username = htmlspecialchars($_POST['username']);
                $password = htmlspecialchars($_POST['password']);
                $email = htmlspecialchars($_POST['email']);

                if (empty($username) || empty($password)) {
                    $message = "Email dan password harus diisi!";
                } else {
                    $query = mysqli_query($con, "SELECT * FROM users WHERE username='$username' OR email='$email'");
                    $countdata = mysqli_num_rows($query);

                    if ($countdata > 0) {
                        echo "Username or email already registered!";
                    } else {
                        $hashed_password = hash('sha256', $password);

                        $query = $con->prepare("INSERT INTO users (username, passwords, email) VALUES ('$username', '$hashed_password', '$email')");

                        if ($query->execute()) {
                            $message = "Pendaftaran berhasil! Silakan login.";
                            header('location: login.php');
                        } else {
                            $message = "Terjadi kesalahan, coba lagi.";
                        }
                    }
                }
            }
        ?>
</body>
</html>
