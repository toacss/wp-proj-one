<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['username'])) {
    $_SESSION['username'] = htmlspecialchars(trim($_POST['username']));
    header("Location: ../Homepage/homepage.html");
    exit();
} else {
    header("Location: ../index.html");
    exit();
}
?>
