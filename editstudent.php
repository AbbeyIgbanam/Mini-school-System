<?php
session_start();
//Database connection file
include("inc/config.php");

//Take user to login if they are not logged in
if(!(isset($_SESSION['userid']))){
   echo "<script>location ='login.php'</script>";
}

$fullname="";
$dob="";
$level ="";
$passport="";
$id= "";
//Get the student data using the studentid sent using get request

if(isset($_GET['studentid'])){
    $id= $_GET['studentid'];
    $sql= mysqli_query($connection, "SELECT * FROM student Where id='$id'");

    while($row = mysqli_fetch_assoc($sql)){
        $fullname = $row['fullname'];
        $dob = $row['dob'];
        $level = $row['level'];
        $passport = $row['passport'];

    }
}

$success="";
$error= array();

//if form is submitted
if(isset($_POST['submit'])){
    $fullname = mysqli_real_escape_string($connection,$_POST['fullname']);
    $dob = mysqli_real_escape_string($connection,$_POST['dob']);
    $level = mysqli_real_escape_string($connection,$_POST['level']);
    $id = mysqli_real_escape_string($connection,$_POST['id']);
    
    
    //file name with a random number so thet similar dont get replace
    $passport= rand(1000,10000). "-". $_FILES["file"]["name"];

    //Allowed file
    $allowed= array ("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif"=> "image/jpg","png"=> "image/jpg");
    
    //Extension
    $extension = pathinfo($passport, PATHINFO_EXTENSION);
    #temporary name to store file
    $tname = $_FILES["file"]["tmp_name"];

    #upload size
    $filesize= $_FILES["file"]["size"];

    #max Size
    $maxsize = 1 * 1024 * 1024; //1mb
    
    //let check errors in the fields
    if(empty($fullname)){
        array_push($error, "fullname cannot be empty");
    }
    if(empty($dob)){
        array_push($error, "Date of Birth cannot be empty"); 
    }
    if(empty($level)){
        array_push($error, "Level cannot be empty");
    }
    if(!array_key_exists($extension,$allowed)){
        array_push($error,"Only jpg,png, and jpeg files are allowed");
    }
    if($filesize > $maxsize){
        array_push($error, "image size is too large, imges should be less than 1mb");
    }
    //if there are no errors in the form then continue
    if(count($error)==0){
        //move updated file to specific location
        move_uploaded_file($tname, "upload/" .$passport);
    }

    //Update into the database
    $update ="UPDATE student set fullname='$fullname', dob= '$dob', level= '$level', passport= '$passport' WHERE id= '$id'";

    if(mysqli_query($connection, $update)){
        $success ="<div class= 'text-success text-center'> Data updated</div>";
    }else{
        $success = "<span class='text-danger'>failed</span>";
    }
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
        <div class="col-md-8 offset-md-2 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="st_form" autocomplete="off" enctype="multipart/form-data">
                        <h3 class="text-center">Edit Student</h3>
                        <?php echo $success; ?>
                        <?php
                        foreach($error as $errors){
                            echo "<p class='text-danger text-center'>" .$errors. "<br> </p>";
                        }
                        ?>
                        
                        <div class="form-group">
                        <img src="upload/<?php echo $passport?>" class="img-fluid">
                        </div>

                        <div class="form-group">
                        <label for="fullname">fullname:</label>
                        <input type="text" name="fullname" value="<?php echo $fullname?>" class="form-control" required>
                        <input type="hidden" name="id" value="<?php echo $id?>" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="dob">Date of Birth:</label>
                            <input type="date" name="dob" value="<?php echo $dob?>" class="form-control" required>
                        
                        </div>

                        <div class="form-group">
                        <label for="level">Level:</label>
                        <select name="level" class="form-control">
                            <option value="100">100 Level</option>
                            <option value="200">200 Level</option>
                            <option value="300">300 Level</option>
                        </select>
                        
                        </div>
                        <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="file" accept="image/*" name="file" class="form-control" required>
                        </div>

                        <div class="form-group text-center">
                        <input type="submit" name="submit" value="Add Student" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script src="https://code.jquery.com/jquery.3.5.1.slim.min.js"></script>
<script src ="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src ="https://cdn.jsdelivr.net/npm/boostrap@4.6.0/dist/js/boostrap.min.js"></script>

    
</body>
</html>

