<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Profile</title>
    <link rel="stylesheet" href="login.css">
    <link rel="icon" href="https://img.icons8.com/?size=512&id=hndYUwgoKgLS&format=png" type="image/x-icon" />

</head>

<body>
    <legend>
        <h1>Create Profile</h1>
    </legend>
    <div id="login">
        <form action="cre.php" method="POST">

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" class="input" required placeholder="name"><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="input" required placeholder="email@email.com"><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" class="input" required placeholder="password"><br>

            <label for="conPassword">Confirm Password:</label>
            <input type="password" id="conPassword" name="conPassword" class="input" required placeholder="Confirm Password"><br>

            <input type="submit" class="sub" value="Create Profile">
        </form>
        <p>Already a member? <a href="index.php"><button class="sub">Login</button></a></p>

    </div>


</body>

</html>

<?php
require_once 'db.php';
session_start();

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