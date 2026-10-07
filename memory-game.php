<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>GameZone - Memory Game</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #081525;
            color: white;
            min-height: 100vh;
        }

        header {
            background: #111b3d;
            padding: 25px;
            text-align: center;
        }

        header h1 {
            color: #08bff0;
            font-size: 38px;
        }

        header p {
            margin-top: 10px;
            color: #ddd;
        }

        .game-section {
            text-align: center;
            padding: 50px 20px;
        }

        .game-box {
            background: #1b2b3d;
            max-width: 650px;
            margin: auto;
            padding: 30px;
            border-radius: 15px;

            box-shadow:
                0 5px 20px rgba(0,0,0,0.4);

            transition: transform 0.3s ease;
        }

        .game-box:hover {
            transform: scale(1.03);
        }

        .game-box h2 {
            color: #08bff0;
            margin-bottom: 15px;
        }

        .name-input {
            width: 90%;
            max-width: 450px;

            padding: 13px 15px;

            margin-bottom: 25px;

            border: none;
            border-radius: 8px;

            font-size: 16px;

            text-align: center;

            outline: none;
        }

        .name-input:focus {
            box-shadow: 0 0 8px #08bff0;
        }

        .score {
            font-size: 20px;
            color: #08bff0;
            margin-bottom: 25px;
        }

        .memory-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;

            max-width: 450px;
            margin: auto;
        }

        .card {
            height: 90px;

            background: #08bff0;

            border-radius: 10px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 40px;

            cursor: pointer;

            transition:
                transform 0.3s ease,
                background 0.3s ease;
        }

        .card:hover {
            transform: scale(1.08);
            background: #00a6d6;
        }

        .card.flipped {
            background: #233b52;
            transform: scale(1.03);
        }

        .card.matched {
            background: #16a34a;
            cursor: default;
        }

        .message {
            margin-top: 25px;

            font-size: 20px;

            min-height: 30px;
        }

        .final-score {
            margin-top: 15px;

            color: #08bff0;

            font-size: 22px;

            font-weight: bold;
        }

        .save-score {
            margin-top: 20px;

            background: #16a34a;

            color: white;

            border: none;

            padding: 12px 25px;

            border-radius: 7px;

            font-weight: bold;

            cursor: pointer;

            font-size: 17px;

            transition: transform 0.3s ease;
        }

        .save-score:hover {
            background: #15803d;
            transform: scale(1.08);
        }

        .save-score:disabled {
            background: #555;
            cursor: not-allowed;
            transform: none;
        }

        .restart {
            margin-top: 25px;

            background: #08bff0;

            color: #06111f;

            border: none;

            padding: 12px 25px;

            border-radius: 7px;

            font-weight: bold;

            cursor: pointer;

            transition: transform 0.3s ease;
        }

        .restart:hover {
            background: #00a6d6;
            transform: scale(1.08);
        }

        .back {
            margin-top: 30px;
        }

        .back a {
            display: inline-block;

            background: #08bff0;

            color: #06111f;

            text-decoration: none;

            padding: 12px 25px;

            border-radius: 7px;

            font-weight: bold;

            transition: transform 0.3s ease;
        }

        .back a:hover {
            background: #00a6d6;
            transform: scale(1.08);
        }

        footer {
            text-align: center;

            padding: 20px;

            background: #111b3d;

            color: #aaa;

            margin-top: 30px;
        }

        @media (max-width: 500px) {

            .memory-grid {
                gap: 8px;
            }

            .card {
                height: 70px;
                font-size: 30px;
            }

        }

    </style>

</head>


<body>


<header>

    <h1>
        🧠 Memory Game
    </h1>

    <p>
        Match all the identical cards!
    </p>

</header>


<section class="game-section">

    <div class="game-box">

        <h2>
            Match the Pairs
        </h2>


        <!-- NAME INPUT -->

        <input
            type="text"
            id="playerName"
            class="name-input"
            placeholder="Enter your name"
            maxlength="30"
        >


        <!-- SCORE -->

        <div class="score">

            Moves:
            <span id="moves">0</span>

            &nbsp; | &nbsp;

            Score:
            <span id="score">0</span>

        </div>


        <!-- MEMORY GRID -->

        <div
            class="memory-grid"
            id="memoryGrid">
        </div>


        <!-- MESSAGE -->

        <div
            class="message"
            id="message">

            Enter your name and find all matching pairs!

        </div>


        <!-- SAVE SCORE BUTTON -->

        <button
            class="save-score"
            id="saveScoreBtn"
            onclick="saveScore()"
            style="display:none;">

            🏆 Save Score

        </button>


        <br>


        <!-- RESTART -->

        <button
            class="restart"
            onclick="startGame()">

            🔄 Restart Game

        </button>


        <!-- BACK -->

        <div class="back">

            <a href="games.php">

                ← Back to Games

            </a>

        </div>

    </div>

</section>


<footer>

    <p>
        © 2026 GameZone | Online Gaming Platform
    </p>

</footer>


<script>


/* =========================
   CARD SYMBOLS
========================= */

const symbols = [

    "🍎",
    "🍌",
    "🍇",
    "🍉",
    "🍓",
    "🍒",
    "🥝",
    "🍍"

];


let cards = [];

let firstCard = null;

let secondCard = null;

let lockBoard = false;

let moves = 0;

let matchedPairs = 0;

let score = 0;

let scoreSaved = false;



/* =========================
   START GAME
========================= */

function startGame() {

    const playerName =
        document.getElementById("playerName")
        .value
        .trim();


    if (playerName === "") {

        alert("Please enter your name first!");

        document.getElementById("playerName").focus();

        return;

    }


    const grid =
        document.getElementById("memoryGrid");


    grid.innerHTML = "";


    cards = [...symbols, ...symbols];


    cards.sort(
        () => Math.random() - 0.5
    );


    firstCard = null;

    secondCard = null;

    lockBoard = false;

    moves = 0;

    matchedPairs = 0;

    score = 0;

    scoreSaved = false;


    document.getElementById("moves")
        .innerText = "0";


    document.getElementById("score")
        .innerText = "0";


    const saveButton =
        document.getElementById("saveScoreBtn");


    saveButton.style.display = "none";

    saveButton.disabled = false;

    saveButton.innerText =
        "🏆 Save Score";


    document.getElementById("message")
        .innerText =
        "Good luck, " +
        playerName +
        "! Find all matching pairs!";


    cards.forEach(
        (symbol, index) => {

            const card =
                document.createElement("div");


            card.classList.add("card");


            card.dataset.symbol =
                symbol;


            card.dataset.index =
                index;


            card.innerText = "❓";


            card.addEventListener(
                "click",
                flipCard
            );


            grid.appendChild(card);

        }
    );

}



/* =========================
   FLIP CARD
========================= */

function flipCard() {

    const playerName =
        document.getElementById("playerName")
        .value
        .trim();


    if (playerName === "") {

        alert("Please enter your name first!");

        document.getElementById("playerName").focus();

        return;

    }


    if (lockBoard) {

        return;

    }


    if (this === firstCard) {

        return;

    }


    if (
        this.classList.contains("matched")
    ) {

        return;

    }


    this.classList.add("flipped");


    this.innerText =
        this.dataset.symbol;


    if (!firstCard) {

        firstCard = this;

        return;

    }


    secondCard = this;


    moves++;


    document.getElementById("moves")
        .innerText = moves;


    checkMatch();

}



/* =========================
   CHECK MATCH
========================= */

function checkMatch() {

    const isMatch =

        firstCard.dataset.symbol ===
        secondCard.dataset.symbol;


    if (isMatch) {

        disableCards();

    }

    else {

        unflipCards();

    }

}



/* =========================
   MATCHED CARDS
========================= */

function disableCards() {

    firstCard.classList.add("matched");

    secondCard.classList.add("matched");


    matchedPairs++;


    /*
       Every matching pair = 10 points
    */

    score += 10;


    document.getElementById("score")
        .innerText = score;


    resetBoard();


    /* =========================
       GAME COMPLETE
    ========================= */

    if (
        matchedPairs === symbols.length
    ) {

        const playerName =
            document.getElementById("playerName")
            .value
            .trim();


        document.getElementById("message")
            .innerText =

            "🎉 Congratulations " +
            playerName +
            "! You matched all pairs!";


        document.getElementById("saveScoreBtn")
            .style.display = "inline-block";

    }

}



/* =========================
   UNFLIP CARDS
========================= */

function unflipCards() {

    lockBoard = true;


    setTimeout(() => {

        firstCard.classList.remove(
            "flipped"
        );


        secondCard.classList.remove(
            "flipped"
        );


        firstCard.innerText = "❓";


        secondCard.innerText = "❓";


        resetBoard();


    }, 800);

}



/* =========================
   RESET BOARD
========================= */

function resetBoard() {

    firstCard = null;

    secondCard = null;

    lockBoard = false;

}



/* =========================
   SAVE SCORE
========================= */

function saveScore() {

    const playerName =
        document.getElementById("playerName")
        .value
        .trim();


    if (playerName === "") {

        alert("Please enter your name first!");

        return;

    }


    if (score <= 0) {

        alert(
            "Please complete the game first!"
        );

        return;

    }


    if (scoreSaved) {

        alert(
            "Your score is already saved!"
        );

        return;

    }


    /*
       Create POST form
    */

    const form =
        document.createElement("form");


    form.method = "POST";

    form.action = "save_score.php";


    /*
       Username
    */

    const usernameInput =
        document.createElement("input");


    usernameInput.type = "hidden";

    usernameInput.name = "username";

    usernameInput.value = playerName;


    /*
       Game Name
    */

    const gameInput =
        document.createElement("input");


    gameInput.type = "hidden";

    gameInput.name = "game";

    gameInput.value = "Memory Game";


    /*
       Score
    */

    const scoreInput =
        document.createElement("input");


    scoreInput.type = "hidden";

    scoreInput.name = "score";

    scoreInput.value = score;


    /*
       Add inputs to form
    */

    form.appendChild(usernameInput);

    form.appendChild(gameInput);

    form.appendChild(scoreInput);


    /*
       Add form to page
    */

    document.body.appendChild(form);


    /*
       Submit to save_score.php
    */

    form.submit();

}


</script>


</body>

</html>