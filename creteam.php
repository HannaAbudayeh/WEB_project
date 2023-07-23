<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Team</title>
    <link rel="stylesheet" href="login.css">
    <link rel="icon" href="https://img.icons8.com/?size=512&id=24717&format=png" type="image/x-icon" />

</head>

<body>
    <header>

        <div class="container">
            <img src="logo.png" alt="Logo" height="120">
            <div id="h">
                <h1>Football Teams</h1>
            </div>
            <div>
                <form action="Dashboard.php" method="post">
                    <input type="hidden" name="logout" value="true">
                    <button value="Submit" class="sub">logout</button>
                    <br>
                </form>
            </div>
        </div>
    </header>

    <legend>
        <h1>Create New Team</h1>
    </legend>

    <nav>
        <ul>
            <li><a href="Dashboard.php"><button class="sub">Dashboard</button></a><br></li>
            <li><a href="creteam.php"><button class="sub">Create New Team</button></a><br></li>
            <li><a href="editteam.php"><button class="sub">Edit Team</button></a><br></li>
        </ul>

    </nav>

    <div id="login">
        <form action="creteam.php" method="POST">

            <label for="name">Team Name:</label>
            <input type="text" id="name" name="name" class="input" required placeholder="name"><br>

            <label for="skill_level">Skill Level:</label>
            <input type="number" id="skill_level" name="skill_level" class="input" required placeholder="1-5" min=1 max=5><br>

            <label for="game_day">Game Day:</label>
            <!-- <input type="day" id="game_day" name="game_day" class="input" required placeholder="Day"><br> -->

            <select id="game_day" name="game_day" class="input">
                <option value="sunday">Sunday</option>
                <option value="monday">Monday</option>
                <option value="tuesday">Tuesday</option>
                <option value="wednesday">Wednesday</option>
                <option value="thursday">Thursday</option>
                <option value="friday">Friday</option>
                <option value="saturday">Saturday</option>
            </select>

            <input type="submit" class="sub" value="Submit">
        </form>
        <br>
        <a href="Dashboard.php"><button class="sub">Dashboard</button></a>

    </div>

    <footer>
        <img src="logo.png" alt="Logo" height="80">
        <label>Birzeit, Ramallah</label>
        <label>&copy; Copyright 2023 Abudayeh</label>
        <a href="contact.php"><button id="us">Contact Us</button></a>
        <a href="/index.html"><button id="us">About US</button></a>

    </footer>
</body>

</html>

<?php
require_once 'db.php';
session_start();

if (isset($_POST['name']) && isset($_POST['skill_level']) && isset($_POST['game_day'])) {
    $name = $_POST['name'];
    $skill_level = $_POST['skill_level'];
    $game_day = $_POST['game_day'];
    $email = $_SESSION['email'];

    // if ($password === $conpassword) {
    // if (strlen($password) > 6) {
    $stmt = $pdo->prepare("INSERT INTO `team`(`name`, `skill_level`, `game_day`, `email`) VALUES (:name, :skill_level, :game_day, :email)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':skill_level', $skill_level);
    $stmt->bindParam(':game_day', $game_day);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    header("location:Dashboard.php");
    exit();
    // } else {
    // echo "password 8 char min!";
    // }
    // } else {
    //     echo "Password and Confirm Password do not match!";
    // }
}

?>