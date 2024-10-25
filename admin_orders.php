<?php
session_start();  // เริ่ม session

// ตรวจสอบว่าผู้ใช้ได้ล็อกอินแล้วหรือยัง
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$db_username = "root";  // เปลี่ยนชื่อตัวแปรเพื่อหลีกเลี่ยงการสับสน
$password = "12345678";
$dbname = "webdatabase";

$conn = new mysqli($servername, $db_username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ดึงข้อมูลจากตาราง cart, all_products และ users โดยใช้ JOIN
$sql = "SELECT cart.id, all_products.product_name, cart.quantity, users.username
        FROM cart 
        JOIN all_products ON cart.product_id = all_products.product_id 
        JOIN users ON cart.user_id = users.id";

$result = $conn->query($sql);  // รัน query

// ปิดการเชื่อมต่อ
$conn->close();
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
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0">
        <a href="Admin_dashboard.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <img src="img/logo-1.png" width="200px">
        </a>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="admin_orders.php" class="nav-item nav-link active"><i class="fa-solid fa-list me-2"></i>Orders</a>
                <a href="Admin_dashboard.php" class="nav-item nav-link"><i class="fa-solid fa-house me-2"></i>Home</a>
                <a href="Logout.php" class="nav-item nav-link"><i class="bi bi-box-arrow-right"></i> Logout</a>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <div class="container mt-5">
        <h2 class="text-center mb-4">รายการสั่งซื้อทั้งหมด</h2>
        <?php if ($result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Order ID</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                                <td><?php echo htmlspecialchars($row['username']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">
                ไม่พบรายการสั่งซื้อ
            </div>
        <?php endif; ?>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
