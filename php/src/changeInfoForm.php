<?php
require_once('DatabaseHelper.php');

$database = new DatabaseHelper();

if(isset($_COOKIE['username']) && isset($_COOKIE['password']) && password_verify($_COOKIE['password'],$database->gethash($_COOKIE['username']))) {
    ;
} else {
    header("location:logInForm.php");
}


$selected='';
if(isset($_GET['edit'])) {
    $selected = $_GET['edit'];
}

$etype='';
if(isset($_GET['etype'])) {
    $etype = $_GET['etype'];
}


//Get the relevant data from the database
$person_array = $database->selectEmployeeByID($selected);
$zip_array = $database->selectallZIPcodes();
$unique_array = $database->searchAllEmployees('','','','','');
$senate_array = $database->selectallSenates();
$court_array = $database->selectallCourts();
$soldier_array = $database->selectallSoldiers();
?>


<script>
    //Shows the correct inputs to change, dependign on $etype 
    function showType(typeval) {
            if(typeval == 0) {
                for (e of document.getElementsByName("soldier")){
                    e.style.display = 'inline-block';
                }
            }

            if(typeval == 1) {
                for (e of document.getElementsByName("judicialofficer")){
                    e.style.display = 'inline-block';
                }
            }
            
            if(typeval == 2) {
                for (e of document.getElementsByName("politician")){
                    e.style.display = 'inline-block';
                }
            }
        }


         //checks if unique constraints from telephone and socialsecurity are met (excluding modified entry)
         // and if all values contain more than spaces, 
         //also conveniently eradicates spaces inserted before the first letter or number, however there seems to be an issue with required
         //My guess is that the function is called after required is checked, for a more detailed explaination of the Function, 
         //check addEmployeeForm function with same name
        function checkunique() {

			const socialsec = new Array(<?php $f=1; 
                foreach ($unique_array as $unique) : 
                    if($person_array[0][0]['SOCIALSECURITY'] != $unique['SOCIALSECURITY']) {
                        if($f==1) {
                            $f=0;
                            print $unique['SOCIALSECURITY'];
                        } else {
                            print ", ".$unique['SOCIALSECURITY'];
                        }
                    }
                endforeach;?>);

			const tel = new Array(<?php $f=1; 
                foreach ($unique_array as $unique) :
                    if($person_array[0][0]['TELEPHONENUMBER'] != $unique['TELEPHONENUMBER']) { 
                        if($f==1) {
                            $f=0;
                            print $unique['TELEPHONENUMBER'];
                        } else {
                            print ", ".$unique['TELEPHONENUMBER'];
                        }
                    }
                endforeach;?>);
    
			var usersec = document.getElementById('change_socialsecurity').value;
			var usertel = document.getElementById('change_telephone').value;


            document.getElementById('change_name').value = document.getElementById('change_name').value.replace(/^\s+/g, '');
            document.getElementById('change_surname').value = document.getElementById('change_surname').value.replace(/^\s+/g, '');
            document.getElementById('change_socialsecurity').value = document.getElementById('change_socialsecurity').value.replace(/^\s+/g, '');
            document.getElementById('change_telephone').value = document.getElementById('change_telephone').value.replace(/^\s+/g, '');
            document.getElementById('change_jobdescription').value = document.getElementById('change_jobdescription').value.replace(/^\s+/g, '');
            document.getElementById('change_street').value = document.getElementById('change_street').value.replace(/^\s+/g, '');
            document.getElementById('change_housenumber').value = document.getElementById('change_housenumber').value.replace(/^\s+/g, '');
            document.getElementById('change_complexnumber').value = document.getElementById('change_complexnumber').value.replace(/^\s+/g, '');
            document.getElementById('change_doornumber').value = document.getElementById('change_doornumber').value.replace(/^\s+/g, '');
           
            
            if(!/\S/.test(document.getElementById('change_name').value)) {
                alert("Please insert a valid First Name!");
                return false;
            }

            if(!/\S/.test(document.getElementById('change_surname').value)) {
                alert("Please insert a valid Surname!");
                return false;
            }


            for (sec of socialsec){
                if(sec == usersec) {
				alert("Social Security Number already exists!");
				return false;
                }
            }

			for (t of tel){
                if(t == usertel) {
				alert("Telephone number already exists!");
				return false;
                }
            }


            if(!/\S/.test(document.getElementById('change_jobdescription').value)) {
                alert("Please insert a valid Jobdescription!");
                return false;
            }
            
            if(!/\S/.test(document.getElementById('change_street').value)) {
                alert("Please insert a valid Street-Name!");
                return false;
            }


            if(<?php print $etype; ?> == 0) {
                
                document.getElementById('change_department').value = document.getElementById('change_department').value.replace(/^\s+/g, '');
                
                if(!/\S/.test(document.getElementById('change_department').value)) {
                    alert("Please insert a valid Department-Name!");
                    return false;
                }
            
                document.getElementById('change_sector').value = document.getElementById('change_sector').value.replace(/^\s+/g, '');
                
                if(!/\S/.test(document.getElementById('change_sector').value)) {
                    alert("Please insert a valid Assigned Sector-Name!");
                    return false;
                }

            } else if (<?php print $etype; ?> == 1) {

                document.getElementById('change_jtitle').value = document.getElementById('change_jtitle').value.replace(/^\s+/g, '');
                document.getElementById('change_jobexperience').value = document.getElementById('change_jobexperience').value.replace(/^\s+/g, '');

            } else if (<?php print $etype; ?> == 2) {

                document.getElementById('change_ptitle').value = document.getElementById('change_ptitle').value.replace(/^\s+/g, '');
                document.getElementById('change_party').value = document.getElementById('change_party').value.replace(/^\s+/g, '');

            } else {
                alert("An Error has occured: Employeetype not found!");
                window.location.href = "details.php?Details=<?php print $selected;?>";
            }
           return true;
        }
</script>


<script>
    //execute shpwtype on load
    var t = <?php print $etype; ?>;

    window.onload = function() {
        showType(t);
    };

</script>


<html>


    <head>
        <link rel = 'icon' type='image/x-icon' href = 'logo.ico' >
        <title>
            <?php
            print "Edit: "; 
            if(isset($person_array[0][0]['TITLE'])) {
                print $person_array[0][0]['TITLE'];
            }
            print " ".$person_array[0][0]['FIRSTNAME']." ".$person_array[0][0]['SURNAME'];
            ?>
        </title>

        <meta charset="utf-8">
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
        integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">

    </head>


    <body>
        <div class="b-img" style="top:-200"></div>

        <div class="websitecontent">
            
            <br>
            <br>
            <br>
            <div style="text-align:center; margin-right:20px">
                <img  src='Logo_Galactic_union.png' width="80" height="160"style="margin: 0 auto;">
                <br>
                <b style="color: blue;line-height:100px">Vidris Vidra!</b>
            </div>
            <br>
            <br>

            <form method="post" action="changeInfo.php" onsubmit="return checkunique()">

                <div class="row" style="text-align:center;align-items:center;">

                    <div class="col" style="margin-left:1%">

                        <div style="display:inline-block;">

                            <label for="change_name">First Name:</label>
                            <input id="change_name" name="name" type="text" maxlength="30" placeholder="John" value="<?php print $person_array[0][0]['FIRSTNAME'];?>" required>

                        </div>

                        <br>

                        <div style="display:inline-block;">

                            <label for="change_surname">Surname:</label>
                            <input id="change_surname" name="surname" type="text" maxlength="30" placeholder="Doe" value="<?php print $person_array[0][0]['SURNAME'];?>" required>

                        </div>

                        <br>

                        <div style="display:inline-block;">

                            <label for="change_socialsecurity">Socialsecurity:</label>
                            <input id="change_socialsecurity" name="socialsecurity" type="number" min="1" placeholder="1" value="<?php print $person_array[0][0]['SOCIALSECURITY'];?>" required>

                        </div>

                        <br>

                        <div style="display:inline-block;">

                            <label for="change_telephone">Telephone:</label>
                            <input id="change_telephone" name="telephone" type="number" min="1" placeholder="1" value="<?php print $person_array[0][0]['TELEPHONENUMBER'];?>">

                        </div>

                        <br>

                        <div style="display:inline-block;">

                            <label for="change_jobdescription">Jobdescription:</label>
                            <input id="change_jobdescription" name="jobdescr" type="text" maxlength="40" placeholder="Defaultjob" value="<?php print $person_array[0][0]['JOBDESCRIPTION'];?>" required>

                        </div>
                    </div>

                    <div class="col">

                        <div style="display:inline-block;">

                            <label for="change_street">Street:</label>
                            <input id="change_street" name="street" type="text" maxlength="70" placeholder="Default-Street" value="<?php print $person_array[0][0]['STREET'];?>" required>

                        </div>

                        <br>
                        
                        <div style="display:inline-block;">

                            <label for="change_housenumber">Housenumber:</label>
                            <input id="change_housenumber" name="house" type="number" min="1" placeholder="1" value="<?php print $person_array[0][0]['HOUSENUMBER'];?>" required>

                        </div>

                        <br>
                            
                        <div style="display:inline-block;">

                            <label for="change_complexnumber">Complexnumber:</label>
                            <input id="change_complexnumber" name="complex" type="number" value="<?php if(isset($person_array[0][0]['COMPLEXNUMBER'])) {print $person_array[0][0]['COMPLEXNUMBER'];}?>" min="1">

                        </div>

                        <br>
                                
                        <div style="display:inline-block;">

                            <label for="change_doornumber">Doornumber:</label>
                            <input id="change_doornumber" name="door" type="number" value="<?php if(isset($person_array[0][0]['DOORNUMBER'])) {print $person_array[0][0]['DOORNUMBER'];}?>" min="1">

                        </div>

                        <br>
                                
                        <div style="display:inline-block;">

                            <label for="change_zip">ZIP-Code:</label>
                            <select id="change_zip" name="zip">
                                <!-- <option value="">-</option> -->
                                <?php foreach ($zip_array as $zip) : ?>
                                    <option value="<?php print $zip['ZIPCODE']; ?>" <?php if($person_array[0][0]['ZIPCODE']==$zip['ZIPCODE']) { print "selected";}?>><?php print $zip['ZIPCODE']; ?> - <?php print $zip['CITY']; ?>, <?php print $zip['PLANET']; ?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>

                        <br>

                    </div> 

                    <div class="col"> 

                        <div name="politician" style="display:none">

                            <label for="change_ptitle">Title:</label>
                            <input id="change_ptitle" name="ptitle" type="text" maxlength="30" value="<?php if($etype == 2) {print $person_array[0][0]['TITLE'];}?>">

                        </div>

                        <br name="politician" style="display:none">
                        
                        
                        <div name="politician" style="display:none">

                            <label for="change_party">Party:</label>
                            <input id="change_party" name="party" type="text" maxlength="40" value="<?php if($etype == 2) {print $person_array[0][0]['PARTY'];}?>">

                        </div>

                        <br name="politician" style="display:none">
                        
                        <div name="politician" style="display:none">

                            <label for="change_psenate">Senate:</label>
                            <select id="change_psenate" name="psenate">
                                <?php foreach ($senate_array as $senate) : ?>
                                    <option value="<?php print $senate['SENATEID']; ?>" <?php if($etype == 2 && $person_array[0][0]['SENATEID'] == $senate['SENATEID']) {print "selected";}?>><?php print $senate['SENATEID']." - ".$senate['NAME'].", Assigned Sector: ".$senate['ASSIGNEDSECTOR']; ?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>

                        <br name="politician" style="display:none">
                        <br name="politician" style="display:none">
                        <br name="politician" style="display:none">
                        <br name="politician" style="display:none">


                        <div name="judicialofficer" style="display:none">

                            <label for="change_jtitle">Title:</label>
                            <input id="change_jtitle" name="jtitle" type="text" maxlength="30" value="<?php if($etype == 1) {print $person_array[0][0]['TITLE'];}?>">

                        </div>
                        <br name="judicialofficer" style="display:none"> 
                        
                        <div name="judicialofficer" style="display:none">

                            <label for="change_jobexperience">Jobexperience:</label>
                            <input id="change_jobexperience" name="jobexperience" type="number" min="1" value="<?php if($etype == 1) {print $person_array[0][0]['JOBEXPERIENCE'];}?>">

                        </div>

                        <br name="judicialofficer" style="display:none">

                        <div name="judicialofficer" style="display:none">

                            <label for="change_jobexperiencetime">Type:</label>
                            <select id="change_jobexperiencetime" name="jobexperiencetime">
                                <option value="Years" <?php if($etype == 1 && $person_array[0][0]['EXPERIENCETIMEUNIT'] == "Years") {print "selected";}?>>Years</option>
                                <option value="Months" <?php if($etype == 1 && $person_array[0][0]['EXPERIENCETIMEUNIT'] == "Months") {print "selected";}?>>Months</option>
                            </select>

                        </div>

                        <br name="judicialofficer" style="display:none">

                        <div name="judicialofficer" style="display:none">

                            <label for="change_jcourt">Court:</label>
                            <select id="change_jcourt" name="jcourt">
                                <?php foreach ($court_array as $court) : ?>
                                    <option value="<?php print $court['COURTID']; ?>" <?php if($etype == 1 && $person_array[0][0]['COURTID'] == $court['COURTID']) {print "selected";}?>><?php echo $court['COURTID']." - ".$court['NAME'].", Assigned Sector: ".$court['ASSIGNEDSECTOR'].", Area of Law: ".$court['AREAOFLAW'];?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>

                        <br name="judicialofficer" style="display:none">


                        <div name="soldier" style="display:none">

                            <label for="select_rank">Rank:</label>
                            <select id="select_rank" name="rank">
                                <option value="General"  <?php if($etype == 0 && $person_array[0][0]['RANK'] == "General") {print "selected";}?>>General</option>
                                <option value="Colonel" <?php if($etype == 0 && $person_array[0][0]['RANK'] == "Colonel") {print "selected";}?>>Colonel</option>
                                <option value="Major" <?php if($etype == 0 && $person_array[0][0]['RANK'] == "Major") {print "selected";}?>>Major</option>
                                <option value="Captain" <?php if($etype == 0 && $person_array[0][0]['RANK'] == "Captain") {print "selected";}?>>Captain</option>
                                <option value="Lieutenant" <?php if($etype == 0 && $person_array[0][0]['RANK'] == "Lieutenant") {print "selected";}?>>Lieutenant</option>
                                <option value="Private" <?php if($etype == 0 && $person_array[0][0]['RANK'] == "Private") {print "selected";}?>>Private</option>
                            </select>

                        </div>

                        <br name="soldier" style="display:none">
                        
                        
                        <div name="soldier" style="display:none">

                            <label for="change_department">Department:</label>
                            <input id="change_department" name="department" type="text" maxlength="40" placeholder="Default-Department" value="<?php if($etype == 0) {print $person_array[0][0]['DEPARTMENT'];}?>">

                        </div>

                        <br name="soldier" style="display:none">
                        
                        <div name="soldier" style="display:none">

                            <label for="change_sector">Area of Operation:</label>
                            <input id="change_sector" name="sector" type="text" maxlength="40" placeholder="Entire Union" value="<?php if($etype == 0) {print $person_array[0][0]['ASSIGNEDSECTOR'];}?>">

                        </div>

                        <br name="soldier" style="display:none">       
                        
                        <div name="soldier" style="display:none">

                            <label for="change_commandingofficer">Commanding Officer:</label>
                            <select id="change_commandingofficer" name="commandingofficer">
                                <option value="">-</option>
                                <?php foreach ($soldier_array as $soldier) : ?>
                                    <option value="<?php print $soldier['EMPLOYEEID']; ?>"<?php if($etype == 0 && $person_array[0][0]['COMMANDINGOFFICERID'] == $soldier['EMPLOYEEID']) {print "selected";}?>><?php print $soldier['EMPLOYEEID']." - ".$soldier['FIRSTNAME']." ".$soldier['SURNAME'].", ".$soldier['RANK']; ?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>

                        <br name="soldier" style="display:none">

                </div>
            </div>

            <br>
            <br> 
                <div class="row" style="margin-left:4.3%; width:max-content">
                    <div class="col">

                        <input type="hidden" name="etype" value="<?php print $etype; ?>">

                        <button style="margin-right: 20px; color: white; background-color:darkgreen" type="submit" name="changeentry" value="<?php print $selected; ?>">
                            Confirm
                        </button>

                    </div>
                    <div class="col">
                        <input style="color: white; background-color:darkred" type="button" name="cancelbutton" value="Cancel" onClick="window.location.href='/details.php?Details=<?php print $selected;?>';">
                    </div>
                </div>
            </form>
        </div>
    </body>
    
</html>