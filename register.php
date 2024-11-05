<?php
session_start(); // بدء الجلسة

// تحقق من وجود رسالة نجاح
if (isset($_SESSION['registration_success'])) {
    echo "<script>
            alert('تم تسجيل المستخدم بنجاح!');
            setTimeout(function() {
                window.location.href = 'http://localhost/logian/HTML.HTM'; // استبدل هذا بعنوان الموقع الذي تريد التوجيه إليه
            }, ); // مللي ثانية (3 ثواني)
          </script>";
    // قم بإلغاء الرسالة بعد عرضها
    unset($_SESSION['registration_success']);
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
    <title>إنشاء حساب</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            text-align: right;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .password-container {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            border: none;
            background: none;
            color: #007BFF; /* لون الزر */
        }
        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>إنشاء حساب جديد</h2>
        <form method="POST" action="" id="registrationForm">
            <label for="username">اسم المستخدم:</label>
            <input type="text" name="username" required>
            <label for="password">كلمة المرور:</label>
            <div class="password-container">
                <input type="password" id="password" name="password" required>
                <button type="button" class="toggle-password" onclick="togglePassword()">👁</button>
            </div>
            <input type="submit" value="تسجيل">
        </form>

        <script>
            function togglePassword() {
                const passwordField = document.getElementById('password');
                const passwordType = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', passwordType);
            }
        </script>

        <?php
        // التحقق من وجود بيانات المدخلات
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // إعدادات الاتصال بقاعدة البيانات
            $servername = "localhost"; 
            $username = "root"; 
            $password = ""; 
            $dbname = "user_management"; 

            // إنشاء الاتصال
            $mysqli = new mysqli($servername, $username, $password, $dbname);

            // التحقق من الاتصال
            if ($mysqli->connect_error) {
                die("فشل الاتصال: " . $mysqli->connect_error);
            }

            // الحصول على بيانات المدخلات
            $user_input_username = $_POST['username'];
            $user_input_password = $_POST['password'];

            // التحقق من وجود اسم المستخدم بالفعل
            $check_username_sql = "SELECT * FROM users WHERE username = '$user_input_username'";
            $result = $mysqli->query($check_username_sql);

            if ($result->num_rows > 0) {
                echo "<div class='error'>اسم المستخدم موجود بالفعل. يرجى اختيار اسم آخر.</div>";
            } else {
                // إدخال البيانات في قاعدة البيانات
                $sql = "INSERT INTO users (username, password) VALUES ('$user_input_username', '$user_input_password')";

                if ($mysqli->query($sql) === TRUE) {
                    // تعيين متغير الجلسة
                    $_SESSION['registration_success'] = true;
                    // إعادة توجيه إلى نفس الصفحة لعرض الرسالة
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit();
                } else {
                    echo "خطأ: " . $sql . "<br>" . $mysqli->error;
                }
            }

            // إغلاق الاتصال
            $mysqli->close();
        }
        ?>
    </div>
</body>
</html>