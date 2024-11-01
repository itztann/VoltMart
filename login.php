<?php
// Include the database connection file
    session_start();
    require 'db_connection.php';



    
    /*
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
    */
?>

<!-- Error display -->
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
        
            if(isset($_POST['loginButton'])) {
                $username = htmlspecialchars($_POST['username']);
                $password = htmlspecialchars($_POST['password']); 
                
                $hashed_password = hash('sha256', $password);

                $query = mysqli_query($con, "SELECT * FROM users WHERE username='$username' OR email='$username'");
                $countdata = mysqli_num_rows($query);
                $data = mysqli_fetch_array($query);
                
                if($countdata > 0) {
                    if(($hashed_password === $data['passwords'])) {
                        $_SESSION['username'] = $data['username'];
                        $_SESSION['login'] = true;
                        $_SESSION['role'] = $data['role'];
                        header('location: index.php');
                    }  
                    else {
                       echo "Your username or your password or maybe your life is wrong!";
                    
                    }
                } 
                else {
                    echo "Your username or your password or maybe your life is wrong!";
                }
            }    
        ?>
</body>

</html>