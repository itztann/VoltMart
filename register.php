<?php
require_once 'db_connection.php'; 

session_start();
if (!isset($_SESSION['csrfToken'])) {
    $_SESSION['csrfToken'] = bin2hex(random_bytes(32));
}
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

        <label for="confirmPassword">Confirm Password:</label>
        <input type="password" name="confirmPassword" placeholder="Confirm Password" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" placeholder="Email" required><br><br>

        <label for="securityQuestion">Your Personal Security Question (Optional):</label>
        <input type="text" name="securityQuestion" placeholder="Example: your first pet's name?"><br><br>

        <label for="securityAnswer">Your Security Answer (Optional):</label>
        <input type="text" name="securityAnswer" placeholder="Please remember the answer"><br><br>

        <input type="hidden" name="csrfToken" value="<?php echo htmlspecialchars($_SESSION['csrfToken'], ENT_QUOTES, 'UTF-8'); ?>">

        <button type="submit" name="registerButton">Register</button>
        <button type="button" class="loginButton" onclick="location.href='login.php'">Already have an account? Login here</button>
    </form>

    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_POST['csrfToken']) || $_POST['csrfToken'] !== $_SESSION['csrfToken']) {
                echo "<script>alert('Invalid CSRF token!');</script>";
                exit();
            }

            $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirmPassword'];
            $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
            $securityQuestion = !empty($_POST['securityQuestion']) ? htmlspecialchars($_POST['securityQuestion'], ENT_QUOTES, 'UTF-8') : null;
            $securityAnswer = !empty($_POST['securityAnswer']) ? password_hash($_POST['securityAnswer'], PASSWORD_DEFAULT) : null;

            if ($password !== $confirmPassword) {
                echo "<script>alert('Passwords do not match!');</script>";
            } elseif (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/", $password)) {
                echo "<script>alert('Password must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, one number, and one special character.');</script>";
            } else {
                $stmt = $con->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                $countdata = $stmt->rowCount();

                if ($countdata > 0) {
                    echo "<script>alert('Username or email already registered!');</script>";
                } else {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $query = $con->prepare("INSERT INTO users (username, passwords, email, securityQuestion, securityAnswer) VALUES (:username, :password, :email, :securityQuestion, :securityAnswer)");
                    $query->bindParam(':username', $username);
                    $query->bindParam(':password', $hashed_password);
                    $query->bindParam(':email', $email);
                    $query->bindParam(':securityQuestion', $securityQuestion);
                    $query->bindParam(':securityAnswer', $securityAnswer);

                    if ($query->execute()) {
                        echo "<script>alert('Account registration successfull');</script>";
                        header('Location: login.php');
                        exit();
                    } else {
                        echo "<script>alert('Error! Please try again!');</script>";
                    }
                }
            }
        }
    ?>
</body>
</html>