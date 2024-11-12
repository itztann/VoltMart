<?php
    require_once 'session.php'; 
    require 'db_connection.php'; 

    $stmt = $con->prepare("SELECT * FROM products");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="productsStyles.css">
</head>
<body>

<div class="top-buttons">
    <div class="backButtonContainer">
        <a href="index.php" class="backButton">Back</a>
    </div>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') { ?>
        <div class="addButtonContainer">
            <a href="addProduct.php" class="addButton">Add New Product</a>
        </div>
    <?php } ?>
</div>

<div class="product-container">
    <?php foreach ($products as $data) { ?>
        <div class="product-card">
            <?php if ($data['picture']): ?>
                <img src="uploads/products/<?php echo htmlspecialchars($data['picture']); ?>" alt="<?php echo htmlspecialchars($data['name']); ?>">
            <?php else: ?>
                <img src="default-image.jpg" alt="No image available">
            <?php endif; ?>

            <p class="product-name"><?php echo htmlspecialchars($data['name']); ?></p>
            <p class="product-price">Rp<?php echo number_format($data['price'], 0, ',', '.'); ?></p>
            <p class="product-detail"><?php echo htmlspecialchars($data['detail']); ?></p>
            <p class="product-stock">Stock: <?php echo htmlspecialchars($data['stock']); ?></p>
        
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') { ?>
                <a href="editProducts.php?a=<?php echo urlencode($data['id']); ?>" class="edit-button">Edit</a>
            <?php } ?>
        </div>
    <?php } ?>
</div>

</body>
</html>