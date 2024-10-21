<?php
// Include the database connection file
require_once 'db_connection.php';

// Initialize variables to store error messages
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get data from the form and sanitize it
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    // Check if fields are empty
    if (empty($username) || empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        // Check if the username or email already exists
        $stmt = $conn->prepare('SELECT * FROM users WHERE email = :email OR username = :username');
        $stmt->execute(['email' => $email, 'username' => $username]);
        if ($stmt->rowCount() > 0) {
            $error = "Username or email already exists.";
        } else {
            // Hash the password before storing it
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Insert user data into the database
            $stmt = $conn->prepare('INSERT INTO users (username, email, password) VALUES (:username, :email, :password)');
            $stmt->execute(['username' => $username, 'email' => $email, 'password' => $hashed_password]);

            // Redirect to login page after successful registration
            header('Location: login.html');
            exit;
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
    <title>Register Error</title>
</head>
<body>
    <?php if ($error): ?>
        <p style="color:red;"><?php echo $error; ?></p>
        <a href="register.html">Back to Registration</a>
    <?php endif; ?>
</body>
</html>
