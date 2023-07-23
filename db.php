<?php
$host = 'localhost';
$dbname = 'c29hanna';
$username = 'c29hanna';
$password = 'web1200085';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    error_reporting(E_ERROR | E_PARSE);
} catch (PDOException $e) {
    die("Failed to connect to database: " . $e->getMessage());
}
