<?php

$conn = mysqli_connect("localhost", "root", "", "gamezone");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

session_start();

$user_id = null;

if (isset($_SESSION['email'])) {

    $email = $_SESSION['email'];

    $stmt = mysqli_prepare(
        $conn,
        "SELECT id FROM users WHERE email = ?"
    );

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        $user_id = $user['id'];
    }

    mysqli_stmt_close($stmt);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>GameZone - Number Game</title>

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

        .game-box {
            background: #1b2b3d;
            width: 420px;
            max-width: 90%;
            padding: 40px;
            border-radius: 15px;
            text-align: center;

            box-shadow: 0 8px 25px rgba(0,0,0,0.4);
        }

        h1 {
            color: #08bff0;
            margin-bottom: 15px;
        }

        .emoji {
            font-size: 55px;
            margin-bottom: 15px;
        }

        p {
            color: #ddd;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        input {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 7px;
            margin-bottom: 15px;
            font-size: 18px;
            text-align: center;
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

        #result {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
            min-height: 25px;
        }

        .score {
            margin-top: 15px;
            color: #ffd700;
            font-size: 20px;
        }

        .back {
            display: inline-block;
            margin-top: 25px;
            color: #08bff0;
            text-decoration: none;
        }

        .back:hover {
            text-decoration: underline;
        }

    </style>

</head>

<body>

<div class="game-box">

    <div class="emoji">🔢</div>

    <h1>Number Game</h1>

    <p>
        I have selected a number between <b>1 and 100</b>.<br>
        Can you guess it?
    </p>

    <input
        type="text"
        id="playerName"
        placeholder="Enter your name"
        maxlength="50"
    >

    <input
        type="number"
        id="guess"
        min="1"
        max="100"
        placeholder="Enter your guess"
    >

    <button onclick="checkGuess()">
        Guess Number
    </button>

    <div id="result"></div>

    <div class="score">
        Score: <span id="score">0</span>
    </div>

    <a href="games.php" class="back">
        ← Back to Games
    </a>

</div>

<script>

    let secretNumber =
        Math.floor(Math.random() * 100) + 1;

    let score = 0;

    function checkGuess() {

        let playerName =
            document.getElementById("playerName").value.trim();

        let guess =
            Number(document.getElementById("guess").value);

        let result =
            document.getElementById("result");

        if (playerName === "") {

            result.style.color = "#ff4d6d";

            result.innerHTML =
                "⚠️ Please enter your name.";

            document.getElementById("playerName").focus();

            return;
        }

        if (guess < 1 || guess > 100 || !guess) {

            result.style.color = "#ff4d6d";

            result.innerHTML =
                "⚠️ Please enter a number between 1 and 100.";

            document.getElementById("guess").focus();

            return;
        }

        if (guess === secretNumber) {

            score += 10;

            result.style.color = "#00ff88";

            result.innerHTML =
                "🎉 Correct, " + playerName + "!";

            document.getElementById("score").innerText =
                score;

            fetch("save_score.php", {

                method: "POST",

                headers: {
                    "Content-Type":
                    "application/x-www-form-urlencoded"
                },

                body:
                    "username=" +
                    encodeURIComponent(playerName) +
                    "&game=Number Game" +
                    "&score=" + score

            })
            .then(response => response.text())
            .then(data => {

                console.log("Score saved:", data);

            })
            .catch(error => {

                console.log(
                    "Error saving score:",
                    error
                );

            });

            secretNumber =
                Math.floor(Math.random() * 100) + 1;

        }

        else if (guess < secretNumber) {

            result.style.color = "#ffd700";

            result.innerHTML =
                "📈 Too low! Try again.";

        }

        else {

            result.style.color = "#ff9f43";

            result.innerHTML =
                "📉 Too high! Try again.";

        }

        document.getElementById("guess").value = "";

    }

</script>

</body>

</html>