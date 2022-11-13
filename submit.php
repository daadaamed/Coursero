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

$submissions_path = $_ENV['SUBMISSIONS_PATH'];

try {
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
} catch (PDOException $e) {
    echo $e->getMessage();
    echo "<br /><blockquote>This error is probably caused by a wrong database configuration. Check your .env file (username, password, database name, etc.)</blockquote>";
    exit();
}


if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $exercise_number = $_POST['exercise_number'];
    $programming_language = $_POST['programming_language'];
    $fileName = $_FILES['file']['name'];
    $fileSize = $_FILES['file']['size'];
    $fileTmpName  = $_FILES['file']['tmp_name'];
    $fileType = $_FILES['file']['type'];

    $sql = "INSERT INTO $submissions_table (name, exercise_number, programming_language, file_path) VALUES (:name, :exercise_number, :programming_language, :file_path)";
    $stmt = $db->prepare($sql);

    try {
        $uploadPath =  $submissions_path . basename($fileName);
        move_uploaded_file($fileTmpName, $uploadPath);
        $stmt->execute([
            'name' => $name,
            'exercise_number' => $exercise_number,
            'programming_language' => $programming_language,
            'file_path' => $uploadPath
        ]);

    } catch (PDOException $e) {
        echo 'Submission failed! Please try again. Redirecting...';
        echo '<meta http-equiv="refresh" content="2;url=index.php" />';
        exit();
    }

    if ($stmt->rowCount() > 0) {
        echo 'Submission successful! Please wait for redirection...';
        echo '<meta http-equiv="refresh" content="1;url=index.php" />';
    } else {
        echo 'Submission failed! Please try again. Redirecting...';
        echo '<meta http-equiv="refresh" content="2;url=index.php" />';

    }

}
