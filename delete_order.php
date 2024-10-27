<?php
session_start();  // เริ่ม session

// ตรวจสอบว่าผู้ใช้ได้ล็อกอินแล้วหรือยัง
if (!isset($_SESSION['username'])) {
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

// ตรวจสอบว่ามี order_date ถูกส่งมาหรือไม่
if (isset($_POST['order_date'])) {
    $order_date = $_POST['order_date'];

    // ลบออร์เดอร์ทั้งหมดที่มี order_date เดียวกัน
    $sql = "DELETE FROM orders WHERE order_date = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $order_date);
    
    if ($stmt->execute()) {
        // หากลบสำเร็จ
        echo "ลบออร์เดอร์ทั้งหมดที่มีวันที่ $order_date สำเร็จ";
    } else {
        echo "เกิดข้อผิดพลาดในการลบออร์เดอร์: " . $stmt->error;
    }

    // ปิด statement
    $stmt->close();
} else {
    echo "ไม่พบข้อมูลวันที่";
}

// ปิดการเชื่อมต่อ
$conn->close();

// ส่งผู้ใช้กลับไปยังหน้าที่ต้องการ
header("Location: $_SESSION[go]");
exit();

