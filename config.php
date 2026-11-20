<?php
session_start();

$host = "sql213.infinityfree.com"; 
$dbname = "if0_43493207_agenda"; 
$username = "if0_43493207"; 
$password = "peBeuX39Cij"; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>