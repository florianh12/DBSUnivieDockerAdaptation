<?php 
    require_once('DatabaseHelper.php');

    $database = new DatabaseHelper();

    if(isset($_COOKIE['username']) && isset($_COOKIE['password']) && password_verify($_COOKIE['password'], $database->gethash($_COOKIE['username']))) {
        ;
    } else {
        header("location:logInForm.php");
    }

    $username = '';
    if(isset($_POST['username'])){
        $username =  htmlspecialchars($_POST['username']);
    }
    $pwd = '';
    if(isset($_POST['password'])){
        $pwd = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);
    }
        $success = $database->registerUser($username, $pwd);
        if($success) {
            echo "<script>alert(\"Registered!\"); window.location.href = \"index.php\";</script>";
            
        } else {
            echo "<script>alert(\"An Error has occured!\");window.location.href = \"index.php\";</script>";
        }
    ?>