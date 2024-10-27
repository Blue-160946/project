<?php
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

// ถ้ามีการส่งแบบฟอร์มลงทะเบียน
if (isset($_POST['register'])) {
    $reg_username = $_POST['username'];
    $reg_password = $_POST['password'];
    $reg_email = $_POST['email']; // รับค่าจากฟอร์ม email

    // เข้ารหัสรหัสผ่าน
    $hashed_password = password_hash($reg_password, PASSWORD_DEFAULT);

    // ตรวจสอบว่าผู้ใช้นั้นมีอยู่แล้วหรือไม่ (username หรือ email)
    $sql_check = "SELECT * FROM users WHERE username='$reg_username' OR email='$reg_email'";
    $result = $conn->query($sql_check);

    if ($result->num_rows > 0) {
        echo "<script>alert('Username or Email already exists!');</script>";
    } else {
        // เพิ่มผู้ใช้ใหม่เข้าในฐานข้อมูล
        $sql = "INSERT INTO users (username, password, email) VALUES ('$reg_username', '$hashed_password', '$reg_email')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Registration successful!');</script>";
            echo "<script>window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Error');</script>";
        }
    }
}
$conn->close();
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
            --primary-color: #f8bbd0;
            /* ชมพูอ่อน */
            --secondary-color: #f06292;
            /* ชมพูเข้ม */
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

        .register-container {
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

    <div class="register-container">
        <!-- แบบฟอร์มลงทะเบียน -->
        <h1>Register</h1>
        <form action="" method="post">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" name="register">Register</button>

        </form>
    </div>

</body>

</html>