<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>GameZone - Rock Paper Scissors</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #081525;
            color: white;
            text-align: center;
        }

        header {
            background: #111b3d;
            padding: 20px;
            color: #08bff0;
        }

        header h1 {
            margin-bottom: 10px;
        }

        .game-section {
            min-height: 80vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .game-box {
            background: #111b3d;
            padding: 35px;
            border-radius: 15px;
            width: 90%;
            max-width: 650px;
            box-shadow: 0 0 20px rgba(8, 191, 240, 0.3);
        }

        .game-box h2 {
            color: #08bff0;
            margin-bottom: 20px;
        }

        .name-input {
            width: 80%;
            padding: 12px;
            margin-bottom: 25px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            text-align: center;
        }

        .choices {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
            margin: 25px 0;
        }

        .choice {
            padding: 15px 20px;
            border: none;
            border-radius: 10px;
            background: #08bff0;
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: transform 0.3s ease, background 0.3s ease;
        }

        .choice:hover {
            transform: scale(1.08);
            background: #009ac4;
        }

        .result {
            margin: 25px 0;
            min-height: 50px;
            font-size: 18px;
            color: #08bff0;
        }

        .score {
            font-size: 20px;
            margin: 20px 0;
        }

        .save-btn {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            background: #22c55e;
            color: white;
            font-size: 17px;
            cursor: pointer;
            margin-top: 10px;
        }

        .save-btn:hover {
            background: #16a34a;
        }

        .save-btn:disabled {
            background: #555;
            cursor: not-allowed;
        }

        .back {
            margin-top: 25px;
        }

        .back a {
            color: #08bff0;
            text-decoration: none;
            font-size: 16px;
        }

        footer {
            background: #111b3d;
            padding: 15px;
            color: #aaa;
        }

    </style>

</head>

<body>

<header>

    <h1>🎮 GameZone</h1>

    <p>🪨 Rock Paper Scissors 📄 ✂️</p>

</header>


<section class="game-section">

    <div class="game-box">

        <h2>Rock Paper Scissors</h2>

        <input
            type="text"
            id="playerName"
            class="name-input"
            placeholder="Enter your name"
        >

        <h2>Choose Your Move</h2>

        <div class="choices">

            <button
                class="choice"
                onclick="playGame('Rock')">
                🪨 Rock
            </button>

            <button
                class="choice"
                onclick="playGame('Paper')">
                📄 Paper
            </button>

            <button
                class="choice"
                onclick="playGame('Scissors')">
                ✂️ Scissors
            </button>

        </div>


        <div class="result" id="result">
            Make your choice!
        </div>


        <div class="score">

            Player Score:
            <span id="playerScore">0</span>

            &nbsp; | &nbsp;

            Computer Score:
            <span id="computerScore">0</span>

        </div>


        <button
            class="save-btn"
            id="saveBtn"
            onclick="saveScore()">
            🏆 Save Score
        </button>


        <div class="back">

            <a href="games.php">
                ← Back to Games
            </a>

        </div>

    </div>

</section>


<footer>

    © 2026 GameZone | Online Gaming Platform

</footer>


<script>

let playerScore = 0;
let computerScore = 0;
let scoreSaved = false;


function playGame(playerChoice) {

    const playerName =
        document.getElementById("playerName").value.trim();

    if (playerName === "") {

        alert("Please enter your name first!");

        document.getElementById("playerName").focus();

        return;
    }


    const choices = [
        "Rock",
        "Paper",
        "Scissors"
    ];


    const computerChoice =
        choices[Math.floor(Math.random() * choices.length)];


    let result = "";


    if (playerChoice === computerChoice) {

        result =
            "🤝 Draw! " +
            playerName +
            " chose " +
            playerChoice +
            " and Computer chose " +
            computerChoice;

    }

    else if (

        (playerChoice === "Rock" &&
         computerChoice === "Scissors") ||

        (playerChoice === "Paper" &&
         computerChoice === "Rock") ||

        (playerChoice === "Scissors" &&
         computerChoice === "Paper")

    ) {

        playerScore++;

        result =
            "🎉 " +
            playerName +
            " Wins! You chose " +
            playerChoice +
            " and Computer chose " +
            computerChoice;

    }

    else {

        computerScore++;

        result =
            "😢 Computer Wins! " +
            playerName +
            " chose " +
            playerChoice +
            " and Computer chose " +
            computerChoice;

    }


    document.getElementById("result").innerText = result;

    document.getElementById("playerScore").innerText =
        playerScore;

    document.getElementById("computerScore").innerText =
        computerScore;

}



function saveScore() {

    const playerName =
        document.getElementById("playerName").value.trim();


    if (playerName === "") {

        alert("Please enter your name first!");

        document.getElementById("playerName").focus();

        return;
    }


    if (scoreSaved) {

        alert("Your score is already saved!");

        return;
    }


    const formData = new FormData();

    formData.append("username", playerName);

    formData.append(
        "game",
        "Rock Paper Scissors"
    );

    formData.append(
        "score",
        playerScore
    );


    fetch("save_score.php", {

        method: "POST",

        body: formData

    })

    .then(response => response.text())

    .then(data => {

        if (data.includes("Score saved successfully")) {

            alert("🏆 Score saved successfully!");

            scoreSaved = true;

            document.getElementById("saveBtn").disabled = true;

            document.getElementById("saveBtn").innerText =
                "✅ Score Saved";

        }

        else {

            alert("Error saving score!");

        }

    })

    .catch(error => {

        console.log(error);

        alert("Something went wrong while saving score.");

    });

}

</script>

</body>

</html>