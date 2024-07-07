<?php
require_once('DatabaseHelper.php');

header('Content-type: text/html; charset=utf-8');

$database = new DatabaseHelper();

if(isset($_COOKIE['username']) && isset($_COOKIE['password']) && password_verify($_COOKIE['password'],$database->gethash($_COOKIE['username']))) {
    ;
} else {
    header("location:logInForm.php");
}

//get specific data for Employee with id from searchEmployee
$person_array = $database->selectEmployeeByID($_GET['Details']);
?>

<script>
	function confirmation() {

			return confirm("Do you really wish to delete this Unionemployee?");
	}
</script>

<html>
	<head>
	<link rel = 'icon' type='image/x-icon' href = 'logo.ico' >
	<title><?php print $person_array[0][0]['FIRSTNAME'].' '.$person_array[0][0]['SURNAME'];?></title>

	<meta charset="utf-8">
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
	integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous"> 
	<link rel="stylesheet" href="style.css">

	</head>
	<body>
		<div class="b-img" style="top:-250"></div>

		<div class="websitecontent">
			<br>
			<br>
			<h1 style="margin-left:4%"><?php 
					if(isset($person_array[0][0]['TITLE']))
						print $person_array[0][0]['TITLE'].' ';
					print $person_array[0][0]['FIRSTNAME'].' '.$person_array[0][0]['SURNAME'];
						?></h1>
			<div>

				<br>

				<div class="row" style="margin-left:4%;">

					<div class="col">

						<p>
							
							<b>Telephone: </b>

							<br>

							<b>Social Security Number: </b>

							<br>

							<b>Profession: </b>

						</p>

						<br>
						<br>

						<?php 
						if($person_array[1] == 1) {

							print "<p><b>Jobexperience: </b><br>";
							print "<b>Court: </b></p><div style=\"margin-left: 50px\">ID: <br>";
							print "Name: <br>";
							print "Jurisdiction: <br>";
							print "Area of Law: </div><br>";

						}

						if($person_array[1] == 2) {
							
							print "<p><b>Political Party: </b><br>";
							print "<b>Senate: </b></p><div style=\"margin-left: 50px\">ID: <br>";
							print "Name: <br>";
							print "Assigned Sector: </div><br>";
						}

						if($person_array[1] == 0) {

							print "<p><b>Rank: </b><br>";
							print "<b>Department: </b><br>";
							print "<b>Area of Operation: </b></p><br>";

							if(isset($person_array[0][0]['COMMANDINGOFFICERID'])) {

							$officer = $database->selectEmployeeByID($person_array[0][0]['COMMANDINGOFFICERID']);

							print "<p><b>Commanding Officer: </b></p><div style=\"margin-left: 50px\">ID: <br>";
							print "Name: <br>";
							print "Rank: </div><br>";

							} else {

								print "<p><b>Commanding Officer: </b></p>";

							}
						}
						?>

						<br>

						<p>
							
							<b>Address: </b>

							<br>

							<b>City: </b>

							<br>

							<b>Planet: </b>

						</p>

					</div>

					<div class="col"> 

						<p>

							<?php print $person_array[0][0]['TELEPHONENUMBER'];?>

							<br>

							<?php print $person_array[0][0]['SOCIALSECURITY'];?>

							<br>

							<?php print $person_array[0][0]['JOBDESCRIPTION'];?>
							
						</p>

						<br>
						<br>

						<?php 
						if($person_array[1] == 0) {

							print "<p>".$person_array[0][0]['RANK']."<br>";
							print $person_array[0][0]['DEPARTMENT']."<br>";
							print $person_array[0][0]['ASSIGNEDSECTOR']."</p><br>";

							if(isset($person_array[0][0]['COMMANDINGOFFICERID'])) {

								print "</p><div><br>".$officer[0][0]['EMPLOYEEID']."<br>";
								print $officer[0][0]['FIRSTNAME']." ".$officer[0][0]['SURNAME']."<br>";
								print $officer[0][0]['RANK']."</div><br>";

							} else {

								print "<p>none</p>";

							}
						}

						if($person_array[1] == 1) {
							if(isset($person_array[0][0]['JOBEXPERIENCE'])) {
							
								print "<p>".$person_array[0][0]['JOBEXPERIENCE']." ".$person_array[0][0]['EXPERIENCETIMEUNIT']."<br>";
							
							} else {

								print "<p> none <br>";

							}

							$court = $database->selectCourtByID($person_array[0][0]['COURTID']);

							print "</p><div><br>".$court[0]['COURTID']."<br>";
							print $court[0]['NAME']."<br>";
							print $court[0]['ASSIGNEDSECTOR']."<br>";
							print $court[0]['AREAOFLAW']."</div><br>";

						}

						if($person_array[1] == 2) {

							print "<p style=\"width:max-content\">".$person_array[0][0]['PARTY']."<br>";

							$senate = $database->selectSenateByID($person_array[0][0]['SENATEID']);

							print "</p><div><br>".$senate[0]['SENATEID']."<br>";
							print $senate[0]['NAME']."<br>";
							print $senate[0]['ASSIGNEDSECTOR']."</div><br>";
						}
						?>

						<?php

						print "<br><p style=\"width:max-content\">".$person_array[0][0]['STREET']." ".$person_array[0][0]['HOUSENUMBER'];

						if(isset($person_array[0][0]['COMPLEXNUMBER'])) {

							print "/".$person_array[0][0]['COMPLEXNUMBER'];

						}

						if(isset($person_array[0][0]['DOORNUMBER'])) {

							print "/".$person_array[0][0]['DOORNUMBER'];

						}

						print "<br>".$person_array[0][0]['ZIPCODE'].", ".$person_array[0][0]['CITY']."<br>";
						print $person_array[0][0]['PLANET']."</p>";
						?>

					</div>
				</div>
			</div>

			<br>
			<br>

			<div class="row" style="margin-left:4.3%; width:max-content">

				<div class="col">

					<form action="changeInfoForm.php" method="get">

						<input type="hidden" name="etype" value="<?php print $person_array[1]; ?>">

						<button type="submit" name="edit" value="<?php print $_GET['Details']; ?>" style="background-color: darkgreen; color: white; margin-right: 20px">Edit</button>

					</form>

				</div>

				<br>

				<div class="col">

					<form action="delEmployee.php" method="post" onsubmit="return confirmation()">

						<input type="hidden" name="officer" value="<?php if($person_array[1] == 0) {print $person_array[0][0]['COMMANDINGOFFICERID'];} ?>">
						<input type="hidden" name="etype" value="<?php print $person_array[1]; ?>">
						<button name="id" value="<?php print $_GET['Details']; ?>" style="background-color: darkred; color: white; margin-right:20px">Delete</button>

					</form>

				</div>

				<div class="col">

					<form action="searchEmployee.php" method="post">

						<button type="submit" style="background-color: darkgrey; color: white; width:max-content">Go back  	&#9166;</button>

					</form>

				</div>
			</div>
		</div>
	</body>
</html>