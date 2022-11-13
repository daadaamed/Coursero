<?php

declare(strict_types=1);

require_once('vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$db_host = $_ENV['DB_HOST'];
$db_name = $_ENV['DB_NAME'];
$db_user = $_ENV['DB_USER'];
$db_pass = $_ENV['DB_PASS'];

$submissions_table = $_ENV['SUBMISSIONS_TABLE'];

// create database if it doesn't exist
try {
    $db = new PDO("mysql:host=$db_host", $db_user, $db_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE IF NOT EXISTS $db_name";
    $db->exec($sql);
} catch (PDOException $e) {
    echo $e->getMessage();
    echo "<br /><blockquote>This error is probably caused by a wrong database configuration. Check your .env file (username, password, database name, etc.)</blockquote>";
    exit();
}

// create submissions table if it doesn't exist
try {
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE IF NOT EXISTS $submissions_table (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name varchar(255) NOT NULL,
        exercise_number INT NULL,
        programming_language varchar(100) NULL,
        file_path varchar(255) NULL,
        grade FLOAT NULL
    )";
    $db->exec($sql);
} catch (PDOException $e) {
    echo $e->getMessage();
    echo "<br /><blockquote>This error is probably caused by a wrong database configuration. Check your .env file (username, password, database name, etc.)</blockquote>";
    exit();
}
