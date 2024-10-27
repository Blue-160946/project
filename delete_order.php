<?php
session_start();  // เริ่ม session

// ตรวจสอบว่าผู้ใช้ได้ล็อกอินแล้วหรือยัง
if (!isset($_SESSION['username'])) {
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

// ตรวจสอบว่ามี order_date ถูกส่งมาหรือไม่
if (isset($_POST['order_date'])) {
    $order_date = $_POST['order_date'];

    // ดึงรายการสินค้าและ quantity ของออร์เดอร์ที่มีวันที่เดียวกัน
    $sql_select = "SELECT product_id, quantity FROM orders WHERE order_date = ?";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bind_param("s", $order_date);
    $stmt_select->execute();
    $result = $stmt_select->get_result();

    // คืนค่า quantity กลับไปยัง all_products
    while ($row = $result->fetch_assoc()) {
        $product_id = $row['product_id'];
        $quantity = $row['quantity'];

        // อัปเดตจำนวนสินค้าใน all_products
        $sql_update = "UPDATE all_products SET quantity_in_stock = quantity_in_stock + ? WHERE product_id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ii", $quantity, $product_id);
        $stmt_update->execute();
        $stmt_update->close();
    }

    $stmt_select->close();

    // ลบออร์เดอร์ทั้งหมดที่มี order_date เดียวกัน
    $sql_delete = "DELETE FROM orders WHERE order_date = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("s", $order_date);
    
    if ($stmt_delete->execute()) {
        echo "ลบออร์เดอร์ทั้งหมดที่มีวันที่ $order_date สำเร็จ";
    } else {
        echo "เกิดข้อผิดพลาดในการลบออร์เดอร์: " . $stmt_delete->error;
    }

    // ปิด statement
    $stmt_delete->close();
} else {
    echo "ไม่พบข้อมูลวันที่";
}

// ปิดการเชื่อมต่อ
$conn->close();

// ส่งผู้ใช้กลับไปยังหน้าที่ต้องการ
header("Location: $_SESSION[go]");
exit();
?>
