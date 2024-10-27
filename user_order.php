<?php
session_start();  // เริ่ม session

// ตรวจสอบว่าผู้ใช้ได้ล็อกอินแล้วหรือยัง
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];  // ดึง username จากเซสชัน
} else {
    header("Location: login.php");
    exit();
}

// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$db_username = "root";  // เปลี่ยนชื่อตัวแปรเพื่อหลีกเลี่ยงการสับสน
$password = "12345678";
$dbname = "webdatabase";

$conn = new mysqli($servername, $db_username, $password, $dbname);

$_SESSION['go'] = 'user_order.php';

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ดึง user_id จากฐานข้อมูลโดยใช้ username
$sql_user = "SELECT id FROM users WHERE username = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("s", $username);
$stmt_user->execute();
$result_user = $stmt_user->get_result();

// ตรวจสอบว่าพบผู้ใช้หรือไม่
if ($row_user = $result_user->fetch_assoc()) {
    $user_id = $row_user['id'];  // ดึง user_id ของผู้ใช้ที่ล็อกอิน
} else {
    echo "ไม่พบผู้ใช้.";
    exit();
}

// ดึงข้อมูลจากตาราง orders, all_products และ users โดยใช้ JOIN เฉพาะของ user ที่ล็อกอินอยู่
$sql = "SELECT orders.id, all_products.product_name, orders.quantity, users.username, orders.order_date, orders.total
        FROM orders 
        JOIN all_products ON orders.product_id = all_products.product_id 
        JOIN users ON orders.user_id = users.id
        WHERE orders.user_id = ?";  // เพิ่มเงื่อนไข WHERE เพื่อกรองข้อมูลเฉพาะผู้ใช้ที่ล็อกอิน

$stmt = $conn->prepare($sql);  // เตรียม statement
$stmt->bind_param("i", $user_id);  // ผูก user_id เป็นพารามิเตอร์
$stmt->execute();  // รัน query
$result = $stmt->get_result();

// คำนวณผลรวมของ total โดยใช้ DISTINCT และเรียงตามวันที่ล่าสุดเสมอ
$sql_sum = "
    SELECT SUM(total) AS total_sum
    FROM (
        SELECT DISTINCT order_date, total
        FROM orders
        ORDER BY order_date DESC
    ) AS distinct_orders
";

$sumresult = $conn->query($sql_sum);

// ตรวจสอบและดึงผลรวมค่า total
$sumtotal = 0;
if ($sumresult->num_rows > 0) {
    $row = $sumresult->fetch_assoc();
    $sumtotal = $row['total_sum'];
} else {
    echo "ไม่พบรายการสั่งซื้อ";
}


// ปิดการเชื่อมต่อ
$stmt->close();
$stmt_user->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ka_jang_handmade</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta charset="utf-8">
    <title>ka_jang_handmade</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

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
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

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
        <a href="user_dashboard.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <img src=img/logo-1.png width="200px">
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="user_dashboard.php" class="nav-item nav-link"><i class="fa-solid fa-house me-2"></i>Home</a>
                <a href="trakra.php" class="nav-item nav-link"><i class="bi bi-cart-fill"></i> Shop</a>
                <a href="meaning-of-flowers.php" class="nav-item nav-link"><i class="fa-solid fa-leaf me-2"></i>Meaning of Flowers</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Products</a>
                    <div class="dropdown-menu fade-up m-0">
                        <a href="ourshop-flower-01.php" class="dropdown-item">Flower</a>
                        <a href="ourshop-accessories-01.php" class="dropdown-item">Accessorie</a>
                        <a href="ourshop-keychain-01.php" class="dropdown-item">Keychain</a>
                    </div>
                </div>
                <a href="about.php" class="nav-item nav-link"><i class="fa-solid fa-user me-2"></i>About</a>
                <a href="user_order.php" class="nav-item nav-link active"><i class="bi bi-person-check-fill"></i> <?php echo htmlspecialchars($username); ?> </a>
                <a href="Logout.php" class="nav-item nav-link"><i class="bi bi-box-arrow-right"></i> Logout</a>
            </div>
            <a href="https://www.instagram.com/ka_jang_handmade/"
                class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Contact<i
                    class="fa fa-arrow-right ms-3"></i></a>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Order</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-white" href="user_dashboard.php">Home</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Order</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->


    <div class="container mt-5">
        <h2 class="text-center mb-4">รายการสั่งซื้อทั้งหมด</h2>
        <?php if ($result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Order ID</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Date</th>
                            <th>Order Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['username']); ?></td>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                                <td><?php echo htmlspecialchars($row['order_date']); ?></td>
                                <td>
                                    <form action="delete_order.php" method="post" style="display:inline;">
                                        <input type="hidden" name="order_date" value="<?php echo htmlspecialchars($row['order_date']); ?>">
                                        <button type="submit" class="btn btn-danger">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <h4 class="text-end mb-4">Payment amount</h4>
        <h4 class="text-end mb-4"><?php echo htmlspecialchars($sumtotal); ?> ฿</h4>

        <?php else: ?>
            <div class="alert alert-info text-center">
                ไม่พบรายการสั่งซื้อ
            </div>
        <?php endif; ?>
    </div>

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-0 back-to-top"><i class="bi bi-arrow-up"></i></a>

    <!-- Footer start-->
    <div class="container-fluid bg-dark text-light footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Contact Shop</h4>
                    <p class="mb-2 d-flex align-items-center"><a class="btn btn-outline-light btn-social"
                            href="https://www.instagram.com/ka_jang_handmade/"><i
                                class="fab fa-instagram"></i></a>ka_jang_handmade</p>
                    <p class="mb-2 d-flex align-items-center"><a class="btn btn-outline-light btn-social"
                            href="https://www.instagram.com/jjjub__jang/"><i
                                class="fab fa-instagram"></i></a>jjjub__jang</p>
                    <p class="mb-2 d-flex align-items-center mali-regular"><a class="btn btn-outline-light btn-social"
                            href="https://www.facebook.com/jjjangggg"><i class="fab fa-facebook"></i></a>จิรัชญา
                        สวัสดิ์วงศ์</p>
                    <p class="mb-2 d-flex align-items-center"><a class="btn btn-outline-light btn-social"
                            href="https://www.tiktok.com/@kajang.handmade?is_from_webapp=1&sender_device=pc"><i
                                class="fab fa-tiktok"></i></a>kajang.handmade</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Products</h4>
                    <a class="btn btn-link" href="ourshop-flower-01.php">Flower</a>
                    <a class="btn btn-link" href="ourshop-accessories-01.php">Accessorie</a>
                    <a class="btn btn-link" href="ourshop-keychain-01.php">Keychain</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="copyright">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    &copy; <a class="border-bottom" href="user_dashboard.php.html">ka_jang_handmade</a>, All Right Reserved.
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                    Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End-->

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>