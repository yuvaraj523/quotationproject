<?php
session_start();
$con = new mysqli('localhost', 'root', '', 'quotation_db');

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
$sql = "SELECT * FROM login WHERE username='$username' AND password='$password'";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {

        $_SESSION['username'] = $username;
        header("Location: qms.php"); 
        exit();
    } else {

        echo "<script>
        alert('Invalid username or password!');
        </script>";
    }
}

$con->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
 body {
           font-family: sans-serif;
            background: whitesmoke;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
          height: 100vh;
}
.form-container {
    width: 100%;
    max-width: 400px;
    background-color: rgba(255, 255, 255, 0.8);
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); 
    backdrop-filter: blur(10px);
}
.form-container h2 {
    text-align: center;
    color: #007bff;;
    font-size: 2.0em;
    margin-bottom: 25px;
    text-transform: uppercase;
    
}

.form-group {
    position: relative;
    margin-bottom: 25px;
}

.form-group label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
    color: #007bff;
}

.form-group input {
    width: 100%;
    padding: 15px 50px 15px 15px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 16px;
    color: #333;
    box-sizing: border-box;
    box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.1);
}

.form-group i {
    position: absolute;
    right: 15px;
    bottom: 15%;
    transform: translateY(-50%);
    color: #007bff;
    font-size: 15px;
}



button {
    width: 100%;
    padding: 15px;
    background-color: #007bff;;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 18px;
    font-weight: bold;
 
}

button:hover {
    background-color: #007bff;

}
@media (max-width: 768px) {
            .form-container {
                padding: 20px;
            }

    </style>
</head>
<body>
    <div class="form-container">

    <h2>Login</h2>
    <form method="POST" action="">
    <form id="loginForm">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
                <i class="fas fa-user"></i>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <i class="fa fa-key" aria-hidden="true"></i>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
    
<!-- <script>
    document.getElementById('loginForm').addEventListener('submit', function(event) {
        event.preventDefault();
        
        var username = document.getElementById('username').value;
        var password = document.getElementById('password').value;
        if (username === 'Admin@gmail.com' && password === 'Admin@123') {
            window.location.href = 'qms.php'; 

        } else {
            alert('Invalid username or password!');
        }
    });
</script> -->
</body>
</html>

