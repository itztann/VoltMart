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

<link rel="stylesheet" href="forgotPasswordStyle.css">

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usernameOrEmail = htmlspecialchars($_POST['usernameOrEmail']);
    $answer = isset($_POST['answer']) ? htmlspecialchars($_POST['answer']) : null;
    $step = isset($_POST['step']) ? $_POST['step'] : 'initial';

    if ($step == 'initial') {
        $stmt = $con->prepare("SELECT * FROM users WHERE username = :input OR email = :input");
        $stmt->bindParam(':input', $usernameOrEmail);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user) {
            if (!empty($user['securityQuestion']) && !empty($user['securityAnswer'])) {
                $securityQuestion = $user['securityQuestion'];
                echo "
                <form action='' method='POST'>
                    <label>{$securityQuestion}</label><br>
                    <input type='text' name='answer' placeholder='Answer (this is case sensitive)' required><br><br>
                    <input type='hidden' name='usernameOrEmail' value='{$usernameOrEmail}'>
                    <input type='hidden' name='step' value='verify'>
                    <button type='submit'>Submit Answer</button>
                    <p><a href='login.php' class='cancel-btn'>Just remember password?</a><p>
                </form>";
            } else {
                echo "<script>alert('This account doesn't have a security question set');</script>";
                echo "This account doesn't have a security question set";
            }
        } else {
            echo "<script>alert('Username or email not found!');</script>";
        }
    } elseif ($step == 'verify') {
        $stmt = $con->prepare("SELECT * FROM users WHERE (username = :input OR email = :input)");
        $stmt->bindParam(':input', $usernameOrEmail);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user && password_verify($answer, $user['securityAnswer'])) {
            $token = bin2hex(random_bytes(32)); 
            $expiryTime = time() + 60 * 1; 

            $stmt = $con->prepare("UPDATE users SET resetToken = :token, resetTokenExpired = :expiry WHERE username = :username");
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':expiry', $expiryTime);
            $stmt->bindParam(':username', $user['username']);
            
            if ($stmt->execute()) {
                header("Location: resetPassword.php?token=" . urlencode($token));
                exit();
            } else {
                echo "<script>alert('Failed to store reset token in the database');</script>";
            }
        } else {
            echo "<script>alert('Your security answer is wrong or maybe your life is wrong!');</script>";
        }
    }
} else {
    echo "
    <form action='' method='POST'>
        <label>Username or Email:</label><br>
        <input type='text' name='usernameOrEmail' placeholder='Enter Username or Email' required><br><br>
        <button type='submit'>Submit</button>
        <a href='login.php' class='cancel-btn'>Just remember password?</a>
        <input type='hidden' name='step' value='initial'>
    </form>";
}
?>