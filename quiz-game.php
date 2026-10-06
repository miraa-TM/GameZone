<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameZone - Quiz Game</title>

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

        .quiz-box {
            background: #1b2b3d;
            width: 550px;
            max-width: 90%;
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 8px 25px rgba(0,0,0,0.4);
        }

        .emoji {
            font-size: 55px;
            margin-bottom: 15px;
        }

        h1 {
            color: #08bff0;
            margin-bottom: 20px;
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

        #question {
            font-size: 22px;
            margin-bottom: 25px;
            line-height: 1.5;
        }

        .option {
            width: 100%;
            padding: 13px;
            margin: 10px 0;
            background: #243b53;
            color: white;
            border: 2px solid transparent;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        .option:hover {
            border-color: #08bff0;
            background: #2d4a65;
        }

        #result {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
            min-height: 25px;
        }

        .score {
            margin-top: 20px;
            color: #ffd700;
            font-size: 20px;
        }

        .next-btn {
            margin-top: 20px;
            padding: 12px 25px;
            background: #08bff0;
            color: #06111f;
            border: none;
            border-radius: 7px;
            font-weight: bold;
            cursor: pointer;
            display: none;
        }

        .next-btn:hover {
            background: #00a6d6;
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

<div class="quiz-box">

    <div class="emoji">❓</div>

    <h1>Quiz Game</h1>

    <input
        type="text"
        id="playerName"
        placeholder="Enter your name"
    >

    <div id="question"></div>

    <div id="options"></div>

    <div id="result"></div>

    <div class="score">
        Score: <span id="score">0</span>
    </div>

    <button class="next-btn" id="nextBtn" onclick="nextQuestion()">
        Next Question →
    </button>

    <a href="games.php" class="back">← Back to Games</a>

</div>

<script>

    const questions = [
        {
            question: "Which language is used to create web pages?",
            options: ["HTML", "Python", "C++", "Java"],
            answer: "HTML"
        },

        {
            question: "What does CSS stand for?",
            options: [
                "Computer Style Sheets",
                "Cascading Style Sheets",
                "Creative Style System",
                "Colorful Style Sheets"
            ],
            answer: "Cascading Style Sheets"
        },

        {
            question: "Which language is used for web programming?",
            options: ["PHP", "MS Word", "Photoshop", "Excel"],
            answer: "PHP"
        },

        {
            question: "Which symbol is used for an ID selector in CSS?",
            options: [".", "#", "*", "$"],
            answer: "#"
        },

        {
            question: "Which company developed the PHP language?",
            options: ["Microsoft", "Google", "Rasmus Lerdorf", "Apple"],
            answer: "Rasmus Lerdorf"
        }
    ];

    let currentQuestion = 0;
    let score = 0;
    let scoreSaved = false;

    function loadQuestion() {

        const question = questions[currentQuestion];

        document.getElementById("question").innerText =
            (currentQuestion + 1) + ". " + question.question;

        const optionsDiv = document.getElementById("options");

        optionsDiv.innerHTML = "";

        document.getElementById("result").innerText = "";

        document.getElementById("nextBtn").style.display = "none";

        question.options.forEach(function(option) {

            const button = document.createElement("button");

            button.innerText = option;
            button.className = "option";

            button.onclick = function() {
                checkAnswer(option);
            };

            optionsDiv.appendChild(button);
        });
    }

    function checkAnswer(selectedAnswer) {

        const correctAnswer = questions[currentQuestion].answer;

        const result = document.getElementById("result");

        if (selectedAnswer === correctAnswer) {

            score += 10;

            result.style.color = "#00ff88";
            result.innerText = "🎉 Correct Answer! +10 points";

        } else {

            result.style.color = "#ff4d6d";
            result.innerText =
                "❌ Wrong Answer! Correct answer: " + correctAnswer;
        }

        document.getElementById("score").innerText = score;

        document.querySelectorAll(".option").forEach(function(button) {
            button.disabled = true;
        });

        document.getElementById("nextBtn").style.display = "inline-block";
    }

    function nextQuestion() {

        currentQuestion++;

        if (currentQuestion < questions.length) {

            loadQuestion();

        } else {

            document.getElementById("question").innerText =
                "🎉 Quiz Completed!";

            document.getElementById("options").innerHTML = "";

            document.getElementById("result").style.color = "#00ff88";

            document.getElementById("result").innerText =
                "Your final score is " + score + " / 50";

            document.getElementById("nextBtn").style.display = "none";

            saveScore();
        }
    }

    function saveScore() {

        if (scoreSaved) {
            return;
        }

        const playerName =
            document.getElementById("playerName").value.trim();

        if (playerName === "") {

            alert("Please enter your name before completing the quiz.");

            return;
        }

        scoreSaved = true;

        const formData = new FormData();

        formData.append("username", playerName);
        formData.append("game", "Quiz Game");
        formData.append("score", score);

        fetch("save_score.php", {
            method: "POST",
            body: formData
        })

        .then(response => response.text())

        .then(data => {

            document.getElementById("result").innerText =
                "🎉 Quiz Completed! Score Saved Successfully!";

        })

        .catch(error => {

            scoreSaved = false;

            document.getElementById("result").innerText =
                "Quiz completed, but score could not be saved.";

        });
    }

    loadQuestion();

</script>

</body>
</html>