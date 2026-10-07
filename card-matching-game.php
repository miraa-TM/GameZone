<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>GameZone - Card Matching Game</title>

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
        max-width: 650px;
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
        color: white;
        margin: 20px 0;
    }

    .info {
        font-size: 18px;
        margin-bottom: 10px;
    }

    .score {
        font-size: 20px;
        color: #08bff0;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .card-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        max-width: 500px;
        margin: 20px auto;
    }

    .card {
        height: 95px;
        background: #08bff0;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 42px;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: scale(1.08);
    }

    .card.hidden {
        background: #243b55;
        color: transparent;
    }

    .card.matched {
        background: #22c55e;
        cursor: default;
    }

    .card.matched:hover {
        transform: scale(1);
    }

    button {
        margin-top: 15px;
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
        margin-top: 15px;
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

    @media (max-width: 500px) {

        .game-box {
            padding: 20px;
        }

        .card {
            height: 70px;
            font-size: 30px;
        }

        .card-container {
            gap: 8px;
        }

    }

</style>

</head>

<body>

<header>

    <h1>🎮 GameZone</h1>

</header>


<div class="game-box">

    <h2>🃏 Card Matching Game</h2>


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


        <div class="info">

            Moves:
            <span id="moves">0</span>

        </div>


        <div class="score">

            🏆 Score:
            <span id="score">0</span>

        </div>


        <div class="card-container"
             id="cardContainer">
        </div>


        <div class="message"
             id="message">
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


        <button onclick="restartGame()">

            🔄 Restart Game

        </button>

    </div>


    <br>


    <a href="games.php" class="back">

        ← Back to Games

    </a>

</div>


<script>

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
       START / RESET GAME
    ========================= */

    function startGame() {

        cards = [
            ...symbols,
            ...symbols
        ];


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


        document.getElementById(
            "moves"
        ).textContent = moves;


        document.getElementById(
            "score"
        ).textContent = score;


        document.getElementById(
            "message"
        ).textContent = "";


        document.getElementById(
            "saveScoreBtn"
        ).style.display = "none";


        const container =
            document.getElementById(
                "cardContainer"
            );


        container.innerHTML = "";


        cards.forEach(
            (symbol, index) => {

                const card =
                    document.createElement(
                        "div"
                    );


                card.classList.add(
                    "card",
                    "hidden"
                );


                card.dataset.symbol =
                    symbol;


                card.dataset.index =
                    index;


                card.textContent =
                    symbol;


                card.addEventListener(
                    "click",
                    flipCard
                );


                container.appendChild(
                    card
                );

            }
        );

    }


    /* =========================
       FLIP CARD
    ========================= */

    function flipCard() {

        if (lockBoard) {
            return;
        }


        if (this === firstCard) {
            return;
        }


        if (
            this.classList.contains(
                "matched"
            )
        ) {

            return;

        }


        this.classList.remove(
            "hidden"
        );


        if (!firstCard) {

            firstCard = this;

            return;

        }


        secondCard = this;


        moves++;


        document.getElementById(
            "moves"
        ).textContent = moves;


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

        } else {

            unflipCards();

        }

    }


    /* =========================
       MATCHED CARDS
    ========================= */

    function disableCards() {

        firstCard.classList.add(
            "matched"
        );


        secondCard.classList.add(
            "matched"
        );


        matchedPairs++;


        /* 10 POINTS FOR EACH PAIR */

        score += 10;


        document.getElementById(
            "score"
        ).textContent = score;


        resetBoard();


        if (
            matchedPairs ===
            symbols.length
        ) {

            const player =
                document.getElementById(
                    "playerName"
                ).textContent;


            document.getElementById(
                "message"
            ).textContent =
                "🎉 Congratulations " +
                player +
                "! You matched all cards!";


            document.getElementById(
                "saveScoreBtn"
            ).style.display =
                "inline-block";

        }

    }


    /* =========================
       UNFLIP CARDS
    ========================= */

    function unflipCards() {

        lockBoard = true;


        setTimeout(() => {

            firstCard.classList.add(
                "hidden"
            );


            secondCard.classList.add(
                "hidden"
            );


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
            "Card Matching Game";


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

        startGame();

    }

</script>

</body>

</html>