<?php
// إعداد اتصال قاعدة البيانات
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_management";

// إنشاء الاتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// جلب بيانات المستخدمين
$sql = "SELECT id, username, password FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض بيانات المستخدمين</title>
    <style>
        /* تنسيقات CSS */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            margin: auto;
            padding: 10px;
        }
        h1 {
            text-align: center;
            color: #333;
            font-size: 24px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 16px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #4CAF50;
            color: white;
            text-align: left;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }

        /* تصميم مستجيب للهواتف */
        @media (max-width: 768px) {
            h1 {
                font-size: 20px;
            }
            table, th, td {
                font-size: 14px;
                padding: 6px;
            }
            .container {
                width: 100%;
                padding: 5px;
            }
        }

        /* تصميم مستجيب للأجهزة الصغيرة جدًا */
        @media (max-width: 480px) {
            h1 {
                font-size: 18px;
            }
            table, th, td {
                font-size: 12px;
                padding: 4px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>بيانات المستخدمين</h1>
        
        <?php
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Username</th><th>Password</th></tr>";
            
            // عرض البيانات في الجدول
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["username"] . "</td>";
                echo "<td>" . $row["password"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "لا توجد بيانات متاحة.";
        }
        
        // إغلاق الاتصال بقاعدة البيانات
        $conn->close();
        ?>
    </div>
</body>
</html>