<?php
session_start();  // เริ่ม session

// ตรวจสอบว่าผู้ใช้ได้ล็อกอินแล้วหรือยัง
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    header("Location: login.php");
    exit();
}

// ตั้งค่าการเชื่อมต่อฐานข้อมูล
$host = 'localhost';
$db = 'webdatabase'; // ชื่อฐานข้อมูล
$user = 'root';
$pass = '12345678';

try {
    // เชื่อมต่อกับฐานข้อมูล
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ดึง user_id จากชื่อผู้ใช้
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user) {
        $user_id = $user['id']; // ใช้ id เป็น user_id
    } else {
        echo "ไม่พบผู้ใช้"; // ถ้าไม่พบผู้ใช้
        exit();
    }

    // ลบสินค้าจากตะกร้า
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_product_id'])) {
        $remove_product_id = (int)$_POST['remove_product_id'];
        // ลบรายการสินค้าออกจากตะกร้า
        $stmt = $conn->prepare("DELETE FROM cart WHERE product_id = :product_id AND user_id = :user_id");
        $stmt->execute(['product_id' => $remove_product_id, 'user_id' => $user_id]);
    }

    // เพิ่มสินค้าลงในตะกร้า
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
        $product_id = (int)$_POST['product_id'];
        $quantity = (int)$_POST['quantity'];

        // ตรวจสอบว่าจำนวนสินค้ามากกว่า 0 หรือไม่
        if ($quantity > 0) {
            // ตรวจสอบว่ามีสินค้าในตะกร้าของผู้ใช้คนนี้แล้วหรือไม่
            $stmt = $conn->prepare("SELECT * FROM cart WHERE product_id = :product_id AND user_id = :user_id");
            $stmt->execute(['product_id' => $product_id, 'user_id' => $user_id]);
            $item = $stmt->fetch();

            if ($item) {
                // อัปเดตจำนวนสินค้าในตะกร้า
                $new_quantity = $item['quantity'] + $quantity;
                $stmt = $conn->prepare("UPDATE cart SET quantity = :quantity WHERE product_id = :product_id AND user_id = :user_id");
                $stmt->execute(['quantity' => $new_quantity, 'product_id' => $product_id, 'user_id' => $user_id]);
            } else {
                // เพิ่มสินค้าใหม่ลงในตะกร้า
                $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
                $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'quantity' => $quantity]);
            }
        } else {
            echo "จำนวนสินค้าต้องมากกว่า 0";
        }
    }

    // ดึงรายการสินค้าทั้งหมดจากตาราง all_products
    $stmt = $conn->query("SELECT * FROM all_products");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ดึงรายการในตะกร้าของผู้ใช้
    $stmt = $conn->prepare("SELECT cart.quantity, all_products.product_name, all_products.price, all_products.image_url, cart.product_id 
                            FROM cart 
                            JOIN all_products ON cart.product_id = all_products.product_id 
                            WHERE cart.user_id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // คำนวณยอดรวมในตะกร้า
    $subtotal = 0;
    foreach ($cart_items as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }
    $shipping = 50; // ค่าจัดส่ง
    $total = $subtotal + $shipping;

    // คัดลอกข้อมูลจากตาราง cart ไปยังตาราง orders รวมราคาด้วย
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['checkout'])) {
        $conn->beginTransaction();

        try {
            // คัดลอกข้อมูลไปยังตาราง orders
            $stmt = $conn->prepare("INSERT INTO orders (user_id, product_id, quantity, total) 
                                    SELECT cart.user_id, cart.product_id, cart.quantity, :total
                                    FROM cart 
                                    JOIN all_products ON cart.product_id = all_products.product_id 
                                    WHERE cart.user_id = :user_id");
            $stmt->execute(['user_id' => $user_id, 'total' => $total]);

            // อัปเดตจำนวนสินค้าในตาราง all_products
            $stmt = $conn->prepare("UPDATE all_products AS p
                                    JOIN cart AS c ON p.product_id = c.product_id
                                    SET p.quantity_in_stock = p.quantity_in_stock - c.quantity
                                    WHERE c.user_id = :user_id");
            $stmt->execute(['user_id' => $user_id]);

            // ลบข้อมูลจากตาราง cart หลังจากการชำระเงิน
            $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = :user_id");
            $stmt->execute(['user_id' => $user_id]);

            $conn->commit();
            header("Location: user_order.php");
            exit();
        } catch (PDOException $e) {
            $conn->rollBack();
            echo "Database error: " . $e->getMessage();
        }
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ka_jang_handmade</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
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
                <a href="trakra.php" class="nav-item nav-link active"><i class="bi bi-cart-fill"></i> Shop</a>
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
                <a href="user_order.php" class="nav-item nav-link"><i class="bi bi-person-check-fill"></i> <?php echo htmlspecialchars($username); ?> </a>
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
            <h1 class="display-3 text-white mb-3 animated slideInDown">Shop</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-white" href="user_dashboard.php">Home</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Shop</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <style>
        .team-item {
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            background-color: #fff;
            transition: 0.3s;
        }

        .team-item:hover {
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        }

        .cart-item img {
            width: 80px;
            height: auto;
        }

        .cart-item h5 {
            margin-bottom: 0;
        }
    </style>
    </head>

    <body>
        <!-- Products Section Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="section-title text-start">
                    <h1 class="display-6 mb-5">Products</h1>
                </div>
                <div class="row g-4">
                    <?php foreach ($products as $product): ?>
                        <div class="col-lg-3 col-md-6 wow fadeInUp">
                            <div class="team-item">
                                <div class="overflow-hidden position-relative rounded-3">
                                    <img class="img-fluid" src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                                </div>
                                <div class="text-center p-4">
                                    <h5 class="mb-0"><?php echo htmlspecialchars($product['product_name']); ?></h5>
                                    <small><?php echo htmlspecialchars($product['price']); ?> ฿</small><br><br>
                                    <form action="trakra.php" method="post" class="d-flex align-items-center">
                                        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                        <input type="number" name="quantity" value="1" min="1" max="<?php echo $product['quantity_in_stock']; ?>" class="form-control me-2" style="width: 100px; height: 100%;">
                                        <button type="submit" class="btn btn-primary d-flex align-items-center" style="height: 38px;"><i class="bi bi-cart-plus me-1"></i> Add to Cart</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <!-- Products Section End -->

        <!-- Cart Section Start -->
        <div class="container py-5">
            <h1 class="display-5 mb-5 text-center">Your Cart</h1>
            <div class="row">
                <div class="col-lg-8">
                    <div id="cart-items">
                        <?php if (!empty($cart_items)): ?>
                            <?php foreach ($cart_items as $item): ?>
                                <div class="cart-item mb-4 d-flex align-items-center">
                                    <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>" class="img-fluid">
                                    <div class="ms-3">
                                        <h5><?php echo htmlspecialchars($item['product_name']); ?></h5>
                                        <small class="text-muted">Price: <?php echo htmlspecialchars($item['price']); ?> ฿</small><br>
                                        <small class="text-muted">Quantity: <?php echo $item['quantity']; ?></small>
                                    </div>
                                    <div class="ms-auto">
                                        <form action="" method="post" style="display:inline;">
                                            <input type="hidden" name="remove_product_id" value="<?php echo $item['product_id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted">Your cart is empty.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-4">
                    <h3 class="mb-4">Cart Summary</h3>
                    <div class="d-flex justify-content-between">
                        <h5>Subtotal:</h5>
                        <h5><?php echo htmlspecialchars($subtotal); ?> ฿</h5>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h5>Shipping:</h5>
                        <h5><?php echo htmlspecialchars($shipping); ?> ฿</h5>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <h5>Total:</h5>
                        <h5><?php echo htmlspecialchars($total); ?> ฿</h5>
                    </div>
                    <form action="" method="post">
                        <button type="submit" name="checkout" class="btn btn-primary mt-4">Proceed to Checkout</button>
                    </form>
                </div>

            </div>
        </div>
        <!-- Cart Section End -->

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
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