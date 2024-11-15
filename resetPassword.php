<?php
    require_once 'db_connection.php';
    session_set_cookie_params([
        'lifetime' => 0, 
        'secure' => true, 
        'httponly' => true, 
        'samesite' => 'Strict', 
    ]);
    session_start();
?>

<link rel="stylesheet" href="resetPasswordStyles.css">

<?php

if (isset($_GET['token'])) {
    $token = htmlspecialchars($_GET['token']);
    
    $currentTime = time();  

    $stmt = $con->prepare("SELECT * FROM users WHERE resetToken = :token AND resetTokenExpired > :current_time");
    $stmt->bindParam(':token', $token);
    $stmt->bindParam(':current_time', $currentTime); 
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $newPassword = $_POST['newPassword'];
            $confirmPassword = $_POST['confirmPassword'];

            if (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/", $newPassword)) {
                echo "<script>alert('Password must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, one number, and one special character.');</script>";
            } elseif ($newPassword !== $confirmPassword) {
                echo "<script>alert('Password doesn't match! Like you and your crush');</script>";
            } else {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                $stmt = $con->prepare("UPDATE users SET passwords = :password, resetToken = NULL, resetTokenExpired = NULL WHERE resetToken = :token");
                $stmt->bindParam(':password', $hashedPassword);
                $stmt->bindParam(':token', $token);
                if ($stmt->execute()) {
                    echo "Password reset successful! You can now <a href='login.php'> login </a> with your new password"; 
                } else {
                    echo "Error resetting password. Please try again.";
                }
            }
        } else {
            echo "
            <form action='' method='POST'>
                <label>Your token is active for 1 minute!<br><br>New Password:</label><br>
                <input type='password' name='newPassword' placeholder='Enter new password' required><br><br>
                <label>Confirm New Password:</label><br>
                <input type='password' name='confirmPassword' placeholder='Confirm new password' required><br><br>
                <button type='submit'>Reset Password</button>
            </form>";
        }
    } else {
        echo "I think your token is expired like a bread. Please go back to <a href='forgotPassword.php'>Forgot Password</a>";
    }   
} else {
    echo "No token no reset!";
}
?>