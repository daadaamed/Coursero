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

try {
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
} catch (PDOException $e) {
    echo $e->getMessage();
    echo "<br /><blockquote>This error is probably caused by a wrong database configuration. Check your .env file (username, password, database name, etc.)</blockquote>";
    exit();
}

if (!isset($_GET['name'])) {
    echo 'No name provided! Redirecting...';
    echo '<meta http-equiv="refresh" content="1;url=index.php" />';
    exit();
}
try {
    $statement = $db->query("SELECT * FROM $submissions_table WHERE name = '{$_GET['name']}'");
    $grades = $statement->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo $e->getMessage();
    exit();
}

?>

<html lang="en-EN">
<head>
    <title>3LPIC</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"></head>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">COURSERO</a>
    </nav>

    <br />

    <button type="button" class="btn btn-primary" onclick="window.location.href='index.php'">Go back</button>

    <br />
    <br />

    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Exercise number</th>
            <th scope="col">Programming language</th>
            <th scope="col">Grade</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($grades as $grade): ?>
            <tr>
                <th scope="row"><?= $grade['id'] ?></th>
                <td><?= $grade['exercise_number'] ?></td>
                <td><?= $_ENV['PROGRAMMING_LANGUAGE_'.$grade['programming_language']] ?></td>
                <td><?= $grade['grade'] ?? 'Not graded' ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
