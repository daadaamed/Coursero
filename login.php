<?php
$login = 0;
$invalid = 0;
$vldpsw = 0;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $SUBMISSIONS_table = $_ENV['registration_TABLE'];

    //$SUBMISSIONS_path = $_ENV['registration_PATH'];

    require_once('vendor/autoload.php');
    include 'deployDatabase.php';
    // hashed psw: 
    $username = $_POST['username'];
    $password = $_POST['password'];
    // new
    $raw_password = $_POST['password'];
    $res = $con->query("SELECT password FROM registration WHERE username= '$username'");
    $hashed_password = $res->fetch_assoc()['password'];
    if (!password_verify($raw_password, $hashed_password)) {
        //bc we used password_hash fct to encode psw; we have to use password_verify fct to compare the raw psw with the encoded one
        // the fct returns true or false but we cannot convert back a hashed psw  
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Invalid Data</strong> .
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>';
    } else {
        echo 'your password is valid';
        $vldpsw = 1;
    }
    //end new
    /*$sql = "insert into `registration`(username,password) values('$username','$password')";

    $result = mysqli_query($con, $sql);
    if ($result) {
        echo "Data inserted successfully";
    } else {
        die(mysqli_error($con));
    } */
    $sql = "Select * from `registration` where username='$username'";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $num = mysqli_num_rows($result);
        if ($num > 0 && $vldpsw == 1) {
            //echo 'login success';
            $login = 1;
            session_start();
            $_SESSION['username'] = $username;
            header('location:index.php');
        } else {
            //echo 'invalid data';
            $invalid = 1;
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
    <?php
    if ($login) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
<strong>Success login!</strong> .
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>';
    }
    ?>

    <?php
    /*
    if ($invalid) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
<strong>Invalid data!</strong> .
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>';
    }*/
    ?>

    <h1 class='text-center'>Login To upload your file or check your grade</h1>
    <div class="container mt-5">
        <form action='login.php' method='POST'>
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
                <button type="submit" class="btn btn-primary mb-3">Login</button>
            </div>
        </form>
        <div class='col-auto'>
            <a href='sign.php' class='btn btn-primary mt-3'>Haven't signed up yet?</a>
        </div>
    </div>

</body>

</html>