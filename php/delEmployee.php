<?php

require_once('DatabaseHelper.php');

$database = new DatabaseHelper();

if(isset($_COOKIE['username']) && isset($_COOKIE['password']) && password_verify($_COOKIE['password'],$database->gethash($_COOKIE['username']))) {
    ;
} else {
    header("location:logInForm.php");
}

$id = '';
if(isset($_POST['id'])){
    $id = $_POST['id'];
}

$officer = '';
if(isset($_POST['officer'])){
    $officer = $_POST['officer'];
}

$etype = '';
if(isset($_POST['etype'])){
    $etype = $_POST['etype'];
}

$database->deleteEmployee($id, $etype, $officer);

    echo "<script>";
    echo "window.location.href = \"searchEmployee.php\"";
    echo "</script>";
?>