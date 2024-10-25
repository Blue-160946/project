<?php
session_start();  // เริ่ม session
ob_start();  // เริ่ม output buffering

// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "12345678";
$dbname = "webdatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ถ้ามีการส่งแบบฟอร์มล็อกอิน
if (isset($_POST['login'])) {
    $log_username = $_POST['username'];
    $log_password = $_POST['password'];
    
    // ตรวจสอบชื่อผู้ใช้และรหัสผ่านโดยใช้ prepared statement
    $sql = $conn->prepare("SELECT * FROM users WHERE username=?");
    $sql->bind_param("s", $log_username);
    $sql->execute();
    $result = $sql->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // ตรวจสอบรหัสผ่าน
        if (password_verify($log_password, $row['password'])) {
            // เก็บข้อมูลลง session
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['id'] = $user_id; // สมมติว่าคุณมีตัวแปร $user_id
            
            // ตรวจสอบบทบาท (role)
            if ($row['role'] === 'admin') {
                header("Location: Admin_dashboard.php");
            } else {
                header("Location: user_dashboard.php");
            }
            exit();
        } else {
            echo "<script>alert('Incorrect password!');</script>";
        }
    } else {
        echo "<script>alert('Username not found!');</script>";
    }
    $sql->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register</title>
    <style>
        /* สีหลักและฟอนต์ */
        :root {
            --primary-color: #f8bbd0; /* ชมพูอ่อน */
            --secondary-color: #f06292; /* ชมพูเข้ม */
            --text-color: #333;
            --background-color: #fff;
            --font-family: 'Roboto', sans-serif;
        }
        
        body {
            font-family: var(--font-family);
            background-color: var(--background-color);
            color: var(--text-color);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        
        .login-container {
            background-color: var(--background-color);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }
        
        h1 {
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        h2 {
            color: var(--secondary-color);
            margin-bottom: -5px;
            font-size: 14px;
        }
        
        .input-group {
            margin-bottom: 15px;
            text-align: left;
        }
        
        .input-group label {
            color: var(--secondary-color);
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--primary-color);
            border-radius: 5px;
            box-sizing: border-box;
        }
        
        button {
            background-color: var(--primary-color);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
        }
        
        button:hover {
            background-color: var(--secondary-color);
        }
    </style>
</head>
<body>

<div class="login-container">
    <!-- แบบฟอร์มล็อกอิน -->
    <h1>Login</h1>
    <form action="" method="post">
        <div class="input-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" name="login">Login</button>
    </form>
    <br>
    <h2>ยังไม่มีบัญชีใช่ไหม? "ลงทะเบียนเลย!"</h2>
    <br>
    <button onclick="document.location = 'register.php'">Register</button> 

</div>

</body>
</html>
