<?php

declare(strict_types=1);

require_once('vendor/autoload.php');
include 'deployDatabase.php';

session_start();
if (!isset($_SESSION['username'])) {
    header('location:login.php');
}

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$db_host = $_ENV['DB_HOST'];
$db_name = $_ENV['DB_NAME'];
$db_user = $_ENV['DB_USER'];
$db_pass = $_ENV['DB_PASS'];

$submissions_table = $_ENV['SUBMISSIONS_TABLE'];

$submissions_path = $_ENV['SUBMISSIONS_PATH'];
//$SUBMISSIONS_path = $submissions_path;
$sessionuser = $_SESSION['username'];

try {
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
} catch (PDOException $e) {
    echo $e->getMessage();
    echo "<br /><blockquote>This error is probably caused by a wrong database configuration. Check your .env file (username, password, database name, etc.)</blockquote>";
    exit();
}
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

if (isset($_POST['submit'])) {
    $exercise_number = $_POST['exercise_number'];
    $programming_language = $_POST['programming_language'];
    $check = getimagesize($_FILES["file"]["tmp_name"]);

    /* N
    $fileName = $_FILES['file']['name'];
    $fileSize = $_FILES['file']['size'];
    $fileTmpName  = $_FILES['file']['tmp_name'];
    $fileType = $_FILES['file']['type']; 
    echo "data are : $submissions_table, $exercise_number,$programming_language";
    */
    //UPDATE TABLE SET col1 = val1, col2=val2... WHERE col1 = val ;exp:
    //$sql = "UPDATE product_list SET product_name = '$product_name', 
    //product_category = '$product_category' WHERE product_id = $product_id";
    //original statement:
    echo "user= $sessionuser";
    //$sql = "Select * from `registration` where username='$sessionuser'";
    //$Sql = "INSERT INTO `registration` WHERE `username` =`$sessionuser` (exercise_number, programming_language) VALUES ('$exercise_number','$programming_language') ";
    $sql = "UPDATE registration SET exercise_number=$exercise_number, programming_language='$programming_language', file_path='$target_file' WHERE username = '$sessionuser'";
    //$result = mysqli_query($con, $sql);
    $stmt = $db->prepare($sql);
    echo '  stop 0 -';


    mysqli_query($con, $sql);
    $con->query($sql);
    try {
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                echo "The file " . htmlspecialchars(basename($_FILES["file"]["name"])) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        echo ("arrived here at stop1 $stmt->rowCount()");
        $stmt->execute([
            'useername' => $sessionuser,
            'exercise_number' => $exercise_number,
            'programming_language' => $programming_language,
            'file_path' => $target_file
        ]);
        echo '  stop 2 -';

        /* old code problem with movefile
        $uploadPath =  $submissions_path . basename($fileName);
        echo "upl-path: $uploadPath   - and the directory exists ?";
        // check target directory:
        echo (is_dir('/tmp'));
        // check existence of file:
        echo "Upload: " . $_FILES["file"]["name"] . "<br>";
        echo "Type: " . $_FILES["file"]["type"] . "<br>";
        echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
        echo "Stored in: " . $_FILES["file"]["tmp_name"];
        if ($_FILES["file"]["error"] > 0) {
            echo "Apologies, an error has occurred.";
            echo "Error Code: " . $_FILES["file"]["error"];
        } else {
            move_uploaded_file($_FILES["file"]["tmp_name"], '/tmp/' . $_FILES["file"]["name"]);
        }
        if (is_file($fileTmpName)) {
            echo ('tmpName file exists');
        } else {
            echo ('tpname nooo file');
        }
        if (is_file($uploadPath)) {
            echo ('uploadpath file exists');
        } else {
            echo ('uploadpath nooo file');
        } 

        // move uploaded file
        move_uploaded_file($fileTmpName, $uploadPath);
        $stmt->execute([
            'useername' => $sessionuser,
            'exercise_number' => $exercise_number,
            'programming_language' => $programming_language,
            'file_path' => $uploadPath
        ]);
        echo "uploadpath is $uploadPath    ";
        echo 'file stored';
        */
        if ($stmt->rowCount() > 0) {
            echo 'Submission successful! Please wait for redirection...';
            echo '<meta http-equiv="refresh" content="1;url=index.php" />';
        } else {
            echo 'Submission failed! Please try again. Redirecting2...';
            echo '<meta http-equiv="refresh" content="2;url=index.php" />';
        }
    } catch (PDOException $e) {
        echo 'Submission failed! Please try again. Redirecting1...';
        echo '<meta http-equiv="refresh" content="2;url=index.php" />';
        exit();
    }
}
