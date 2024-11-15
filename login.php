<?php
session_set_cookie_params([
    'lifetime' => 0, 
    'secure' => true, 
    'httponly' => true, 
    'samesite' => 'Strict', 
]);

session_start();
require 'db_connection.php';

define('MAX_ATTEMPTS', 5);
define('LOCKOUT_TIME', 30);

if (empty($_SESSION['csrfToken'])) {
    $_SESSION['csrfToken'] = bin2hex(random_bytes(32));
}

if (isset($_SESSION['login_attempts']) && $_SESSION['login_attempts'] >= MAX_ATTEMPTS) {
    if (isset($_SESSION['last_attempt_time']) && time() - $_SESSION['last_attempt_time'] < LOCKOUT_TIME) {
        $remainingTime = LOCKOUT_TIME - (time() - $_SESSION['last_attempt_time']);
        echo "<script>alert('You have exceeded the maximum number of login attempts. Please try again in $remainingTime seconds.');</script>";
        exit();
    } else {
        unset($_SESSION['login_attempts']);
        unset($_SESSION['last_attempt_time']);
    }
}
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

        <input type="hidden" name="csrfToken" value="<?php echo $_SESSION['csrfToken']; ?>">

        <button type="submit" name="loginButton">Login</button>
        <button type="button" class="register-button" onclick="location.href='register.php'">Don't have an account? Register here</button>
        <p><a href="forgotPassword.php">Forgot Password?</a></p>
    </form>

    <?php
    if (isset($_POST['loginButton'])) {
        if (!isset($_POST['csrfToken']) || $_POST['csrfToken'] !== $_SESSION['csrfToken']) {
            echo "<script>alert('Invalid CSRF token!');</script>";
            exit();
        }

        $username = htmlspecialchars($_POST['username']);
        $password = $_POST['password']; 

        if (isset($_SESSION['login_attempts']) && $_SESSION['login_attempts'] >= MAX_ATTEMPTS) {
            if (isset($_SESSION['last_attempt_time']) && time() - $_SESSION['last_attempt_time'] < LOCKOUT_TIME) {
                $remainingTime = LOCKOUT_TIME - (time() - $_SESSION['last_attempt_time']);
                echo "<script>alert('You have exceeded the maximum number of login attempts. Please try again in $remainingTime seconds.');</script>";
                exit();
            } else {
                unset($_SESSION['login_attempts']);
                unset($_SESSION['last_attempt_time']);
            }
        }

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
                
                unset($_SESSION['login_attempts']);
                unset($_SESSION['last_attempt_time']);
                session_regenerate_id(true);
                
                header('Location: index.php');
                exit();
            } else {
                if (!isset($_SESSION['login_attempts'])) {
                    $_SESSION['login_attempts'] = 0;
                }
                $_SESSION['login_attempts']++;
                $_SESSION['last_attempt_time'] = time(); 

                echo "<script>alert('Your password is incorrect. You have " . (MAX_ATTEMPTS - $_SESSION['login_attempts']) . " attempts left.');</script>";
            }
        } else {
            echo "<script>alert('Your username or email is incorrect.');</script>";
        }
    }
    ?>
</body>
</html>