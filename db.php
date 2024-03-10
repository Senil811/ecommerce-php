<?php
$host = "localhost"; // Replace with your actual database host
$db_name = "ecommerce"; // Replace with your actual database name
$username = "ecommerce"; // Replace with your actual database username
$password = "Admin#88665"; // Replace with your actual database password

try {
    $pdo = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}
?>
