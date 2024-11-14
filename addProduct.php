<?php
require_once 'session.php';
require 'db_connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

if (empty($_SESSION['csrfToken'])) {
    $_SESSION['csrfToken'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrfToken']) || $_POST['csrfToken'] !== $_SESSION['csrfToken']) {
        echo "<script>alert('Invalid CSRF token!');</script>";
        exit();
    }

    $name = trim($_POST['name']);
    $price = trim($_POST['price']);
    $detail = trim($_POST['detail']);
    $stock = trim($_POST['stock']);
    $picture = '';

    $stmt = $con->prepare("SELECT * FROM products WHERE name = :name");
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $error = 'Product name already exists. Please choose a different name.';
    } else {
        if (isset($_FILES['picture']) && $_FILES['picture']['error'] == 0) {
            $target_dir = "uploads/products/";
            $target_file = $target_dir . basename($_FILES["picture"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $allowedTypes = ['jpg', 'jpeg', 'png'];
            
            if (!in_array($imageFileType, $allowedTypes)) {
                $error = "Only JPG, JPEG, & PNG files are allowed.";
            } else {
                if ($newPhoto["size"] > 10 * 1024 * 1024) {
                    echo "<script>alert('File is too large. Maximum size is 10MB.');</script>";
                    exit();
                }
                
                if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
                    $picture = $target_file;
                } else {
                    $error = "There was an error uploading your file.";
                }
            }
        }

        if (empty($error)) {
            $stmt = $con->prepare("INSERT INTO products (name, price, detail, picture, stock) VALUES (:name, :price, :detail, :picture, :stock)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':detail', $detail);
            $stmt->bindParam(':picture', $picture);
            $stmt->bindParam(':stock', $stock);
            
            if ($stmt->execute()) {
                $success = 'Product added successfully!';
            } else {
                $error = 'An error occurred while adding the product.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
    <link rel="stylesheet" href="addProductStyles.css">
</head>
<body>
    <div class="form-container">
        <h2>Add New Product</h2>
        
        <?php if (!empty($error)) { echo "<p class='error'>$error</p>"; } ?>
        <?php if (!empty($success)) { echo "<p class='success'>$success</p>"; } ?>

        <form action="addProduct.php" method="POST" enctype="multipart/form-data">
            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" required>

            <label for="detail">Product Detail:</label>
            <textarea id="detail" name="detail" required></textarea>

            <label for="picture">Product Image:</label>
            <input type="file" id="picture" name="picture" accept="image/*">

            <label for="stock">Stock:</label>
            <input type="number" id="stock" name="stock" required>

            <input type="hidden" name="csrfToken" value="<?php echo $_SESSION['csrfToken']; ?>">

            <button type="submit">Add Product</button>
        </form>

        <a href="products.php" class="back-link">Back to Products</a>
    </div>
</body>
</html>