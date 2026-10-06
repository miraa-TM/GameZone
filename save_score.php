```php
<?php

include "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    /*
        Number Game user_id mokle chhe.
        Quiz/Puzzle username mokli shake chhe.
    */

    $game = $_POST["game"] ?? "Unknown Game";
    $score = intval($_POST["score"] ?? 0);

    $username = $_POST["username"] ?? "Guest";

    /*
        Jo user_id available hoy to users table mathi
        username/name find karishu.
    */

    if (isset($_POST["user_id"]) && !empty($_POST["user_id"])) {

        $user_id = intval($_POST["user_id"]);

        $user_stmt = mysqli_prepare(
            $conn,
            "SELECT name FROM users WHERE id = ?"
        );

        mysqli_stmt_bind_param(
            $user_stmt,
            "i",
            $user_id
        );

        mysqli_stmt_execute($user_stmt);

        $user_result = mysqli_stmt_get_result($user_stmt);

        $user = mysqli_fetch_assoc($user_result);

        if ($user) {
            $username = $user["name"];
        }

        mysqli_stmt_close($user_stmt);
    }

    /*
        Score database ma save karo.
    */

    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO scores (username, game, score)
         VALUES (?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "ssi",
        $username,
        $game,
        $score
    );

    if (mysqli_stmt_execute($stmt)) {

        echo "Score saved successfully";

    } else {

        echo "Error saving score: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);

?>
```
