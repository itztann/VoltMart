<?php
// Include the database connection
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = htmlspecialchars($_POST['email']);

    // Check if the email exists in the database
    $stmt = $con->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Generate a unique reset token
        $reset_token = bin2hex(random_bytes(32));

        // Store the reset token in the database
        $stmt = $con->prepare('UPDATE users SET reset_token = :reset_token WHERE email = :email');
        $stmt->bindParam(':reset_token', $reset_token);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Send an email with the reset link (for now, just display the link on the page)
        $reset_link = "http://localhost/VoltMart/resetPassword.php?token=$reset_token";
        echo "A password reset link has been sent to your email. <a href='$reset_link'>Reset Password</a>";
        // In a real-world application, use mail() function or other email services to send the link to user's email.
    } else {
        echo "No account found with that email.";
    }
}
?>
