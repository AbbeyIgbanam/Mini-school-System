<?php
session_start();
//Database connection file
include("inc/config.php");

//Take user to login if they are not logged in
if(!(isset($_SESSION['userid']))){
   echo "<script>location ='login.php'</script>";
}

//Get the student data using the studentid sent using get request
if(isset($_GET['studentid'])){
    $id= $_GET['studentid'];
    $sql= mysqli_query($connection, "DELETE FROM student Where id='$id'");
    
    echo "<script>location='allstudent.php'</script>";
}
?>