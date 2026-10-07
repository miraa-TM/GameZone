<?php

session_start();

/*
    Logout button click thay tyare session destroy karo.
*/

if (isset($_GET['logout'])) {

    session_unset();
    session_destroy();

    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>GameZone - Online Gaming Platform</title>

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
        }

        /* Navbar */

        nav {
            background-color: #111827;
            padding: 20px 60px;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #38bdf8;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-left: 25px;
            font-size: 16px;
        }

        nav a:hover {
            color: #38bdf8;
        }

        /* Hero Section */

        .hero {
            text-align: center;
            padding: 100px 20px;

            background:
                linear-gradient(
                    135deg,
                    #1e1b4b,
                    #0f172a
                );
        }

        .hero h1 {
            font-size: 55px;
            margin-bottom: 20px;
            color: #38bdf8;
        }

        .hero p {
            font-size: 20px;
            color: #cbd5e1;
            margin-bottom: 30px;
        }

        .btn {
            display: inline-block;

            padding: 14px 30px;

            background-color: #38bdf8;

            color: #0f172a;

            text-decoration: none;

            border-radius: 8px;

            font-weight: bold;

            transition: transform 0.3s ease;
        }

        .btn:hover {
            background-color: #0ea5e9;
            color: white;
            transform: scale(1.08);
        }

        /* Games */

        .games {
            padding: 60px 30px;
            text-align: center;
        }

        .games h2 {
            font-size: 35px;
            margin-bottom: 40px;
        }

        .game-container {
            display: flex;
            justify-content: center;
            gap: 25px;
            flex-wrap: wrap;
        }

        .game-card {
            background-color: #1e293b;

            width: 280px;

            padding: 35px 25px;

            border-radius: 12px;

            box-shadow:
                0 5px 15px rgba(0,0,0,0.3);

            transition: transform 0.3s ease;
        }

        .game-card:hover {
            transform: scale(1.08);
        }

        .game-card .icon {
            font-size: 55px;
            margin-bottom: 15px;
        }

        .game-card h3 {
            color: #38bdf8;
            font-size: 25px;
            margin-bottom: 12px;
        }

        .game-card p {
            color: #cbd5e1;
            line-height: 1.5;
            margin-bottom: 25px;
        }

        /* Footer */

        footer {
            text-align: center;

            padding: 25px;

            background-color: #111827;

            color: #94a3b8;
        }

    </style>

</head>

<body>


    <!-- Navigation -->

    <nav>

        <div class="logo">
            🎮 GameZone
        </div>

        <div>

            <a href="index.php">
                Home
            </a>

            <!-- Leaderboard -->

            <a href="leaderboard.php">
                🏆 Leaderboard
            </a>

            <?php if (isset($_SESSION['email'])) { ?>

                <a href="index.php?logout=1">
                    Logout
                </a>

            <?php } else { ?>

                <a href="login.php">
                    Login
                </a>

                <a href="register.php">
                    Register
                </a>

            <?php } ?>

        </div>

    </nav>


    <!-- Hero Section -->

    <section class="hero">

        <h1>
            Welcome to GameZone 🎮
        </h1>

        <p>
            Play exciting games, improve your skills
            and compete with players!
        </p>

        <a href="#games" class="btn">
            Explore Games
        </a>

    </section>


    <!-- Games Section -->

    <section class="games" id="games">

        <h2>
            Popular Games
        </h2>

        <div class="game-container">


            <!-- Puzzle Game -->

            <div class="game-card">

                <div class="icon">
                    🧩
                </div>

                <h3>
                    Puzzle Game
                </h3>

                <p>
                    Test your brain and solve challenging puzzles.
                </p>

                <a href="puzzle-game.php" class="btn">
                    Play Now
                </a>

            </div>


            <!-- Quiz Game -->

            <div class="game-card">

                <div class="icon">
                    ❓
                </div>

                <h3>
                    Quiz Game
                </h3>

                <p>
                    Answer questions and test your knowledge.
                </p>

                <a href="quiz-game.php" class="btn">
                    Play Now
                </a>

            </div>


            <!-- Number Game -->

            <div class="game-card">

                <div class="icon">
                    🔢
                </div>

                <h3>
                    Number Game
                </h3>

                <p>
                    Guess the correct number and win points.
                </p>

                <a href="number-game.php" class="btn">
                    Play Now
                </a>

            </div>


            <!-- Rock Paper Scissors -->

            <div class="game-card">

                <div class="icon">
                    🪨📄✂️
                </div>

                <h3>
                    Rock Paper Scissors
                </h3>

                <p>
                    Choose your move and beat the computer.
                </p>

                <a href="rock-paper-scissors.php" class="btn">
                    Play Now
                </a>

            </div>


            <!-- Memory Game -->

            <div class="game-card">

                <div class="icon">
                    🧠
                </div>

                <h3>
                    Memory Game
                </h3>

                <p>
                    Match the cards and test your memory.
                </p>

                <a href="memory-game.php" class="btn">
                    Play Now
                </a>

            </div>


            <!-- Word Guess Game -->

            <div class="game-card">

                <div class="icon">
                    🔤
                </div>

                <h3>
                    Word Guess Game
                </h3>

                <p>
                    Guess the hidden word letter by letter.
                </p>

                <a href="word-guess-game.php" class="btn">
                    Play Now
                </a>

            </div>


            <!-- Card Matching Game -->

            <div class="game-card">

                <div class="icon">
                    🃏
                </div>

                <h3>
                    Card Matching Game
                </h3>

                <p>
                    Find matching cards and complete the game.
                </p>

                <a href="card-matching-game.php" class="btn">
                    Play Now
                </a>

            </div>


            <!-- Target Game -->

            <div class="game-card">

                <div class="icon">
                    🎯
                </div>

                <h3>
                    Target Game
                </h3>

                <p>
                    Hit the moving target and score as many points as possible.
                </p>

                <a href="target-game.php" class="btn">
                    Play Now
                </a>

            </div>


        </div>

    </section>


    <!-- Footer -->

    <footer>

        <p>
            © 2026 GameZone | Online Gaming Platform
        </p>

    </footer>


</body>

</html>