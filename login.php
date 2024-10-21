<?php
// Include the database connection file
require_once 'db_connection.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    // Check if fields are empty
    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        // Fetch the user data by email
        $stmt = $conn->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Password is correct, start a session for the user
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Redirect to homepage or dashboard
            header('Location: index.html');
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    }
}
?>

<!-- Error display -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Error</title>
</head>
<body>
    <?php if ($error): ?>
        <p style="color:red;"><?php echo $error; ?></p>
        <a href="login.html">Back to Login</a>
    <?php endif; ?>
</body>
</html>
