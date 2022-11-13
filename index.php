<?php

declare(strict_types=1);

require_once('vendor/autoload.php');
require_once('deployDatabase.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

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

    <div class="container">
        <?php
        require 'exercises.php';
        ?>
        <br />

        <div class="row">
            <div class="col-md-12">
                <fieldset>
                    <legend>Submission:</legend>
                    <form method="POST" action="submit.php" enctype="multipart/form-data">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                Name
                            </span>
                            </div>
                            <input type="text" class="form-control" placeholder="John Doe" aria-label="Username" name="name" aria-describedby="basic-addon1">
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="exercise-number">Exercise number</label>
                            </div>
                            <select class="custom-select" id="exercise-number" name="exercise_number">
                                <option selected>Choose...</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                            </select>
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="programming-language">Programming language</label>
                            </div>
                            <select class="custom-select" id="programming-language" name="programming_language">
                                <option selected>Choose...</option>
                                <option value="1"><?= $_ENV['PROGRAMMING_LANGUAGE_1'] ?></option>
                                <option value="2"><?= $_ENV['PROGRAMMING_LANGUAGE_2'] ?></option>
                            </select>
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Upload</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="file-input" name="file">
                                <label class="custom-file-label" for="file-input">Choose file</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary" name="submit" style="width: 100%">Submit</button>
                    </form>
                </fieldset>

                <fieldset>
                    <legend>Get my results:</legend>
                    <form method="get" action="results.php">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                Search my results by name
                            </span>
                            </div>
                            <input type="text" class="form-control" placeholder="John Doe" aria-label="Username" name="name" aria-describedby="basic-addon1">
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%">Search</button>
                    </form>
                </fieldset>
            </div>
        </div>
    </div>
</body>
<body>

