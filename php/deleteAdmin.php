<?php

require_once('DatabaseHelper.php');

header('Content-type: text/html; charset=utf-8');

$database = new DatabaseHelper();


if(isset($_COOKIE['username']) && isset($_COOKIE['password']) && password_verify($_COOKIE['password'], $database->gethash($_COOKIE['username']))) {
    ;
} else {
    header("location:logInForm.php");
}

if(sizeof($database->selectAllAdmins()) < 2) {
    header("location:removeAdminForm.php");
}

$todelete = '';
if(isset($_GET['Delete'])) {
    $todelete = htmlspecialchars($_GET['Delete']);
}

$database->deleteAdministrator($todelete);

if($todelete == $_COOKIE['username']) {
    header("location:logOut.php");
} else {
    header("location:removeAdminForm.php");
}

?>