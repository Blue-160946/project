<?php
session_start();  // เริ่ม session

// ตรวจสอบว่าผู้ใช้ได้ล็อกอินแล้วหรือยัง
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $_SESSION['user_role'] = 'admin';
    
} else {
    header("Location: login.php");
    exit();
}
// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$db_username = "root";
$password = "12345678";
$dbname = "webdatabase";

$conn = new mysqli($servername, $db_username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// เพิ่มสินค้า
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    
    // จัดการการอัปโหลดไฟล์ภาพ
    $image_url = 'default_image.png'; // ค่าเริ่มต้น
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/"; // โฟลเดอร์สำหรับเก็บภาพ
        $image_url = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $image_url);
    }

    $sql = "INSERT INTO all_products (product_name, category, price, quantity_in_stock, image_url)
            VALUES ('$product_name', '$category', $price, $quantity, '$image_url')";

    if ($conn->query($sql) === TRUE) {
        echo "New product added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// ลบสินค้า
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_product'])) {
    $product_id = $_POST['product_id'];

    $sql = "DELETE FROM all_products WHERE product_id = $product_id";

    if ($conn->query($sql) === TRUE) {
        echo "Product removed successfully.";
    } else {
        echo "Error: " . $conn->error;
    }
}

// แก้ไขสินค้า
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_product'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // จัดการการอัปโหลดไฟล์ภาพ
    $image_url = $_POST['current_image']; // ใช้ URL ปัจจุบันเป็นค่าเริ่มต้น
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/"; // โฟลเดอร์สำหรับเก็บภาพ
        $image_url = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $image_url);
    }

    $sql = "UPDATE all_products SET 
            product_name='$product_name', 
            category='$category', 
            price=$price, 
            quantity_in_stock=$quantity,
            image_url='$image_url' 
            WHERE product_id=$product_id";

    if ($conn->query($sql) === TRUE) {
        echo "Product updated successfully.";
    } else {
        echo "Error: " . $conn->error;
    }
}

// ฟังก์ชันสำหรับดึงข้อมูลสินค้าสำหรับการแก้ไข
$product_to_edit = null;
if (isset($_GET['edit_id'])) {
    $product_id = $_GET['edit_id'];
    $sql = "SELECT * FROM all_products WHERE product_id = $product_id";
    $result = $conn->query($sql);
    $product_to_edit = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Admin Orders - ka_jang_handmade</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700;900&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Mali:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">


    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>

<!-- Topbar Start -->
<div class="container-fluid bg-light p-0">
        <div class="row gx-0 d-none d-lg-flex">
            <div class="col-lg-7 px-5 text-start">
                <div class="h-100 d-inline-flex align-items-center py-3 me-4">
                    <small class="fa-solid fa-shop text-primary me-2"></small>
                    <small>KAJANG🧶</small>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0">
        <a href="Admin_dashboard.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <img src="img/logo-1.png" width="200px">
        </a>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="Admin_dashboard.php" class="nav-item nav-link"><i class="fa-solid fa-house me-2"></i>Home</a>
                <a href="stock.php" class="nav-item nav-link active"><i class="fa-solid fa-list me-2"></i>Stock</a>
                <a class="nav-item nav-link"><i class="bi bi-person-check-fill"></i> <?php echo htmlspecialchars($username); ?> </a>
                <a href="Logout.php" class="nav-item nav-link"><i class="bi bi-box-arrow-right"></i> Logout</a>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5">
        <div class="container py-5">
            <a href="stock.php">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Stock Management</h1>
            </a>
        </div>
    </div>
    <!-- Page Header End -->
    
    <div class="container mt-5">
    <h2 class="mb-4">Add Product</h2>
    <form action="" method="POST" enctype="multipart/form-data" class="mb-5">
        <div class="mb-3">
            <label for="product_name" class="form-label">Product Name:</label>
            <input type="text" id="product_name" name="product_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category:</label>
            <input type="text" id="category" name="category" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price:</label>
            <input type="number" id="price" name="price" class="form-control" step="0.01" required>
        </div>
        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity:</label>
            <input type="number" id="quantity" name="quantity" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image:</label>
            <input type="file" id="image" name="image" class="form-control" accept="image/*">
        </div>
        <button type="submit" name="add_product" class="btn btn-success">Add Product</button>
    </form>

    <h2 class="mb-4">Remove Product</h2>
    <form action="" method="POST" class="mb-5">
        <div class="mb-3">
            <label for="product_id_remove" class="form-label">Product ID:</label>
            <input type="number" id="product_id_remove" name="product_id" class="form-control" required>
        </div>
        <button type="submit" name="remove_product" class="btn btn-danger">Remove Product</button>
    </form>

    <h2 class="mb-4">Edit Product</h2>
    <?php if ($product_to_edit): ?>
    <form action="" method="POST" enctype="multipart/form-data" class="mb-5">
        <input type="hidden" name="product_id" value="<?php echo $product_to_edit['product_id']; ?>">
        <input type="hidden" name="current_image" value="<?php echo $product_to_edit['image_url']; ?>">
        <div class="mb-3">
            <label for="edit_product_name" class="form-label">Product Name:</label>
            <input type="text" id="edit_product_name" name="product_name" class="form-control" value="<?php echo $product_to_edit['product_name']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="edit_category" class="form-label">Category:</label>
            <input type="text" id="edit_category" name="category" class="form-control" value="<?php echo $product_to_edit['category']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="edit_price" class="form-label">Price:</label>
            <input type="number" id="edit_price" name="price" class="form-control" step="0.01" value="<?php echo $product_to_edit['price']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="edit_quantity" class="form-label">Quantity:</label>
            <input type="number" id="edit_quantity" name="quantity" class="form-control" value="<?php echo $product_to_edit['quantity_in_stock']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="edit_image" class="form-label">Image:</label>
            <input type="file" id="edit_image" name="image" class="form-control" accept="image/*">
        </div>
        <button type="submit" name="edit_product" class="btn btn-primary">Update Product</button>
    </form>
    <?php else: ?>
    <form action="" method="GET" class="mb-5">
        <div class="mb-3">
            <label for="edit_id" class="form-label">Product ID:</label>
            <input type="number" id="edit_id" name="edit_id" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-warning">Edit Product</button>
    </form>
    <?php endif; ?>
</div>
    
<div class="container mt-5">
    <h2 class="mb-4">Current Stock</h2>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Fetch and display products
        $sql = "SELECT * FROM all_products";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['product_id']}</td>
                        <td>{$row['product_name']}</td>
                        <td>{$row['category']}</td>
                        <td>{$row['price']}</td>
                        <td>{$row['quantity_in_stock']}</td>
                        <td><img src='{$row['image_url']}' alt='{$row['product_name']}' style='width: 50px;'></td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No products found</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>

    
    <!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="lib/wow/wow.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>
<script src="lib/counterup/counterup.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="lib/isotope/isotope.pkgd.min.js"></script>
<script src="lib/lightbox/js/lightbox.min.js"></script>

<!-- Template Javascript -->
<script src="js/main.js"></script>
</body>
</html>
