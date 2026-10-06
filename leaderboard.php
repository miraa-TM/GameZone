<?php

include "db.php";

$result = mysqli_query(
    $conn,
    "SELECT username, game, score, created_at
     FROM scores
     ORDER BY score DESC"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>GameZone - Leaderboard</title>

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

        .container {
            width: 90%;
            max-width: 900px;
            margin: 60px auto;
        }

        h1 {
            text-align: center;
            color: #38bdf8;
            margin-bottom: 40px;
            font-size: 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #1e293b;
            border-radius: 10px;
            overflow: hidden;
        }

        th {
            background-color: #111827;
            color: #38bdf8;
            padding: 18px;
            font-size: 17px;
        }

        td {
            padding: 16px;
            text-align: center;
            border-bottom: 1px solid #334155;
        }

        tr:hover {
            background-color: #263449;
        }

        .rank {
            font-weight: bold;
            color: #facc15;
        }

        .score {
            color: #38bdf8;
            font-weight: bold;
        }

        footer {
            text-align: center;
            padding: 25px;
            background-color: #111827;
            color: #94a3b8;
            margin-top: 80px;
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

            <a href="leaderboard.php">
                🏆 Leaderboard
            </a>

        </div>

    </nav>


    <!-- Leaderboard -->

    <div class="container">

        <h1>
            🏆 GameZone Leaderboard
        </h1>


        <table>

            <tr>

                <th>
                    Rank
                </th>

                <th>
                    Player Name
                </th>

                <th>
                    Game
                </th>

                <th>
                    Score
                </th>

                <th>
                    Date
                </th>

            </tr>


            <?php

            $rank = 1;

            while ($row = mysqli_fetch_assoc($result)) {

            ?>

                <tr>

                    <td class="rank">
                        <?php echo $rank; ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['username']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['game']); ?>
                    </td>

                    <td class="score">
                        <?php echo $row['score']; ?>
                    </td>

                    <td>
                        <?php echo $row['created_at']; ?>
                    </td>

                </tr>

            <?php

                $rank++;

            }

            ?>

        </table>

    </div>


    <!-- Footer -->

    <footer>

        <p>
            © 2026 GameZone | Online Gaming Platform
        </p>

    </footer>


</body>

</html>