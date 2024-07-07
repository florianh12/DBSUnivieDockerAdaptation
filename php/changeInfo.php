<?php
require_once('DatabaseHelper.php');

$database = new DatabaseHelper();


if(isset($_COOKIE['username']) && isset($_COOKIE['password']) && password_verify($_COOKIE['password'],$database->gethash($_COOKIE['username']))) {
    ;
} else {
    header("location:logInForm.php");
}
//instantiating all the variables from the form
$id='';
if(isset($_POST['changeentry'])) {
    $id = $_POST['changeentry'];
}

//0 == soldier, 1 == judicialofficer, 2 == politician
$etype='';
if(isset($_POST['etype'])) {
    $etype = $_POST['etype'];
}

$name='';
if(isset($_POST['name'])) {
    $name = $_POST['name'];
}

$surname='';
if(isset($_POST['surname'])) {
    $surname = $_POST['surname'];
}

$socialsecurity='';
if(isset($_POST['socialsecurity'])) {
    $socialsecurity = $_POST['socialsecurity'];
}

$telephone='';
if(isset($_POST['telephone'])) {
    $telephone = $_POST['telephone'];
}

$jobdescr='';
if(isset($_POST['jobdescr'])) {
    $jobdescr = $_POST['jobdescr'];
}

$street='';
if(isset($_POST['street'])) {
    $street = $_POST['street'];
}

$house='';
if(isset($_POST['house'])) {
    $house = $_POST['house'];
}

$complex='';
if(isset($_POST['complex'])) {
    $complex = $_POST['complex'];
}

$door='';
if(isset($_POST['door'])) {
    $door = $_POST['door'];
}

$zip='';
if(isset($_POST['zip'])) {
    $zip = $_POST['zip'];
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


//select Table to update based on type
if($etype == 0) {
$success = $database->updateSoldier($id, $rank, $department, $sector, $commandingofficer);
echo "<script>";
echo "if(!{$success}) {alert(\"Error: Changes to Soldier not applied!\");}";
echo "</script>";
}

if($etype == 1) {
    $success = $database->updateJudicialOfficer($id, $jtitle, $jobexperience, $jobexperiencetime, $court);
    echo "<script>";
    echo "if(!{$success}) {alert(\"Error: Changes to JudicialOfficer not applied!\");}";
    echo "</script>";
}

if($etype == 2) {
    echo $id;
    echo $ptitle;
    echo $party;
    echo $senate;
    $success = $database->updatePolitican($id, $ptitle, $party, $senate);
    echo "<script>";
    echo "if(!{$success}) {alert(\"Error: Changes to JudicialOfficer not applied!\");}";
    echo "</script>";
}

//update parent table
$success = $database->updateEmployee($id, $name, $surname, $socialsecurity, $telephone, $jobdescr, $street, $house, $complex, $door, $zip);

//feedback in case of an error
echo "<script>";
echo "if(!{$success}) {alert(\"Error: Changes to Unionemployee not applied!\");}";
echo "window.location.href = \"details.php?Details={$id}\"";
echo "</script>";
?>