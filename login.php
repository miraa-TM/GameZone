<?php 
include "db.php"; 
 
$message = ""; 
 
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
 
    $email = trim($_POST["email"]); 
    $password = trim($_POST["password"]); 
 
    if ($email == "" || $password == "") { 
 
        $message = "Please fill all fields."; 
 
    } else { 
 
        $sql = "SELECT * FROM users WHERE email = ?"; 
 
        $stmt = mysqli_prepare($conn, $sql); 
        mysqli_stmt_bind_param($stmt, "s", $email); 
        mysqli_stmt_execute($stmt); 
 
        $result = mysqli_stmt_get_result($stmt); 
 
        if (mysqli_num_rows($result) == 1) { 
 
            $user = mysqli_fetch_assoc($result); 
 
            if (password_verify($password, $user["password"])) { 
                header("Location: index.php");
                exit();
            } else { 
                $message = "Invalid email or password."; 
            } 
 
        } else { 
 
            $message = "Invalid email or password."; 
        } 
    } 
} 
?> 
 
<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
 
    <title>GameZone - Login</title> 
 
    <style> 
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
            font-family: Arial, sans-serif; 
        } 
 
        body { 
            background-color: #0f172a; 
            color: white; 
            min-height: 100vh; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
        } 
 
        .login-box { 
            width: 420px; 
            background-color: #1e293b; 
            padding: 40px; 
            border-radius: 15px; 
            text-align: center; 
        } 
 
        h1 { 
            color: #38bdf8; 
            margin-bottom: 10px; 
        } 
 
        p { 
            color: #cbd5e1; 
            margin-bottom: 25px; 
        } 
 
        label { 
            display: block; 
            text-align: left; 
            margin-bottom: 8px; 
        } 
 
        input { 
            width: 100%; 
            padding: 14px; 
            margin-bottom: 20px; 
            border: none; 
            border-radius: 8px; 
        } 
 
        button { 
            width: 100%; 
            padding: 14px; 
            background-color: #38bdf8; 
            border: none; 
            border-radius: 8px; 
            font-weight: bold; 
            cursor: pointer; 
        } 
 
        .message { 
            margin-bottom: 20px; 
            color: #00ff88; 
        } 
 
        a { 
            display: inline-block; 
            margin-top: 20px; 
            color: #38bdf8; 
            text-decoration: none; 
        } 
    </style> 
</head> 
 
<body> 
 
    <div class="login-box"> 
 
        <h1>🎮 GameZone</h1> 
 
        <p>Login to your account</p> 
 
        <?php if ($message != "") { ?> 
            <div class="message"> 
                <?php echo $message; ?> 
            </div> 
        <?php } ?> 
 
        <form method="POST"> 
 
            <label>Email</label> 
            <input type="email" name="email" placeholder="Enter email"> 
 
            <label>Password</label> 
            <input type="password" name="password" placeholder="Enter password"> 
 
            <button type="submit">Login</button> 
 
        </form> 
 
        <a href="register.php">Create an account</a> 
 
    </div> 
 
</body> 
</html>