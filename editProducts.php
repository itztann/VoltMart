<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>editProducts</title>
</head>
<body>
    <?php
        if ($_SESSION['role'] !== 'admin') {
            header('Location: index.php'); // Redirect ke halaman akses terlarang
            exit;
        } else {
            echo "Kamu adalah admin";
/*
            // Ambil data produk berdasarkan ID
            $query = "SELECT * FROM products WHERE id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("i", $productId);
            $stmt->execute();
            $result = $stmt->get_result();
            $product = $result->fetch_assoc(); */

            // Proses pengeditan data produk
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name = $_POST['name'];
                $price = $_POST['price'];
                $detail = $_POST['detail'];
                $stock = $_POST['stock'];
                
                // Jika gambar baru diunggah
                if (!empty($_FILES['picture']['name'])) {
                    $targetDir = "uploads/";
                    $picture = $targetDir . basename($_FILES["picture"]["name"]);
                    move_uploaded_file($_FILES["picture"]["tmp_name"], $picture);
                } else {
                    $picture = $product['picture'];
                }

                // Update data produk di database
                $updateQuery = "UPDATE products SET name = ?, price = ?, picture = ?, detail = ?, stock = ? WHERE id = ?";
                $stmt = $con->prepare($updateQuery);
                $stmt->bind_param("sdsssi", $name, $price, $picture, $detail, $stock, $productId);

                if ($stmt->execute()) {
                    echo "Produk berhasil diperbarui.";
                    header("Location: product_list.php"); // Redirect ke halaman daftar produk
                    exit;
                } else {
                    echo "Gagal memperbarui produk.";
                }
            }
        }
        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Produk</title>
        </head>
        <body>
            <h2>Edit Produk</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <label for="name">Nama Produk:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required><br><br>

                <label for="price">Harga:</label>
                <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required step="0.01"><br><br>

                <label for="picture">Gambar:</label>
                <input type="file" id="picture" name="picture"><br>
                <img src="<?php echo htmlspecialchars($product['picture']); ?>" alt="Gambar Produk" width="100"><br><br>

                <label for="detail">Deskripsi Produk:</label>
                <textarea id="detail" name="detail" required><?php echo htmlspecialchars($product['detail']); ?></textarea><br><br>

                <label for="stock">Stok:</label>
                <select id="stock" name="stock" required>
                    <option value="Ada" <?php echo ($product['stock'] == 'Ada') ? 'selected' : ''; ?>>Ada</option>
                    <option value="Habis" <?php echo ($product['stock'] == 'Habis') ? 'selected' : ''; ?>>Habis</option>
                </select><br><br>

                <input type="submit" value="Update Produk">
            </form>
        </body>
        </html>

        
        
    ?>
</body>
</html>