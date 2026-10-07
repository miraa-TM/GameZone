<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>GameZone - Snake Game</title>

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
            max-width: 600px;
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

        .info {
            display: flex;
            justify-content: center;
            gap: 50px;
            font-size: 19px;
            margin: 20px 0;
        }

        .game-area {
            width: 400px;
            height: 400px;
            max-width: 100%;
            margin: 20px auto;
            background: #0f2238;
            border: 3px solid #08bff0;
            border-radius: 10px;
            position: relative;
            overflow: hidden;
        }

        canvas {
            display: block;
            width: 100%;
            height: 100%;
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

        .message {
            font-size: 21px;
            color: #08bff0;
            font-weight: bold;
            min-height: 30px;
            margin: 15px 0;
        }

        .controls {
            margin-top: 15px;
        }

        .control-row {
            display: flex;
            justify-content: center;
        }

        .control-btn {
            width: 55px;
            height: 45px;
            padding: 5px;
            margin: 4px;
            font-size: 22px;
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

        @media (max-width: 450px) {

            .game-box {
                padding: 20px;
            }

            .info {
                gap: 25px;
                font-size: 16px;
            }

            .game-area {
                width: 350px;
                height: 350px;
            }

        }

    </style>

</head>

<body>


<header>

    <h1>🎮 GameZone</h1>

</header>


<div class="game-box">

    <h2>🐍 Snake Game</h2>

    <p>
        Eat the food and make your snake longer!
    </p>


    <div class="info">

        <div>
            Score:
            <span id="score">0</span>
        </div>

        <div>
            High Score:
            <span id="highScore">0</span>
        </div>

    </div>


    <div class="game-area">

        <canvas id="gameCanvas"
                width="400"
                height="400">
        </canvas>

    </div>


    <div class="message" id="message">
        Press Start Game to begin!
    </div>


    <button onclick="startGame()">
        ▶ Start Game
    </button>

    <button onclick="restartGame()">
        🔄 Restart
    </button>


    <div class="controls">

        <div class="control-row">

            <button class="control-btn"
                    onclick="changeDirection('UP')">
                ⬆
            </button>

        </div>

        <div class="control-row">

            <button class="control-btn"
                    onclick="changeDirection('LEFT')">
                ⬅
            </button>

            <button class="control-btn"
                    onclick="changeDirection('DOWN')">
                ⬇
            </button>

            <button class="control-btn"
                    onclick="changeDirection('RIGHT')">
                ➡
            </button>

        </div>

    </div>


    <a href="games.php" class="back">
        ← Back to Games
    </a>

</div>


<script>

    const canvas = document.getElementById("gameCanvas");

    const ctx = canvas.getContext("2d");

    const scoreDisplay = document.getElementById("score");

    const highScoreDisplay =
        document.getElementById("highScore");

    const message =
        document.getElementById("message");


    const box = 20;

    const canvasSize = 400;


    let snake;

    let food;

    let direction;

    let nextDirection;

    let score = 0;

    let highScore =
        localStorage.getItem("snakeHighScore") || 0;

    let gameInterval;

    let gameRunning = false;


    highScoreDisplay.textContent = highScore;


    function createFood() {

        let newFood;

        do {

            newFood = {
                x: Math.floor(
                    Math.random() *
                    (canvasSize / box)
                ) * box,

                y: Math.floor(
                    Math.random() *
                    (canvasSize / box)
                ) * box
            };

        } while (
            snake.some(
                part =>
                    part.x === newFood.x &&
                    part.y === newFood.y
            )
        );

        return newFood;

    }


    function startGame() {

        if (gameRunning) {
            return;
        }


        snake = [
            {
                x: 200,
                y: 200
            },

            {
                x: 180,
                y: 200
            },

            {
                x: 160,
                y: 200
            }
        ];


        direction = "RIGHT";

        nextDirection = "RIGHT";

        score = 0;

        scoreDisplay.textContent = score;

        food = createFood();

        gameRunning = true;

        message.textContent =
            "🐍 Use arrow keys or buttons to move!";


        clearInterval(gameInterval);

        gameInterval =
            setInterval(gameLoop, 120);

    }


    function restartGame() {

        clearInterval(gameInterval);

        gameRunning = false;

        score = 0;

        scoreDisplay.textContent = score;

        message.textContent =
            "Press Start Game to begin!";


        drawStartScreen();

    }


    function changeDirection(newDirection) {

        if (!gameRunning) {
            return;
        }


        if (
            newDirection === "UP" &&
            direction !== "DOWN"
        ) {

            nextDirection = "UP";

        }


        if (
            newDirection === "DOWN" &&
            direction !== "UP"
        ) {

            nextDirection = "DOWN";

        }


        if (
            newDirection === "LEFT" &&
            direction !== "RIGHT"
        ) {

            nextDirection = "LEFT";

        }


        if (
            newDirection === "RIGHT" &&
            direction !== "LEFT"
        ) {

            nextDirection = "RIGHT";

        }

    }


    function gameLoop() {

        direction = nextDirection;


        let head = {
            x: snake[0].x,
            y: snake[0].y
        };


        if (direction === "UP") {
            head.y -= box;
        }

        if (direction === "DOWN") {
            head.y += box;
        }

        if (direction === "LEFT") {
            head.x -= box;
        }

        if (direction === "RIGHT") {
            head.x += box;
        }


        if (
            head.x < 0 ||
            head.x >= canvasSize ||
            head.y < 0 ||
            head.y >= canvasSize
        ) {

            endGame();

            return;

        }


        if (
            snake.some(
                part =>
                    part.x === head.x &&
                    part.y === head.y
            )
        ) {

            endGame();

            return;

        }


        snake.unshift(head);


        if (
            head.x === food.x &&
            head.y === food.y
        ) {

            score++;

            scoreDisplay.textContent = score;


            if (score > highScore) {

                highScore = score;

                localStorage.setItem(
                    "snakeHighScore",
                    highScore
                );

                highScoreDisplay.textContent =
                    highScore;

            }


            food = createFood();

        } else {

            snake.pop();

        }


        drawGame();

    }


    function drawGame() {

        ctx.fillStyle = "#0f2238";

        ctx.fillRect(
            0,
            0,
            canvas.width,
            canvas.height
        );


        // Food

        ctx.fillStyle = "#ef4444";

        ctx.beginPath();

        ctx.arc(
            food.x + box / 2,
            food.y + box / 2,
            8,
            0,
            Math.PI * 2
        );

        ctx.fill();


        // Snake

        snake.forEach((part, index) => {

            if (index === 0) {

                ctx.fillStyle = "#08bff0";

            } else {

                ctx.fillStyle = "#22c55e";

            }


            ctx.fillRect(
                part.x + 1,
                part.y + 1,
                box - 2,
                box - 2
            );

        });

    }


    function drawStartScreen() {

        ctx.fillStyle = "#0f2238";

        ctx.fillRect(
            0,
            0,
            canvas.width,
            canvas.height
        );


        ctx.fillStyle = "#08bff0";

        ctx.font = "28px Arial";

        ctx.textAlign = "center";

        ctx.fillText(
            "🐍 Snake Game",
            canvas.width / 2,
            180
        );


        ctx.font = "18px Arial";

        ctx.fillText(
            "Press Start Game",
            canvas.width / 2,
            220
        );

    }


    function endGame() {

        clearInterval(gameInterval);

        gameRunning = false;

        message.textContent =
            "💥 Game Over! Your Score: " + score;

    }


    document.addEventListener(
        "keydown",
        function(event) {

            if (event.key === "ArrowUp") {

                event.preventDefault();

                changeDirection("UP");

            }

            if (event.key === "ArrowDown") {

                event.preventDefault();

                changeDirection("DOWN");

            }

            if (event.key === "ArrowLeft") {

                event.preventDefault();

                changeDirection("LEFT");

            }

            if (event.key === "ArrowRight") {

                event.preventDefault();

                changeDirection("RIGHT");

            }

        }
    );


    drawStartScreen();

</script>


</body>

</html>