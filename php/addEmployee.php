<?php
require_once('DatabaseHelper.php');

$database = new DatabaseHelper();

if(isset($_COOKIE['username']) && isset($_COOKIE['password']) && password_verify($_COOKIE['password'],$database->gethash($_COOKIE['username']))) {
    ;
} else {
    header("location:logInForm.php");
}

//instantiating all the variables from the Form 
$name = '';
if(isset($_POST['name'])){
    $name = $_POST['name'];
}

$surname = '';
if(isset($_POST['surname'])){
    $surname = $_POST['surname'];
}
$socialsecurity = '';
if(isset($_POST['socialsecurity'])){
    $socialsecurity = $_POST['socialsecurity'];
}
$telephone = '';
if(isset($_POST['telephone'])){
    $telephone = $_POST['telephone'];
}
$jobdescr = '';
if(isset($_POST['jobdescr'])){
    $jobdescr = $_POST['jobdescr'];
}
$street = '';
if(isset($_POST['street'])){
    $street = $_POST['street'];
}
$house = '';
if(isset($_POST['house'])){
    $house = $_POST['house'];
}
$complex = '';
if(isset($_POST['complex'])){
    $complex = $_POST['complex'];
}
$door = '';
if(isset($_POST['door'])){
    $door = $_POST['door'];
}
$zip = '';
if(isset($_POST['zip'])){
    $zip = $_POST['zip'];
}
$type = '';
if(isset($_POST['type'])){
    $type = $_POST['type'];
}

$rank = '';
if(isset($_POST['rank'])){
    $rank = $_POST['rank'];
}
$department = '';
if(isset($_POST['department'])){
    $department = $_POST['department'];
}
$sector = '';
if(isset($_POST['sector'])){
    $sector = $_POST['sector'];
}
$commandingofficer = '';
if(isset($_POST['commandingofficer'])){
    $commandingofficer = $_POST['commandingofficer'];
}

$jtitle = '';
if(isset($_POST['jtitle'])){
    $jtitle = $_POST['jtitle'];
}
$jobexperience = '';
if(isset($_POST['jobexperience'])){
    $jobexperience = $_POST['jobexperience'];
}
$jobexperiencetime = '';
if(isset($_POST['jobexperiencetime'])){
    $jobexperiencetime = $_POST['jobexperiencetime'];
}
$court = '';
if(isset($_POST['jcourt'])){
    $court = $_POST['jcourt'];
}

$ptitle = '';
if(isset($_POST['ptitle'])){
    $ptitle = $_POST['ptitle'];
}
$party = '';
if(isset($_POST['party'])){
    $party = $_POST['party'];
}
$senate = '';
if(isset($_POST['psenate'])){
    $senate = $_POST['psenate'];
}


//Select correct insert-statement, according to type
if($type == "soldier") {
$success = $database->insertIntoSoldier($name, $surname, $socialsecurity, $telephone, $jobdescr, $street, $house, $complex, $door, $zip, $rank, $department, $sector, $commandingofficer);
}

if($type == "judicialofficer") {
    $success = $database->insertIntoJudicialOfficer($name, $surname, $socialsecurity, $telephone, $jobdescr, $street, $house, $complex, $door, $zip, $jtitle, $jobexperience, $jobexperiencetime, $court);
}

if($type == "politician") {
	$success = $database->insertIntoPolitican($name, $surname, $socialsecurity, $telephone, $jobdescr, $street, $house, $complex, $door, $zip, $ptitle, $party, $senate);
}


if($success) {
    echo "<script>";
    echo "alert(\"New Employee successfully added!\");";
    echo "window.location.href = \"addEmployeeForm.php\"";
    echo "</script>";
} else {
    echo "<script>";
    echo "alert(\"Error: Employee couldn't be added!\");";
    echo "window.location.href = \"addEmployeeForm.php\"";
    echo "</script>";
}
?>