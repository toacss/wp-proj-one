<?php
session_start();

if (!isset($_SESSION['questions'])) {
    $_SESSION['questions'] = [
        [
            'question' => 'What is another name for the North Star?',
            'options' => ['Sirius', 'Canopus', 'Aldebaran', 'Polaris'],
            'answer' => 'Polaris'
        ],
        [
            'question' => 'Who painted the Sistine Chapel?',
            'options' => ['Michelangelo', 'Leonardo da Vinci', 'Vincent van Gogh', 'Claude Monet'],
            'answer' => 'Michelangelo'
        ],
        [
            'question' => 'How many dimples does the average golf ball have?',
            'options' => ['157', '412', '336', '219'],
            'answer' => '336'
        ]

    ];
    shuffle($_SESSION['questions']);
    $_SESSION['current'] = 0;
    $_SESSION['score'] = 0;
}

$current = $_SESSION['current'];
$total = count($_SESSION['questions']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected = $_POST['answer'] ?? '';
    $correct = $_SESSION['questions'][$current]['answer'];

    if ($selected === $correct) {
        $_SESSION['score']++;
    }

    $_SESSION['current']++;
    header("Location: game.php");
    exit();
}


if ($_SESSION['current'] >= $total) {
    echo "<html><head><title>Game Over</title><link rel='stylesheet' href='gamestyle.css'></head><body><div class='container'>";
    if ($_SESSION['score'] == $total) {
        echo "<h1>Congratulations, you just became a millionaire :)!</h1>";
        echo "<p>💰💰💰💰💰💰💰💰💰💰💰</p>";
    } else {
        echo "<h1>Game Over</h1>";
        echo "<h2> Guess you won't be a millionaire today!</h2>";
        echo "<p>Your score: {$_SESSION['score']} / $total</p>";
    }
    echo "<a href='game.php?restart=1' class='btn'>Play Again</a>";
    echo "<a href='../Homepage/homepage.html' class='btn'>Home</a>";
    echo "</div></body></html>";
    exit();
}

if (isset($_GET['restart'])) {
    session_unset();
    header("Location: game.php");
    exit();
}

$username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest';

$question = $_SESSION['questions'][$current];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Who Wants To Be A Millionaire?</title>
    <link rel="stylesheet" href="gamestyle.css">
</head>
<body>
    <div class="container">
    <h1>Hello, <?php echo $username; ?>. Welcome to the game. Here are your questions. </h1>
        <h2>Question <?php echo $current + 1; ?></h2>
        <p><?php echo $question['question']; ?></p>
        <form method="post">
            <?php foreach ($question['options'] as $option): ?>
                <div>
                    <label>
                        <input type="radio" name="answer" value="<?php echo $option; ?>" required>
                        <?php echo $option; ?>
                    </label>
                </div>
            <?php endforeach; ?>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>