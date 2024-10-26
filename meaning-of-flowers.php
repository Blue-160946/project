<?php
session_start();  // เริ่ม session

// ตรวจสอบว่าผู้ใช้ได้ล็อกอินแล้วหรือยัง
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    header("Location: login.php");
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
                <a href="trakra.php" class="nav-item nav-link"><i class="bi bi-cart-fill"></i>  Shop</a>
                <a href="meaning-of-flowers.php" class="nav-item nav-link active"><i
                        class="fa-solid fa-leaf me-2"></i>Meaning of Flowers</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Products</a>
                    <div class="dropdown-menu fade-up m-0">
                        <a href="ourshop-flower-01.php" class="dropdown-item">Flower</a>
                        <a href="ourshop-accessories-01.php" class="dropdown-item">Accessorie</a>
                        <a href="ourshop-keychain-01.php" class="dropdown-item">Keychain</a>
                    </div>
                </div>
                <a href="about.php" class="nav-item nav-link"><i class="fa-solid fa-user me-2"></i>About</a>
                <a href ="user_order.php" class="nav-item nav-link"><i class="bi bi-person-check-fill"></i> <?php echo htmlspecialchars($username); ?> </a>
                <a href="Logout.php" class="nav-item nav-link"><i class="bi bi-box-arrow-right"></i> Logout</a>
                <a href="https://www.instagram.com/ka_jang_handmade/"
                    class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Contact<i
                        class="fa fa-arrow-right ms-3"></i></a>
            </div>
    </nav>
    <!-- Navbar End -->

    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Meaning of Flowers</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-white" href="user_dashboard.php">Home</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Meaning of Flowers</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Meaning of Flowers Start-->
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="section-title text-center">
                <h1 class="display-5 mb-5">Flowers</h1>
            </div>
            <div class="owl-carousel testimonial-carousel">
                <div class="testimonial-item text-center">
                    <img class="img-fluid bg-light p-2 mx-auto mb-3" src="img\MF\sunflowers.jpg"
                        style="width: 200px; height: 150px;">
                    <div class="testimonial-text text-center p-4">
                        <p class="mali-regular">ดอกทานตะวันมีความหมายแบบฝรั่งว่า “The Sun Always Blooms” ความมั่นคง
                            ภักดี ความร่าเริงสดใส และเต็มไปด้วยความมีชีวิตชีวา แต่สื่อแทนใจ
                            <br>บอกความรู้สึกแบบภาษาดอกไม้มีความหมายที่น่ารักมากว่า
                            “รักของฉันมั่นคงและภักดีต่อเธอเสมอดุจดั่งทานตะวันที่ไม่เคยหันมองผู้ใดนอกจากดวงอาทิตย์
                            เหมือนดั่งความรักของฉัน
                            ผู้มอบดอกทานตะวันนี้แด่เธอผู้เป็นที่รัก”
                            <br>ความหมายลึกซึ้งและอบอุ่นมาก
                        </p>
                        <h5 class="mb-1 mali-bold">Sunflower</h5>
                        <span class="mali-regular-italic">ดอกทานตะวัน</span>
                    </div>
                </div>
                <div class="testimonial-item text-center">
                    <img class="img-fluid bg-light p-2 mx-auto mb-3" src="img\MF\tulip.jpg"
                        style="width: 200px; height: 150px;">
                    <div class="testimonial-text text-center p-4">
                        <p class="mali-regular">
                            โดยทั่วไปดอกทิวลิปหมายถึงความรักที่สมบูรณ์แบบ เป็นตัวแทนการตกหลุมรัก<br>
                            อย่างหมดหัวใจ ความหลงใหล และการปกป้อง นอกจากนี้ดอกทิวลิปแต่ละสี<br>
                            ยังมีความหมายต่างกันไปด้วย ดังนี้
                        </p>
                        <ul type="dist" class="mali-regular text-start">
                            <li>สีแดง หมายถึง ความมั่นคงในความรัก ความซื่อสัตย์และรักหมดหัวใจ</li>
                            <li>สีชมพู หมายถึง ความรักที่ลึกซึ้ง และความคิดถึง</li>
                            <li>สีขาว หมายถึง ความรักที่ไม่หวังผลตอบแทน</li>
                            <li>สีม่วง หมายถึง ความซื่อสัตย์ ความมั่นคง</li>
                            <li>สีเหลือง หมายถึง ความรักที่ร่าเริง เบิกบานใจ</li>
                            <li>สีส้ม หมายถึง ความรักที่อบอุ่น ความมีเสน่ห์ และความสุข </li>
                        </ul>
                        <h5 class="mb-1 mali-bold">Tulips</h5>
                        <span class="mali-regular-italic">ดอกทิวลิป</span>
                    </div>
                </div>
                <div class="testimonial-item text-center">
                    <img class="img-fluid bg-light p-2 mx-auto mb-3" src="img\MF\rose.jpg"
                        style="width: 200px; height: 150px;">
                    <div class="testimonial-text text-center p-4">
                        <p class="mali-regular">ดอกกุหลาบเป็นสัญลักษณ์ของความรัก ความสวยงาม ความโรแมนติก
                            <br>ด้วยความที่ดอกกุหลาบมีหลายสี และแต่ละสีก็มีความหมายแตกต่างกันไป
                            <br>ผู้คนจึงนิยมนำดอกกุหลาบไปมอบให้กับคนรักเพื่อสื่อความในใจ
                            <br>ซึ่งดอกกุหลาบแต่ละสีมีความหมายดังนี้
                        </p>
                        <ul type="dist" class="mali-regular text-start">
                            <li>สีแดง หมายถึง ความรักที่โรแมนติก</li>
                            <li>สีขาว หมายถึง ความรักที่บริสุทธิ์</li>
                            <li>สีชมพู หมายถึง ความรักแบบทะนุถนอม</li>
                            <li>สีเหลือง หมายถึง ความอบอุ่น นิยมมอบให้เพื่อนมากกว่าคนรัก</li>
                            <li>สีส้ม หมายถึง ความห่วงใย ใช้แทนความรักที่กำลังก่อตัวเป็นความหลงใหล</li>
                            <li>สีม่วง หมายถึง รักแรกพบ</li>
                            <li>สีฟ้า หมายถึง ความโดดเดี่ยวยืนหยัดในรัก หรือผู้ที่ยังคงมั่นคงในรัก</li>
                            <li>สีดำ หมายถึง ความรักอันเป็นนิรันดร์ หรือความรักไม่มีอยู่จริง</li>
                        </ul>
                        <h5 class="mb-1 mali-bold">Rose</h5>
                        <span class="mali-regular-italic">ดอกกุหลาบ</span>
                    </div>
                </div>
                <div class="testimonial-item text-center">
                    <img class="img-fluid bg-light p-2 mx-auto mb-3" src="img\MF\forget-me-not.jpg"
                        style="width: 200px; height: 150px;">
                    <div class="testimonial-text text-center p-4">
                        <p class="mali-regular">แค่ชื่อของดอกไม้ก็สื่อความหมายดีๆว่า “อย่าลืมฉัน”
                            <br>เหมาะกับไปมอบให้กับคนรัก เพื่อบอกเป็นนัยว่าอย่าลืมความทรงจำดีๆ
                            <br>ที่เรามีร่วมกัน ในขณะเดียวกันก็สามารถมอบดอกไม้นี้ให้กับคนที่
                            <br>อยู่ห่างไกล เพื่อแทนความหมายว่าเราจะไม่ลืมกันได้อีกด้วย
                        </p>
                        <h5 class="mb-1 mali-bold">Forget Me Not</h5>
                        <span class="mali-regular-italic">ดอกฟอร์เก็ทมีน็อท</span>
                    </div>
                </div>
                <div class="testimonial-item text-center">
                    <img class="img-fluid bg-light p-2 mx-auto mb-3" src="img\MF\daisy.jpg"
                        style="width: 200px; height: 150px;">
                    <div class="testimonial-text text-center p-4">
                        <p class="mali-regular">ดอกไม้ขนาดเล็กที่น่าทนุถนอมนี้ มีความหมายสื่อถึง
                            <br>ความไร้เดียงสา และความซื่อสัตย์ต่อความรัก เป็นรักที่บริสุทธิ์
                            <br>เหมาะมากที่จะนำไปมอบให้กับคนรักในโอกาสดีๆ
                        </p>
                        <h5 class="mb-1 mali-bold">Daisy</h5>
                        <span class="mali-regular-italic"> ดอกเดซี่</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Meaning of Flowers End-->

    <!-- reference Start-->
    <div class="container">
        <div class="row">
            <div class="mali-regular">
                ที่มา :
                <a
                    href="https://www.lovelinkflower.com/10-%E0%B8%84%E0%B8%A7%E0%B8%B2%E0%B8%A1%E0%B8%AB%E0%B8%A1%E0%B8%B2%E0%B8%A2%E0%B8%94%E0%B8%AD%E0%B8%81%E0%B9%84%E0%B8%A1%E0%B9%89/">
                    lovelinkflower 10 ดอกไม้ความหมายดี ใช้สื่อแทนใจ บอกความรู้สึกผ่านภาษาดอกไม้
                </a>
                
            </div>
        </div>
    </div>
    <!-- reference Start-->

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
    <script src="lib/isotope/isotope.pkgd.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>