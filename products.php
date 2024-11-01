<?php
    require_once 'session.php';
    require 'db_connection.php';

    $queryProduct = mysqli_query($con, "SELECT * FROM products");
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
<div class="product-container">
    <?php
        $number = 1;
        while($data = mysqli_fetch_array($queryProduct)) {
    ?>
        <div class="product-card">
            <img src="<?php echo htmlspecialchars($data['picture']); ?>" alt="<?php echo htmlspecialchars($data['name']); ?>">
            <p class="product-name"><?php echo htmlspecialchars($data['name']); ?></p>
            <p class="product-price">Rp<?php echo number_format($data['price'], 0, ',', '.'); ?></p>
            <p class="product-detail"><?php echo htmlspecialchars($data['detail']); ?></p>
            <p class="product-status"><?php echo $data['status']; ?></p>
        </div>
    <?php
        $number++;
        }
    ?>
</div>

</body>
</html>