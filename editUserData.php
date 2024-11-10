<?php
require_once 'session.php';
require_once 'db_connection.php';

// Pastikan hanya admin yang bisa mengakses halaman ini
if ($_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

// Ambil semua data user dari tabel "users"
$stmt = $con->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Proses pengeditan data user
if (isset($_POST['editUser'])) {
    $userId = $_POST['user_id'];
    $newUsername = htmlspecialchars($_POST['username']);
    $newRole = htmlspecialchars($_POST['role']);
    $newBalance = htmlspecialchars($_POST['balance']);

    $updateStmt = $con->prepare("UPDATE users SET username = :username, role = :role, balance = :balance WHERE id = :id");
    $updateStmt->bindParam(':username', $newUsername, PDO::PARAM_STR);
    $updateStmt->bindParam(':role', $newRole, PDO::PARAM_STR);
    $updateStmt->bindParam(':balance', $newBalance, PDO::PARAM_INT);
    $updateStmt->bindParam(':id', $userId, PDO::PARAM_INT);

    if ($updateStmt->execute()) {
        echo "<script>alert('User data updated successfully!'); window.location.href='editUserData.php';</script>";
    } else {
        echo "<script>alert('Error updating user data.');</script>";
    }
}

// Proses penghapusan user
if (isset($_POST['deleteUser'])) {
    $userId = $_POST['user_id'];

    $deleteStmt = $con->prepare("DELETE FROM users WHERE id = :id");
    $deleteStmt->bindParam(':id', $userId, PDO::PARAM_INT);

    if ($deleteStmt->execute()) {
        echo "<script>alert('User deleted successfully!'); window.location.href='editUserData.php';</script>";
    } else {
        echo "<script>alert('Error deleting user.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User Data</title>
    <link rel="stylesheet" href="editUserDataStyles.css">
</head>
<body>
    <h2>Edit User Data</h2>
    <div class="container">

    <table border="1">
        <thead>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Balance</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <form method="POST" action="">
                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['id']); ?>">
                    <td><input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>"></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td>
                        <select name="role">
                            <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>User</option>
                            <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                        </select>
                    </td>
                    <td><input type="number" name="balance" value="<?php echo htmlspecialchars($user['balance']); ?>"></td>
                    <td>
                        <button type="submit" name="editUser">Confirm edit</button>
                        <button type="submit" name="deleteUser" onclick="return confirm('Are you sure you want to delete this user?')">Delete account</button>
                    </td>
                </form>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>

    <div class="backButtonContainer">
        <a href="profile.php" class="backButton">Cancel</a>
    </div>
</body>
</html>