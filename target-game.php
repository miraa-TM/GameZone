<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>GameZone - Target Game</title>

<style>

    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #081525;
        color: white;
        text-align: center;
    }

    header {
        background: #111b3d;
        padding: 20px;
    }

    header h1 {
        margin: 0;
        color: #08bff0;
        font-size: 32px;
    }

    .game-box {
        width: 95%;
        max-width: 750px;
        margin: 35px auto;
        padding: 30px;
        background: #1b2b3d;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.4);
    }

    h2 {
        color: #08bff0;
        margin-bottom: 10px;
    }

    .name-section {
        margin: 25px 0;
    }

    .name-section p {
        font-size: 20px;
        font-weight: bold;
    }

    .name-input {
        width: 80%;
        max-width: 350px;
        padding: 13px;
        font-size: 18px;
        text-align: center;
        border: none;
        border-radius: 8px;
        outline: none;
    }

    .error {
        color: #ff6b6b;
        font-size: 17px;
        margin-top: 10px;
    }

    .player-name {
        font-size: 20px;
        font-weight: bold;
        margin: 20px 0;
    }

    .info {
        display: flex;
        justify-content: center;
        gap: 40px;
        font-size: 19px;
        margin: 20px 0;
    }

    .game-area {
        position: relative;
        width: 100%;
        max-width: 650px;
        height: 400px;
        margin: 20px auto;
        background: #0f2238;
        border: 3px solid #08bff0;
        border-radius: 12px;
        overflow: hidden;
        cursor: crosshair;
    }

    .target {
        position: absolute;
        width: 65px;
        height: 65px;
        border-radius: 50%;
        background: #ef4444;
        border: 5px solid white;
        cursor: pointer;

        display: none;

        transition: transform 0.2s ease;
    }

    .target::after {
        content: "";
        position: absolute;
        width: 20px;
        height: 20px;
        background: white;
        border-radius: 50%;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .target:hover {
        transform: scale(1.12);
    }

    button {
        margin: 10px;
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        background: #08bff0;
        color: #06111f;
        font-size: 17px;
        font-weight: bold;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    button:hover {
        transform: scale(1.08);
    }

    .save-btn {
        background: #22c55e;
        color: white;
    }

    .save-btn:hover {
        background: #16a34a;
    }

    .save-btn:disabled {
        background: #555;
        cursor: not-allowed;
        transform: none;
    }

    .message {
        font-size: 22px;
        color: #08bff0;
        font-weight: bold;
        min-height: 30px;
        margin: 15px 0;
    }

    .back {
        display: inline-block;
        margin-top: 20px;
        color: #08bff0;
        text-decoration: none;
        font-size: 17px;
        transition: transform 0.3s ease;
    }

    .back:hover {
        transform: scale(1.08);
    }

    @media (max-width: 600px) {

        .game-box {
            padding: 20px;
        }

        .game-area {
            height: 350px;
        }

        .info {
            gap: 20px;
            font-size: 16px;
        }

    }

</style>

</head>

<body>

<header>

    <h1>🎮 GameZone</h1>

</header>


<div class="game-box">

    <h2>🎯 Target Game</h2>


    <!-- NAME SECTION -->

    <div id="nameSection" class="name-section">

        <p>👤 Enter Your Name</p>

        <input
            type="text"
            id="playerNameInput"
            class="name-input"
            placeholder="Enter your name"
            maxlength="30"
            autocomplete="off"
        >

        <br>

        <button onclick="startWithName()">
            🎮 Start Game
        </button>

        <div id="nameError" class="error"></div>

    </div>


    <!-- GAME SECTION -->

    <div id="gameSection" style="display: none;">

        <div class="player-name">

            👤 Player:
            <span id="playerName"></span>

        </div>


        <p>
            Click the target as quickly as possible!
        </p>


        <div class="info">

            <div>
                🏆 Score:
                <span id="score">0</span>
            </div>

            <div>
                ⏱️ Time:
                <span id="time">30</span>s
            </div>

        </div>


        <div class="game-area" id="gameArea">

            <div class="target" id="target"></div>

        </div>


        <div class="message" id="message">

            Press Start Game to begin!

        </div>


        <!-- SAVE SCORE BUTTON -->

        <button
            id="saveScoreBtn"
            class="save-btn"
            onclick="saveScore()"
            style="display: none;">

            🏆 Save Score

        </button>


        <br>


        <button onclick="startGame()">

            ▶ Start Game

        </button>


        <button onclick="restartGame()">

            🔄 Restart

        </button>

    </div>


    <br>


    <a href="games.php" class="back">

        ← Back to Games

    </a>

</div>


<script>

    let score = 0;

    let timeLeft = 30;

    let gameRunning = false;

    let timer;

    let scoreSaved = false;


    const target =
        document.getElementById("target");

    const gameArea =
        document.getElementById("gameArea");

    const scoreDisplay =
        document.getElementById("score");

    const timeDisplay =
        document.getElementById("time");

    const message =
        document.getElementById("message");


    /* =========================
       START GAME WITH NAME
    ========================= */

    function startWithName() {

        const nameInput =
            document.getElementById(
                "playerNameInput"
            );

        const name =
            nameInput.value.trim();

        const error =
            document.getElementById(
                "nameError"
            );


        if (name === "") {

            error.textContent =
                "Please enter your name.";

            return;

        }


        error.textContent = "";


        document.getElementById(
            "playerName"
        ).textContent = name;


        document.getElementById(
            "nameSection"
        ).style.display = "none";


        document.getElementById(
            "gameSection"
        ).style.display = "block";


        startGame();

    }


    /* =========================
       MOVE TARGET
    ========================= */

    function moveTarget() {

        const areaWidth =
            gameArea.clientWidth;

        const areaHeight =
            gameArea.clientHeight;

        const targetWidth =
            target.offsetWidth;

        const targetHeight =
            target.offsetHeight;


        const maxX =
            areaWidth - targetWidth;

        const maxY =
            areaHeight - targetHeight;


        const randomX =
            Math.floor(
                Math.random() * maxX
            );

        const randomY =
            Math.floor(
                Math.random() * maxY
            );


        target.style.left =
            randomX + "px";

        target.style.top =
            randomY + "px";

    }


    /* =========================
       START GAME
    ========================= */

    function startGame() {

        if (gameRunning) {
            return;
        }


        score = 0;

        timeLeft = 30;

        gameRunning = true;

        scoreSaved = false;


        scoreDisplay.textContent =
            score;

        timeDisplay.textContent =
            timeLeft;


        message.textContent =
            "🎯 Hit the target!";


        document.getElementById(
            "saveScoreBtn"
        ).style.display = "none";


        target.style.display =
            "block";


        moveTarget();


        timer = setInterval(
            function() {

                timeLeft--;

                timeDisplay.textContent =
                    timeLeft;


                if (timeLeft <= 0) {

                    endGame();

                }

            },
            1000
        );

    }


    /* =========================
       TARGET CLICK
    ========================= */

    target.addEventListener(
        "click",
        function(event) {

            event.stopPropagation();


            if (!gameRunning) {
                return;
            }


            score++;


            scoreDisplay.textContent =
                score;


            moveTarget();

        }
    );


    /* =========================
       END GAME
    ========================= */

    function endGame() {

        clearInterval(timer);

        gameRunning = false;


        target.style.display =
            "none";


        const player =
            document.getElementById(
                "playerName"
            ).textContent;


        message.textContent =
            "⏰ Game Over " +
            player +
            "! Your Score: " +
            score;


        /* SHOW SAVE SCORE BUTTON */

        document.getElementById(
            "saveScoreBtn"
        ).style.display =
            "inline-block";

    }


    /* =========================
       SAVE SCORE
    ========================= */

    function saveScore() {

        const playerName =
            document.getElementById(
                "playerName"
            ).textContent;


        if (playerName === "") {

            alert(
                "Player name not found!"
            );

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


        const form =
            document.createElement(
                "form"
            );


        form.method = "POST";

        form.action = "save_score.php";


        const usernameInput =
            document.createElement(
                "input"
            );

        usernameInput.type = "hidden";

        usernameInput.name =
            "username";

        usernameInput.value =
            playerName;


        const gameInput =
            document.createElement(
                "input"
            );

        gameInput.type = "hidden";

        gameInput.name =
            "game";

        gameInput.value =
            "Target Game";


        const scoreInput =
            document.createElement(
                "input"
            );

        scoreInput.type = "hidden";

        scoreInput.name =
            "score";

        scoreInput.value =
            score;


        form.appendChild(
            usernameInput
        );

        form.appendChild(
            gameInput
        );

        form.appendChild(
            scoreInput
        );


        document.body.appendChild(
            form
        );


        scoreSaved = true;


        form.submit();

    }


    /* =========================
       RESTART GAME
    ========================= */

    function restartGame() {

        clearInterval(timer);

        score = 0;

        timeLeft = 30;

        gameRunning = false;

        scoreSaved = false;


        scoreDisplay.textContent =
            score;

        timeDisplay.textContent =
            timeLeft;


        target.style.display =
            "none";


        message.textContent =
            "Press Start Game to begin!";


        document.getElementById(
            "saveScoreBtn"
        ).style.display =
            "none";

    }

</script>

</body>

</html>