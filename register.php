<?php
require_once 'db_connection.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $email = htmlspecialchars($_POST['email']);

    if (empty($username) || empty($password) || empty($email)) {
        echo "Username, email, and password must be filled!";
    } else {
        // Check if the username or email already exists
        $query = $con->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $query->bind_param("ss", $username, $email);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            echo "Username or email already registered!";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Insert the new user into the database
            $query = $con->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
            $query->bind_param("sss", $username, $hashed_password, $email);

            if ($query->execute()) {
                echo "Registration successful! Redirecting to login page...";
                header("refresh:3;url=login.php"); // Redirect to login after 3 seconds
                exit();
            } else {
                echo "An error occurred, please try again.";
            }
        }
    }
}
?>
