<?php
require_once 'session.php';
require_once 'db_connection.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];

$stmt = $con->prepare("SELECT * FROM users WHERE username = :username");
$stmt->bindParam(':username', $username, PDO::PARAM_STR);
$stmt->execute();
$userData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$userData) {
    echo "User not found!";
    exit();
}

if (isset($_POST['confirmEdit'])) {
    $newName = htmlspecialchars($_POST['name']);
    $newPhoto = $_FILES['photo'];  

    if ($newPhoto['name']) {
        $targetDir = "uploads/profile_pictures/";  
        $targetFile = $targetDir . basename($newPhoto["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $validExtensions)) {
            echo "<script>alert('Only JPG, JPEG, PNG & GIF files are allowed.');</script>";
            exit();
        }

        if ($newPhoto["size"] > 2 * 1024 * 1024) {  // 2MB
            echo "<script>alert('File is too large. Maximum size is 2MB.');</script>";
            exit();
        }

        if (move_uploaded_file($newPhoto["tmp_name"], $targetFile)) {
            echo "<script>alert('File uploaded successfully.');</script>";
            $photoPath = $targetFile;  
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
            exit();
        }
    } else {
        $photoPath = $userData['picture'];  
    }

    $updateStmt = $con->prepare("UPDATE users SET username = :username, picture = :picture WHERE username = :currentUsername");
    $updateStmt->bindParam(':username', $newName, PDO::PARAM_STR);
    $updateStmt->bindParam(':picture', $photoPath, PDO::PARAM_STR);
    $updateStmt->bindParam(':currentUsername', $username, PDO::PARAM_STR);
    $updateStmt->execute();

    if ($updateStmt->rowCount() > 0) {
        echo "<script>alert('Profile updated successfully!'); window.location.href='profile.php';</script>";
    } else {
        echo "<script>alert('Error updating profile.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="editProfileStyles.css">
</head>
<body>
<div class="container">
    <div class="old-data">
        <h2>Old Data</h2>
        <p><strong>Username: </strong> <?php echo htmlspecialchars($userData['username']); ?></p>
        <p><strong>Profile Picture: </strong></p>
        <img src="<?php echo htmlspecialchars($userData['picture']); ?>" alt="Profile Picture" width="100">
    </div>

    <form action="" method="POST" class="edit-form" enctype="multipart/form-data">
        <h2>Edit Data</h2>
        <label for="name">Username:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($userData['username']); ?>">

        <label for="photo">Profile Picture:</label>
        <input type="file" id="photo" name="photo" accept="image/*">

        <label for="password">Password:</label>
        <a href="resetPassword.php">Change Password</a>

        <button type="submit" name="confirmEdit">Confirm Edit</button>
    </form>
</div>

<div class="backButtonContainer">
    <a href="profile.php" class="backButton">Cancel</a>
</div>

</body>
</html>