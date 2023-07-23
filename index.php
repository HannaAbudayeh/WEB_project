<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="login.css">
    <link rel="icon" href="https://img.icons8.com/?size=512&id=Hm0e3BaO54rH&format=png" type="image/x-icon" />

</head>

<body>
    <header>

        <div class="container">
            <img src="logo.png" alt="Logo" height="120">
            <div id="h">
                <h1>Football Teams</h1>
            </div>

        </div>
    </header>
    <!-- <h1>Login</h1> -->
    <div id="login">
        <form action="index.php" method="post">
            <label>Email:</label>
            <input type="email" class="input" name="email" required=""><br>

            <label>Password:</label>
            <input type="password" class="input" name="password" required=""><br>

            <input type="submit" class="sub" value="Login">
        </form>

        <p>Don't have a profile? <a href="cre.php"><button class="sub">Create Profile</button></a></p>
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
if (isset($_POST['email']) && isset($_POST['password'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $email = validate($_POST['email']);
    $password = validate($_POST['password']);

    if (empty($email)) {
        header("location: index.php?error=email is required");
        exit();
    } else if (empty($password)) {
        header("location: index.php?error=password is required");
        exit();
    } else {
        $stmt = $pdo->prepare("SELECT * from user WHERE email ='$email' AND password='$password'");
        $stmt->execute();

        $sql = "SELECT `name` FROM `user` WHERE email ='$email' AND password='$password'";
        $result = $pdo->query($sql);
        $row = $result->fetch();

        // $nname = $stmt->fetchAll();
        //         $pdo->prepare("SELECT `name` FROM `user` WHERE email ='$email' AND password='$password'");
        // $nname->execute();

        $_SESSION['user_name'] = $row['name'];
        $_SESSION['email'] = $email;

        if ($stmt->rowCount() > 0) {
            header("location: Dashboard.php");
            exit();
        } else {
            header("location: index.php?error=Incorrect email or password");
            exit();
        }
    }
}
?>