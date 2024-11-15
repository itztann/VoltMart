<?php
    session_set_cookie_params([
        'lifetime' => 0, 
        'secure' => true, 
        'httponly' => true, 
        'samesite' => 'Strict', 
    ]);
    
    require_once 'session.php';
    require 'db_connection.php';

    if (empty($_SESSION['csrfToken'])) {
        $_SESSION['csrfToken'] = bin2hex(random_bytes(32));
    }

    if ($_SESSION['role'] !== 'admin') {
        header('Location: index.php');
        exit();
    }

    if (isset($_GET['a']) && is_numeric($_GET['a'])) {
        $id = $_GET['a'];
    } else {
        header('Location: products.php');
        exit();
    }

    $stmt = $con->prepare("SELECT * FROM products WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        header('Location: products.php');
        exit();
    }

    if (isset($_POST['deleteProduct'])) {
        if (!isset($_POST['csrfToken']) || $_POST['csrfToken'] !== $_SESSION['csrfToken']) {
            echo "<script>alert('Invalid CSRF token!');</script>";
            exit();
        }

        $deleteStmt = $con->prepare("DELETE FROM products WHERE id = :id");
        $deleteStmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($deleteStmt->execute()) {
            echo "<script>alert('Product deleted successfully!'); window.location.href='products.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error deleting product.');</script>";
        }
    }

    if (isset($_POST['confirmEdit'])) {
        if (!isset($_POST['csrfToken']) || $_POST['csrfToken'] !== $_SESSION['csrfToken']) {
            echo "<script>alert('Invalid CSRF token!');</script>";
            exit();
        }
        
        $newName = htmlspecialchars($_POST['name']);
        $newPrice = htmlspecialchars($_POST['price']);
        $newDetail = htmlspecialchars($_POST['detail']);
        $newStock = htmlspecialchars($_POST['stock']);

        $newPicture = $data['picture']; 

        if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['picture']['tmp_name'];
            $fileName = $_FILES['picture']['name'];
            $fileSize = $_FILES['picture']['size'];
            $fileType = $_FILES['picture']['type'];

            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            $maxFileSize = 10 * 1024 * 1024; 

            if (!in_array($fileType, $allowedTypes)) {
                echo "<script>alert('Only JPG, or PNG images are allowed.');</script>";
                exit();
            }

            if ($fileSize > $maxFileSize) {
                echo "<script>alert('File size should not exceed 10MB.');</script>";
                exit();
            }

            $uploadDir = 'uploads/products/';
            $newFileName = uniqid('product_', true) . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
            $uploadPath = $uploadDir . $newFileName;

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            if (move_uploaded_file($fileTmpPath, $uploadPath)) {
                $newPicture = $newFileName; 
            } else {
                echo "<script>alert('Error uploading the file.');</script>";
                exit();
            }
        }

        $updateStmt = $con->prepare("UPDATE products SET name = :name, price = :price, detail = :detail, stock = :stock, picture = :picture WHERE id = :id");
        $updateStmt->bindParam(':name', $newName, PDO::PARAM_STR);
        $updateStmt->bindParam(':price', $newPrice, PDO::PARAM_INT);
        $updateStmt->bindParam(':detail', $newDetail, PDO::PARAM_STR);
        $updateStmt->bindParam(':stock', $newStock, PDO::PARAM_INT);
        $updateStmt->bindParam(':picture', $newPicture, PDO::PARAM_STR);
        $updateStmt->bindParam(':id', $id, PDO::PARAM_INT);

        session_regenerate_id(true);
        if ($updateStmt->execute()) {
            echo "<script>alert('Product updated successfully!'); window.location.href='products.php';</script>";
        } else {
            echo "<script>alert('Error updating product.');</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="editProductsStyle.css">
    <title>Edit Product</title>
</head>
<body>
<div class="container">
        <div class="old-data">
            <h2>Old Data</h2>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($data['name']); ?></p>
            <p><strong>Price:</strong> Rp<?php echo number_format($data['price'], 0, ',', '.'); ?></p>
            <p><strong>Detail:</strong> <?php echo htmlspecialchars($data['detail']); ?></p>
            <p><strong>Stock:</strong> <?php echo $data['stock']; ?></p>

            <form method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                <button type="submit" name="deleteProduct" class="delete-button">Delete Product</button>
            </form>
        </div>

        <form action="" method="POST" class="edit-form" enctype="multipart/form-data">
            <h2>Edit Data</h2>
            <label for="name">Product Name</label>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($data['name']); ?>" required>

            <label for="price">Price</label>
            <input type="number" name="price" id="price" value="<?php echo htmlspecialchars($data['price']); ?>" required>

            <label for="detail">Detail</label>
            <input type="text" name="detail" id="detail" value="<?php echo htmlspecialchars($data['detail']); ?>" required>

            <label for="stock">Stock</label>
            <input type="number" name="stock" id="stock" value="<?php echo htmlspecialchars($data['stock']); ?>" required>

            <label for="picture">Product Picture</label>
            <input type="file" name="picture" id="picture" accept="image/*">

            <input type="hidden" name="csrfToken" value="<?php echo $_SESSION['csrfToken']; ?>">

            <button type="submit" name="confirmEdit">Confirm Edit</button>
        </form>
    </div>
<div class="backButtonContainer">
    <a href="products.php" class="backButton">Cancel</a>
</div>

</body>
</html>