<?php
session_start(); // เริ่มเซสชัน
session_unset(); // ล้างข้อมูลเซสชัน
session_destroy(); // ทำลายเซสชัน
header("Location: index.html");  // เปลี่ยนเส้นทางกลับไปที่หน้า login
exit();
?>
