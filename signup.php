<?php
// I have to hash the PSW !!!!!
$success = 0;
$user = 0;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    require_once('vendor/autoload.php');
    require_once('deployDatabase.php');
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (!empty(trim($_POST['password'])) && !empty(trim($_POST['username']))) {
        /*$sql = "insert into `registration`(username,password) values('$username','$password')";

    $result = mysqli_query($con, $sql);
    if ($result) {
        echo "Data inserted successfully";
    } else {
        die(mysqli_error($con));
    } */

        $enc_password = password_hash($password, PASSWORD_DEFAULT);
        // this is a function that creates a password hash, takes 2 param: psw and the algorithm
        $sql = "Select * from `registration` where username='$username'";
        $result = mysqli_query($con, $sql);
        if ($result) {
            $num = mysqli_num_rows($result);
            if ($num > 0) {
                //echo "user already exist";
                $user = 1;
            } else {
                $sql = "insert into `registration`(username,password) values('$username','$enc_password')";

                $result = mysqli_query($con, $sql);
                if ($result) {
                    //echo "Signup successfully";
                    $success = 1;
                    header('location:login.php');
                } else {
                    die(mysqli_error($con));
                }
            }
        }
    } else { // else display error
        //echo 'empty';
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>username or password is empty</strong> Cannot be empty
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>

    <?php
    if ($user) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>User existed!</strong> Change username.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
    }
    ?>
    <?php
    if ($success) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Success!</strong> .
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
    }
    ?>
    <h1 class='text-center'>Sign up to upload your file</h1>
    <div class="container mt-5">
        <form action='signup.php' method='POST'>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="col-sm-10">Name</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" name='username'>
            </div>
            <div class="mb-3">
                <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                <div class="col-auto">
                    <input type="password" class="form-control" id="inputPassword" name="password">
                </div>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-3">Sign up</button>
            </div>
        </form>

    </div>

</body>

</html>