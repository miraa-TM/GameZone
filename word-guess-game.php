<?php
session_start();

$words = [
    "COMPUTER",
    "GAMING",
    "PUZZLE",
    "PYTHON",
    "CODING",
    "INTERNET",
    "KEYBOARD",
    "MOBILE",
    "PROGRAM",
    "WEBSITE"
];


/* =========================
   START GAME WITH NAME
========================= */

if (isset($_POST['start_game'])) {

    $name = trim($_POST['player_name']);

    if ($name == "") {

        $_SESSION['name_error'] = "Please enter your name.";

    } else {

        $_SESSION['player_name'] = htmlspecialchars($name);

        $_SESSION['word'] = $words[array_rand($words)];

        $_SESSION['guessed'] = [];

        $_SESSION['wrong'] = 0;

        $_SESSION['score'] = 0;

        $_SESSION['score_saved'] = false;

        $_SESSION['message'] = "";

        unset($_SESSION['name_error']);
    }
}


/* =========================
   RESTART GAME
========================= */

if (isset($_POST['restart'])) {

    $_SESSION['word'] = $words[array_rand($words)];

    $_SESSION['guessed'] = [];

    $_SESSION['wrong'] = 0;

    $_SESSION['score'] = 0;

    $_SESSION['score_saved'] = false;

    $_SESSION['message'] = "";
}


/* =========================
   GUESS LETTER
========================= */

if (isset($_POST['guess']) && isset($_SESSION['player_name'])) {

    $letter = strtoupper(trim($_POST['letter']));

    if (
        $letter == "" ||
        strlen($letter) != 1 ||
        !ctype_alpha($letter)
    ) {

        $_SESSION['message'] =
            "Please enter one letter.";

    } elseif (in_array($letter, $_SESSION['guessed'])) {

        $_SESSION['message'] =
            "You already guessed this letter!";

    } else {

        $_SESSION['guessed'][] = $letter;

        if (strpos($_SESSION['word'], $letter) === false) {

            $_SESSION['wrong']++;

            $_SESSION['message'] =
                "Wrong guess! ❌";

        } else {

            $_SESSION['message'] =
                "Correct guess! ✅";
        }
    }
}


/* =========================
   CHECK GAME STATUS
========================= */

$displayWord = "";

if (isset($_SESSION['word'])) {

    for (
        $i = 0;
        $i < strlen($_SESSION['word']);
        $i++
    ) {

        $letter = $_SESSION['word'][$i];

        if (in_array($letter, $_SESSION['guessed'])) {

            $displayWord .= $letter . " ";

        } else {

            $displayWord .= "_ ";
        }
    }
}


/* =========================
   WIN / LOSE
========================= */

$won = false;

$lost = false;

if (isset($_SESSION['word'])) {

    $won = true;

    for (
        $i = 0;
        $i < strlen($_SESSION['word']);
        $i++
    ) {

        if (
            !in_array(
                $_SESSION['word'][$i],
                $_SESSION['guessed']
            )
        ) {

            $won = false;

            break;
        }
    }

    $lost = $_SESSION['wrong'] >= 6;
}


/* =========================
   SCORE
========================= */

if ($won) {

    $_SESSION['score'] = 10;

} elseif ($lost) {

    $_SESSION['score'] = 0;
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>GameZone - Word Guess Game</title>

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
            font-size: 30px;
        }

        .game-box {
            width: 90%;
            max-width: 600px;
            margin: 50px auto;
            padding: 40px 30px;
            background: #1b2b3d;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.4);
        }

        .game-icon {
            font-size: 70px;
            margin-bottom: 15px;
        }

        h2 {
            color: #08bff0;
            margin-bottom: 25px;
        }

        .player-name {
            font-size: 20px;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 25px;
        }

        .name-input {
            width: 80%;
            max-width: 350px;
            padding: 13px;
            font-size: 18px;
            border: none;
            border-radius: 8px;
            outline: none;
            margin: 10px 0;
            text-align: center;
        }

        .word {
            font-size: 36px;
            font-weight: bold;
            letter-spacing: 10px;
            margin: 30px 0;
            color: #ffffff;
        }

        .info {
            font-size: 18px;
            margin: 15px 0;
        }

        .input-box {
            margin-top: 25px;
        }

        input[type="text"] {
            width: 70px;
            padding: 12px;
            font-size: 22px;
            text-align: center;
            text-transform: uppercase;
            border: none;
            border-radius: 8px;
            outline: none;
        }

        button {
            margin: 10px;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            background: #08bff0;
            color: #081525;
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
            margin: 20px 0;
            font-size: 19px;
            font-weight: bold;
        }

        .error {
            color: #ff6b6b;
            margin: 10px 0;
            font-size: 17px;
        }

        .guessed {
            margin-top: 20px;
            color: #cbd5e1;
            font-size: 16px;
        }

        .result {
            font-size: 24px;
            color: #08bff0;
            font-weight: bold;
            margin: 20px 0;
        }

        .score-display {
            font-size: 20px;
            color: #08bff0;
            font-weight: bold;
            margin: 15px 0;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #08bff0;
            text-decoration: none;
            font-size: 17px;
            transition: transform 0.3s ease;
        }

        .back-link:hover {
            transform: scale(1.08);
        }

    </style>

</head>

<body>

<header>

    <h1>🎮 GameZone</h1>

</header>


<div class="game-box">

    <div class="game-icon">🔤</div>

    <h2>Word Guess Game</h2>


    <?php if (!isset($_SESSION['player_name'])): ?>

        <!-- NAME FORM -->

        <div class="message">

            👤 Enter Your Name

        </div>


        <form method="post">

            <input
                type="text"
                name="player_name"
                class="name-input"
                placeholder="Enter your name"
                maxlength="30"
                autocomplete="off"
                required
            >

            <br>

            <button
                type="submit"
                name="start_game">

                🎮 Start Game

            </button>

        </form>


        <?php

        if (isset($_SESSION['name_error'])) {

            echo '<div class="error">' .
                 $_SESSION['name_error'] .
                 '</div>';

            unset($_SESSION['name_error']);
        }

        ?>

    <?php else: ?>

        <!-- PLAYER NAME -->

        <div class="player-name">

            👤 Player:
            <?php echo $_SESSION['player_name']; ?>

        </div>


        <!-- GAME -->

        <div class="word">

            <?php echo $displayWord; ?>

        </div>


        <div class="info">

            Wrong Guesses:
            <?php echo $_SESSION['wrong']; ?> / 6

        </div>


        <?php if ($won): ?>

            <div class="result">

                🎉 You Won!

            </div>


            <div class="message">

                Great job,
                <?php echo $_SESSION['player_name']; ?>! 🎊

                <br>

                The word was:
                <?php echo $_SESSION['word']; ?>

            </div>


            <div class="score-display">

                🏆 Score:
                <?php echo $_SESSION['score']; ?>

            </div>


            <?php if (!$_SESSION['score_saved']): ?>

                <button
                    type="button"
                    class="save-btn"
                    onclick="saveScore()"
                    id="saveScoreBtn">

                    🏆 Save Score

                </button>

            <?php else: ?>

                <button
                    type="button"
                    class="save-btn"
                    disabled>

                    ✅ Score Saved

                </button>

            <?php endif; ?>


            <form method="post">

                <button
                    type="submit"
                    name="restart">

                    🔄 Play Again

                </button>

            </form>


        <?php elseif ($lost): ?>

            <div class="result">

                😢 Game Over!

            </div>


            <div class="message">

                The word was:
                <?php echo $_SESSION['word']; ?>

            </div>


            <div class="score-display">

                🏆 Score:
                <?php echo $_SESSION['score']; ?>

            </div>


            <?php if (!$_SESSION['score_saved']): ?>

                <button
                    type="button"
                    class="save-btn"
                    onclick="saveScore()"
                    id="saveScoreBtn">

                    🏆 Save Score

                </button>

            <?php else: ?>

                <button
                    type="button"
                    class="save-btn"
                    disabled>

                    ✅ Score Saved

                </button>

            <?php endif; ?>


            <form method="post">

                <button
                    type="submit"
                    name="restart">

                    🔄 Try Again

                </button>

            </form>


        <?php else: ?>

            <div class="input-box">

                <form method="post">

                    <input
                        type="text"
                        name="letter"
                        maxlength="1"
                        autocomplete="off"
                        required
                    >

                    <br>

                    <button
                        type="submit"
                        name="guess">

                        Guess Letter

                    </button>

                </form>

            </div>


            <div class="message">

                <?php echo $_SESSION['message']; ?>

            </div>


            <div class="guessed">

                Guessed Letters:

                <?php

                if (!empty($_SESSION['guessed'])) {

                    echo implode(
                        ", ",
                        $_SESSION['guessed']
                    );

                } else {

                    echo "None";
                }

                ?>

            </div>

        <?php endif; ?>

    <?php endif; ?>


    <a href="games.php" class="back-link">

        ← Back to Games

    </a>

</div>


<script>

function saveScore() {

    const playerName =
        <?php echo json_encode($_SESSION['player_name'] ?? ""); ?>;

    const score =
        <?php echo intval($_SESSION['score'] ?? 0); ?>;


    if (playerName === "") {

        alert("Player name not found!");

        return;
    }


    const formData = new FormData();

    formData.append(
        "username",
        playerName
    );

    formData.append(
        "game",
        "Word Guess Game"
    );

    formData.append(
        "score",
        score
    );


    fetch("save_score.php", {

        method: "POST",

        body: formData

    })

    .then(response => response.text())

    .then(data => {

        if (
            data.includes(
                "Score saved successfully"
            )
        ) {

            alert(
                "🏆 Score saved successfully!"
            );


            const button =
                document.getElementById(
                    "saveScoreBtn"
                );


            if (button) {

                button.disabled = true;

                button.innerText =
                    "✅ Score Saved";
            }


            window.location.reload();

        } else {

            alert(
                "Error saving score!"
            );
        }

    })

    .catch(error => {

        console.log(error);

        alert(
            "Something went wrong while saving score."
        );

    });

}

</script>


</body>

</html>