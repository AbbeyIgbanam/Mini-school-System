<?php
session_start();

//Datebase connection file
include("inc/config.php");

//Take user to login if they are not logged in
if(!(isset($_SESSION['userid']))){
    echo "<script>location= 'login.php'</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>
    <?php require("inc/nav.php"); ?>

    <div class="row p-5">
        <div class="col-sm-6">
            <div class="card">
                <div class="body">
                <h5 class="card-title">Number of Admin</h5>
                <p class="card-text">
                    <?php
                    $sql = mysqli_query($connection, "SELECT * FROM users");
                    echo mysqli_num_rows($sql);
                    ?>
                </p>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card">
                <div class="body">
                <h5 class="card-title">Number of Student</h5>
                <p class="card-text">
                    <?php
                    $sql = mysqli_query($connection, "SELECT * FROM student");
                    echo mysqli_num_rows($sql);
                    ?>
                </p>
                </div>
            </div>
        </div>

    </div>
    
<script src="https://code.jquery.com/jquery.3.5.1.slim.min.js"></script>
<script src ="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src ="https://cdn.jsdelivr.net/npm/boostrap@4.6.0/dist/js/boostrap.min.js"></script>    


</body>
</html>