<?php
include('database.php');
if (isset($_POST["create"])) {
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    
    
    $sqlInsert = "INSERT INTO tbluser(name , username , email) VALUES ('$name','$email')";
    if(mysqli_query($conn,$sqlInsert)){
        session_start();
        $_SESSION["create"] = "Book Added Successfully!";
        header("Location:index.php");
    }else{
        die("Something went wrong");
    }
}
if (isset($_POST["edit"])) {
    $name = mysqli_real_escape_string($mysqli, $_POST["name"]);
    $email = mysqli_real_escape_string($mysqli, $_POST["email"]);
   
    
    $id = mysqli_real_escape_string($mysqli, $_POST["id"]);
    $sqlUpdate = "UPDATE tbluser SET name = '$name',    email = '$email' WHERE id='$id'";
    if(mysqli_query($mysqli,$sqlUpdate)){
        session_start();
        $_SESSION["update"] = "Book Updated Successfully!";
        header("Location:Dashboard_admin.php");
    }else{
        die("Something went wrong");
    }
}
?>