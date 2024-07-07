<?php 
    require_once('DatabaseHelper.php');

    $database = new DatabaseHelper();
    $username = '';
    if(isset($_POST['username'])){
        $username =  htmlspecialchars($_POST['username']);
    }
    $pwd = '';
    if(isset($_POST['password'])){
        $pwd = htmlspecialchars($_POST['password']);
    }
        $hash = '';
        $hash = $database->gethash($username);
        if(password_verify($pwd, $hash)) {
            setcookie("username",$username);
            setcookie("password",$pwd);
            header("location:index.php");
        } else {
            header("location:logInForm.php");
            setcookie("unauthorized",1);
        }

    ?>