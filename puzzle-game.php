<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>GameZone - Puzzle Game</title>

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

        .puzzle-box {
            background: #1b2b3d;
            width: 500px;
            max-width: 90%;
            padding: 35px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 8px 25px rgba(0,0,0,0.4);
        }

        .emoji {
            font-size: 55px;
            margin-bottom: 10px;
        }

        h1 {
            color: #08bff0;
            margin-bottom: 10px;
        }

        .info {
            color: #ddd;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        #playerName {
            width: 80%;
            padding: 12px;
            margin-bottom: 20px;
            border: none;
            border-radius: 7px;
            font-size: 16px;
            text-align: center;
        }

        .puzzle {
            width: 300px;
            height: 300px;
            margin: auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 5px;
            background: #081525;
            padding: 5px;
            border-radius: 10px;
        }

        .tile {
            background: #08bff0;
            color: #06111f;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 28px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
        }

        .tile:hover {
            background: #00d4ff;
        }

        .empty {
            background: #243b53;
            cursor: default;
        }

        button {
            margin-top: 20px;
            margin-left: 5px;
            margin-right: 5px;
            padding: 12px 25px;
            background: #08bff0;
            color: #06111f;
            border: none;
            border-radius: 7px;
            font-weight: bold;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #00a6d6;
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
        }

        #message {
            margin-top: 18px;
            min-height: 25px;
            color: #00ff88;
            font-weight: bold;
        }

        .score {
            margin-top: 15px;
            color: #ffd700;
            font-size: 20px;
            font-weight: bold;
        }

        .back {
            display: block;
            margin-top: 25px;
            color: #08bff0;
            text-decoration: none;
        }

    </style>

</head>

<body>

<div class="puzzle-box">

    <div class="emoji">🧩</div>

    <h1>Puzzle Game</h1>

    <p class="info">
        Arrange the numbers from <b>1 to 8</b>.<br>
        Click a number next to the empty space to move it.
    </p>


    <!-- PLAYER NAME -->

    <input
        type="text"
        id="playerName"
        placeholder="Enter your name"
        maxlength="30"
        autocomplete="off"
    >


    <!-- PUZZLE -->

    <div class="puzzle" id="puzzle"></div>


    <!-- SHUFFLE -->

    <button onclick="shufflePuzzle()">

        🔀 Shuffle Puzzle

    </button>


    <!-- MESSAGE -->

    <div id="message"></div>


    <!-- SCORE -->

    <div class="score">

        🏆 Score:
        <span id="score">0</span>

    </div>


    <!-- SAVE SCORE -->

    <button
        id="saveScoreBtn"
        class="save-btn"
        onclick="saveScore()"
        style="display: none;">

        🏆 Save Score

    </button>


    <a href="games.php" class="back">

        ← Back to Games

    </a>

</div>


<script>

    let tiles =
        [1, 2, 3, 4, 5, 6, 7, 8, 0];

    let score = 0;

    let scoreSaved = false;

    let puzzleSolved = false;


    /* =========================
       DRAW PUZZLE
    ========================= */

    function drawPuzzle() {

        const puzzle =
            document.getElementById("puzzle");

        puzzle.innerHTML = "";


        tiles.forEach(function(tile, index) {

            const div =
                document.createElement("div");


            div.className = "tile";


            if (tile === 0) {

                div.className =
                    "tile empty";

                div.innerText = "";

            } else {

                div.innerText = tile;

                div.onclick = function() {

                    moveTile(index);

                };

            }


            puzzle.appendChild(div);

        });

    }


    /* =========================
       MOVE TILE
    ========================= */

    function moveTile(index) {

        if (puzzleSolved) {
            return;
        }


        const emptyIndex =
            tiles.indexOf(0);


        const row =
            Math.floor(index / 3);

        const col =
            index % 3;


        const emptyRow =
            Math.floor(emptyIndex / 3);

        const emptyCol =
            emptyIndex % 3;


        const isAdjacent =

            (
                Math.abs(row - emptyRow) === 1 &&
                col === emptyCol
            )

            ||

            (
                Math.abs(col - emptyCol) === 1 &&
                row === emptyRow
            );


        if (isAdjacent) {

            [
                tiles[index],
                tiles[emptyIndex]
            ] = [
                tiles[emptyIndex],
                tiles[index]
            ];


            score++;


            document.getElementById(
                "score"
            ).innerText = score;


            drawPuzzle();


            checkWin();

        }

    }


    /* =========================
       CHECK WIN
    ========================= */

    function checkWin() {

        const winningOrder =
            [1, 2, 3, 4, 5, 6, 7, 8, 0];


        if (
            tiles.every(function(tile, index) {

                return tile === winningOrder[index];

            })
        ) {

            puzzleSolved = true;


            document.getElementById(
                "message"
            ).innerText =
                "🎉 Congratulations! Puzzle Solved!";


            document.getElementById(
                "saveScoreBtn"
            ).style.display =
                "inline-block";

        }

    }


    /* =========================
       SAVE SCORE
    ========================= */

    function saveScore() {

        const playerName =
            document.getElementById(
                "playerName"
            ).value.trim();


        if (playerName === "") {

            alert(
                "Please enter your name first!"
            );

            return;

        }


        if (!puzzleSolved) {

            alert(
                "Please solve the puzzle first!"
            );

            return;

        }


        if (scoreSaved) {

            alert(
                "Your score is already saved!"
            );

            return;

        }


        const formData =
            new FormData();


        formData.append(
            "username",
            playerName
        );


        formData.append(
            "game",
            "Puzzle Game"
        );


        formData.append(
            "score",
            score
        );


        fetch(
            "save_score.php",
            {
                method: "POST",
                body: formData
            }
        )

        .then(function(response) {

            return response.text();

        })

        .then(function(data) {

            if (
                data.includes(
                    "Score saved successfully"
                )
            ) {

                scoreSaved = true;


                document.getElementById(
                    "saveScoreBtn"
                ).disabled = true;


                document.getElementById(
                    "saveScoreBtn"
                ).innerText =
                    "✅ Score Saved";


                document.getElementById(
                    "message"
                ).innerText =
                    "🎉 Puzzle Solved! Score Saved Successfully!";

            } else {

                alert(
                    "Error saving score!"
                );

            }

        })

        .catch(function(error) {

            console.log(error);

            alert(
                "Something went wrong while saving score."
            );

        });

    }


    /* =========================
       SHUFFLE PUZZLE
    ========================= */

    function shufflePuzzle() {

        puzzleSolved = false;

        scoreSaved = false;

        score = 0;


        document.getElementById(
            "score"
        ).innerText = score;


        document.getElementById(
            "message"
        ).innerText = "";


        document.getElementById(
            "saveScoreBtn"
        ).style.display = "none";


        document.getElementById(
            "saveScoreBtn"
        ).disabled = false;


        document.getElementById(
            "saveScoreBtn"
        ).innerText =
            "🏆 Save Score";


        for (
            let i = 0;
            i < 100;
            i++
        ) {

            const emptyIndex =
                tiles.indexOf(0);


            const possibleMoves = [];


            const row =
                Math.floor(emptyIndex / 3);

            const col =
                emptyIndex % 3;


            if (row > 0) {

                possibleMoves.push(
                    emptyIndex - 3
                );

            }


            if (row < 2) {

                possibleMoves.push(
                    emptyIndex + 3
                );

            }


            if (col > 0) {

                possibleMoves.push(
                    emptyIndex - 1
                );

            }


            if (col < 2) {

                possibleMoves.push(
                    emptyIndex + 1
                );

            }


            const randomIndex =
                possibleMoves[
                    Math.floor(
                        Math.random() *
                        possibleMoves.length
                    )
                ];


            [
                tiles[emptyIndex],
                tiles[randomIndex]
            ] = [
                tiles[randomIndex],
                tiles[emptyIndex]
            ];

        }


        drawPuzzle();

    }


    /* =========================
       INITIAL PUZZLE
    ========================= */

    drawPuzzle();

</script>

</body>

</html>