<?php
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "tienda";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create Product
if (isset($_POST['create'])) {
    $producto = $_POST['producto'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];

    $stmt = $conn->prepare("INSERT INTO productos (producto, precio, descripcion) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $producto, $precio, $descripcion);
    $stmt->execute();
    $stmt->close();
}

// Read Products
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Abarrotes</title>
</head>
<body>

    <h2>Productos en la Tienda</h2>

    <!-- Create Product Form -->
    <form method="post" action="">
        <label for="producto">Producto:</label>
        <input type="text" name="producto" required>
        <label for="precio">Precio:</label>
        <input type="number" name="precio" step="0.01" required>
        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" required></textarea>
        <button type="submit" name="create">Agregar Producto</button>
    </form>

    <!-- Display Products -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Producto</th>
            <th>Precio</th>
            <th>Descripción</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['producto']}</td>";
            echo "<td>{$row['precio']}</td>";
            echo "<td>{$row['descripcion']}</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <?php
    $conn->close();
    ?>
</body>
</html>