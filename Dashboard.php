<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="login.css">
    <link rel="icon" href="https://img.icons8.com/?size=512&id=5o4nx545fgaw&format=png" type="image/x-icon" />
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

        <!-- <div>
            <form action="Dashboard.php" method="post">
                <input type="hidden" name="logout" value="true">
                <button value="Submit" class="sub">logout</button>
                <br>
            </form>
        </div> -->
    </header>
    <h1>Welcome <?php echo $_SESSION['user_name'] ?></h1>

    <nav>
        <ul>
            <li><a href="Dashboard.php"><button class="sub">Dashboard</button></a><br></li>
            <li><a href="creteam.php"><button class="sub">Create New Team</button></a><br></li>
            <li><a href="editteam.php"><button class="sub">Edit Team</button></a><br></li>
        </ul>

    </nav>

    <div id="dash">
        <?php
        require_once 'db.php';

        $stmt = $pdo->prepare("SELECT * FROM team");
        $stmt->execute();
        $teams = $stmt->fetchAll();




        echo "<table>";
        echo "<caption>Teams Table</caption>";
        echo "<tr>";
        echo "<th>Team Name</th>";
        echo "<th>Skill Level</th>";
        // echo "<th>players</th>";
        echo "<th>Game Day</th>";
        echo "</tr>";
        foreach ($teams as $team) {
            $mm = $team['name'];
            echo "<tr>";
            echo "<td><a href='addplayer.php?name=$mm'>" . $team['name'] . "</a></td>";
            echo "<td>" . $team['skill_level'] . "</td>";
            // echo "<td>" . $team['players'] . "</td>";
            echo "<td>" . $team['game_day'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";

        ?>

        <a href="creteam.php"><button class="sub">create team</button></a>
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

if (isset($_POST["logout"]) && $_POST["logout"] === "true") {
    unset($_SESSION['Email']);
    unset($_SESSION['pass']);
    header('Location:index.php');
    exit;
}
// if (isset($team['name'])) {

//     $name = validate($_POST['name']);

//     $name = ($_POST['name']);

//     $sql = "SELECT `name` FROM `team` WHERE `name` ='$name' ";
//     $result = $pdo->query($sql);
//     $row = $result->fetch();

//     $_SESSION['team_name'] = $row['name'];
// }
?>