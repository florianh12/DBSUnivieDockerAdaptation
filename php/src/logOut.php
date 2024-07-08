<?php
setcookie("username", "", time() - 3600);
setcookie("password", "", time() - 3600);
if(isset($_COOKIE["unauthorized"])) {
    setcookie("unauthorized", "", time() - 3600);
}
header("location:logInForm.php");
?>