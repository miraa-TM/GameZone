<?php
include "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if ($username == "" || $email == "" || $password == "") {

        $message = "Please fill all fields.";

    } else {

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashed_password);

        if (mysqli_stmt_execute($stmt)) {
            $message = "Registration successful! 🎉";
        } else {
            $message = "Registration failed: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameZone - Register</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #081525;
            color: white;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .register-box {
            background: #1b2b3d;
            width: 420px;
            max-width: 90%;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.4);
        }

        h1 {
            text-align: center;
            color: #08bff0;
            margin-bottom: 10px;
        }

        .subtitle {
            text-align: center;
            color: #ccc;
            margin-bottom: 30px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #ddd;
        }

        input {
            width: 100%;
            padding: 13px;
            margin-bottom: 20px;
            border: none;
            border-radius: 7px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 13px;
            background: #08bff0;
            color: #06111f;
            border: none;
            border-radius: 7px;
            font-size: 17px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #00a6d6;
        }

        .message {
            text-align: center;
            margin-bottom: 20px;
            color: #00ff88;
            font-weight: bold;
        }

        .back {
            display: block;
            text-align: center;
            margin-top: 25px;
            color: #08bff0;
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="register-box">

    <h1>🎮 GameZone</h1>

    <p class="subtitle">Create your account</p>

    <?php if ($message != ""): ?>
        <div class="message">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <label>Username</label>
        <input
            type="text"
            name="username"
            placeholder="Enter username"
        >

        <label>Email</label>
        <input
            type="email"
            name="email"
            placeholder="Enter email"
        >

        <label>Password</label>
        <input
            type="password"
            name="password"
            placeholder="Enter password"
        >

        <button type="submit">Register</button>

    </form>

    <a href="index.php" class="back">← Back to Home</a>

</div>

</body>
</html>
