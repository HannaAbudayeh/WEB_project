<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['teamname']) && isset($_POST['delete'])) {
        $teamName = $_POST['teamname'];

        try {
            $stmt = $pdo->prepare("DELETE FROM player WHERE team_name = :teamname");
            $stmt->execute(['teamname' => $teamName]);

            $stmt = $pdo->prepare("DELETE FROM team WHERE name = :teamname");
            $stmt->execute(['teamname' => $teamName]);

            // $rowCount = $stmt->rowCount();
            // if ($rowCount > 0) {
            //     echo "<p>Team Deleted Successfully</p>";
            // } else {
            //     echo "<p>No team found</p>";
            // }
        } catch (PDOException $e) {
            echo "<p>Failed to delete team: " . $e->getMessage() . "</p>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Details</title>
    <link rel="stylesheet" href="login.css">

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
    <!-- <p>
        <strong>Added Players:</strong>
    </p><br> -->
    <?php
    if (isset($_GET['name'])) {
        $teamName = $_GET['name'];

        $stmt = $pdo->prepare("SELECT * FROM team WHERE name = :teamname");
        $stmt->execute(['teamname' => $teamName]);
        $team = $stmt->fetch();

        // $stmt->bindParam(':teamname', $teamName);
        // $stmt->execute();

        // $sql = "SELECT * FROM team WHERE `name` = :teamname";
        // $result = $pdo->query($sql);
        // $row = $result->fetch();
        // $_SESSION['teamm'] = $row['name'];

        if ($team !== false) {
            $_SESSION['teamName'] = $teamName;

            echo "<h1>Team Details for: " . $team['name'] . "</h1>";
            echo "<p>Skill Level: " . $team['skill_level'] . "</p>";
            echo "<p>Gameday: " . $team['game_day'] . "</p>";
            echo "<p>Players:</p>";

            $stmt = $pdo->prepare("SELECT * FROM player WHERE team_name = :teamname");
            $stmt->execute(['teamname' => $teamName]);
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
    <nav>
        <ul>
            <li><a href="Dashboard.php"><button class="sub">Dashboard</button></a><br></li>
            <li><a href="creteam.php"><button class="sub">Create New Team</button></a><br></li>
            <li><a href="editteam.php"><button class="sub">Edit Team</button></a><br></li>
        </ul>

    </nav>

    <div id="login">
        <form action="addplayer.php?name=<?php echo $teamName; ?>" method="POST">
            <label for="player">Player Name:</label>
            <input type="text" id="name" name="player" class="input" required placeholder="player name"><br>
            <input type="submit" class="sub" value="ADD">
        </form>
        <br>
        <!-- <a href="Dashboard.php"><button class="sub">Dashboard</button></a> -->

    </div>

    </form>
    <div class="container">
        <form action="addplayer.php?name=<?php echo $teamName; ?>" method="post">
            <input type="hidden" name="teamname" value="<?php echo $teamName; ?>">
            <button type="submit" name="delete" class="sub">Delete</button>
        </form>
    </div>

    <footer>
        <img src="logo.png" alt="Logo" height="80">
        <label>Birzeit, Ramallah</label>
        <label>&copy; Copyright 2023 Abudayeh</label>
        <a href="contact.php"><button id="us">Contact Us</button></a>
        <a href="/index.html"><button id="us">About US</button></a>

    </footer>

</body>

<?php
if (isset($_POST['player'])) {
    $player = $_POST['player'];

    $stmt = $pdo->prepare("SELECT COUNT(*) AS player_count FROM player WHERE team_name = :teamname");
    $stmt->execute(['teamname' => $teamName]);
    $playerCount = $stmt->fetchColumn();

    if ($playerCount < 9) {
        $teamName = $_SESSION['teamName'];

        $stmt = $pdo->prepare("INSERT INTO player (player_name, team_name) VALUES (:player, :teamname)");
        $stmt->bindParam(':player', $player);
        $stmt->bindParam(':teamname', $teamName);
        $stmt->execute();
        echo "<p>Player added successfully.</p>";

        header("Location:addplayer.php?name=$teamName");
        exit();
    } else {
        echo "<p class=error>Maximum number of players (9) reached. Cannot add more players.</p>";
    }
}
?>