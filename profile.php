<?php
require_once 'session.php';
require_once 'db_connection.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];
$role = $_SESSION['role']; // Ambil role dari session

$stmt = $con->prepare("SELECT * FROM users WHERE username = :username");
$stmt->bindParam(':username', $username, PDO::PARAM_STR);
$stmt->execute();
$userData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$userData) {
    echo "User not found!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="profileStyles.css">
</head>
<body>
    <div class="profile-container">
        <p class="profile-username">Username: <?php echo htmlspecialchars($userData['username']); ?></p>
        <p class="profile-balance">Saldo: Rp<?php echo number_format($userData['balance'], 0, ',', '.'); ?></p>
        <p class="profile-email">Email: <?php echo htmlspecialchars($userData['email']); ?></p>
        <p class="profile-role">Role: <?php echo ucfirst(htmlspecialchars($userData['role'])); ?></p>

        <?php if (!empty($userData['picture'])): ?>
            <div class="profile-picture">
                <img src="<?php echo htmlspecialchars($userData['picture']); ?>" alt="Profile Picture" class="profile-img">
            </div>
        <?php else: ?>
            <p>No profile picture available.</p>
        <?php endif; ?>

        <a href="editProfile.php" class="editButton">Edit Profile</a>

        <!-- Tombol hanya untuk admin -->
        <?php if ($role === 'admin') { ?>
            <a href="editUserData.php" class="admin-edit-button">Edit all user data</a>
        <?php } ?>
    </div>

    <div class="backButtonContainer">
        <a href="index.php" class="backButton">Back</a>
    </div>
</body>
</html>
