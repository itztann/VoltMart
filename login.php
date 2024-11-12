<?php
    session_start();
    require 'db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="loginStyle.css">
</head>
<body>
    <form action="login.php" method="POST">
        <label for="username">Username or email:</label>
        <input type="text" name="username" placeholder="Username or email" required><br><br> 

        <label for="password">Password:</label>
        <input type="password" name="password" placeholder="Password" required><br><br>

        <button type="submit" name="loginButton">Login</button>
        <button type="button" class="register-button" onclick="location.href='register.php'">Don't have an account? Register here</button>
        <p><a href="forgotPassword.html">Forgot Password?</a></p>
    </form>

    <?php
        if (isset($_POST['loginButton'])) {
            $username = htmlspecialchars($_POST['username']);
            $password = $_POST['password']; 

            $stmt = $con->prepare("SELECT * FROM users WHERE username = :username OR email = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);

                if (password_verify($password, $data['passwords'])) {
                    $_SESSION['username'] = htmlspecialchars($data['username']);
                    $_SESSION['login'] = true;
                    $_SESSION['role'] = htmlspecialchars($data['role']);
                    $_SESSION['idUser'] = htmlspecialchars($data['id']);
                    header('Location: index.php');
                    exit();
                } else {
                    echo "Your password is wrong!";
                }
            } else {
                echo "Your username or email is wrong!";
            }
        }
    ?>
</body>
</html>
