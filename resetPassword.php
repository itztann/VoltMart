<?php
// Include the database connection
require_once 'db_connection.php';

$token = $_GET['token'] ?? '';

if ($token) {
    // Check if the reset token exists in the database
    $stmt = $con->prepare('SELECT * FROM users WHERE reset_token = :reset_token');
    $stmt->execute(['reset_token' => $token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $new_password = htmlspecialchars($_POST['new_password']);
            $confirm_password = htmlspecialchars($_POST['confirm_password']);

            if ($new_password === $confirm_password) {
                // Hash the new password
                $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

                // Update the password in the database and clear the reset token
                $stmt = $con->prepare('UPDATE users SET password = :password, reset_token = NULL WHERE id = :id');
                $stmt->execute(['password' => $hashed_password, 'id' => $user['id']]);

                echo "Password updated successfully! You can now <a href='login.html'>log in</a>.";
            } else {
                echo "Passwords do not match.";
            }
        }
    } else {
        echo "Invalid or expired token.";
    }
} else {
    echo "No token provided.";
}
?>

<!-- HTML Form for Resetting the Password -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="forgotPasswordStyle.css">
</head>
<body>
    <h2>Reset Password</h2>
    <form action="resetPassword.php?token=<?php echo htmlspecialchars($token); ?>" method="POST">
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" required>
        
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" required>
        
        <button type="submit">Update Password</button>
    </form>
</body>
</html>
