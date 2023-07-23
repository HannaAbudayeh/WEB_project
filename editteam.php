<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Player</title>
    <link rel="stylesheet" href="login.css">
    <link rel="icon" href="https://img.icons8.com/?size=512&id=hndYUwgoKgLS&format=png" type="image/x-icon" />

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
        <h1>Editing <?php echo $_SESSION['team_name'] ?> Team</h1>
    </legend>
    <nav>
        <ul>
            <li><a href="Dashboard.php"><button class="sub">Dashboard</button></a><br></li>
            <li><a href="creteam.php"><button class="sub">Create New Team</button></a><br></li>
            <li><a href="editteam.php"><button class="sub">Edit Team</button></a><br></li>
        </ul>

    </nav>
    <?php
    require_once 'db.php';

    if (isset($_GET['name'])) {
        $team_name = $_GET['name'];

        $stmt = $pdo->prepare("SELECT * FROM team WHERE `name` = :team_name");
        $stmt->execute(['team_name' => $team_name]);
        $team = $stmt->fetch();

        if ($team !== false) {
            $_SESSION['team_name'] = $team_name; // تخزين اسم الفريق في الجلسة

            echo "<h1>Team Details for: " . $team['name'] . "</h1>";
            echo "<p>Skill Level: " . $team['skill_level'] . "</p>";
            echo "<p>Gameday: " . $team['game_day'] . "</p>";
            echo "<p>Players:</p>";

            // Retrieve and display players
            $stmt = $pdo->prepare("SELECT * FROM player WHERE `name` = :team_name");
            $stmt->execute(['team_name' => $team_name]);
            $players = $stmt->fetchAll();

            if (!empty($players)) {
                echo "<ul>";
                foreach ($players as $player) {
                    echo "<li>" . $player['player_name'] . "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No players found.</p>";
            }
        } else {
            echo "<p>No team found with the provided name.</p>";
        }
    }

    ?>

    <div id="login">
        <form action="addplayer.php" method="POST">

            <label for="name">Player Name:</label>
            <input type="text" id="name" name="name" class="input" required placeholder="player name"><br>

            <input type="submit" class="sub" value="ADD">
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

if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['conPassword'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $conpassword = $_POST['conPassword'];

    if ($password === $conpassword) {
        if (strlen($password) >= 8) {
            $stmt = $pdo->prepare("INSERT INTO `user` (`name`, `email`, `password`) VALUES (:name, :email, :password)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
            header("location: index.php");
            exit();
        } else {
            echo "password 8 char min!";
        }
    } else {
        echo "Password and Confirm Password do not match!";
    }
}

?>