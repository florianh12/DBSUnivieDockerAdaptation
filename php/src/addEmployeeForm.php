<?php

require_once('DatabaseHelper.php');

header('Content-type: text/html; charset=utf-8');

$database = new DatabaseHelper();

if(isset($_COOKIE['username']) && isset($_COOKIE['password']) && password_verify($_COOKIE['password'],$database->gethash($_COOKIE['username']))) {
    ;
} else {
    header("location:logInForm.php");
}

$employee_id='';
if (isset($_GET['employee_id'])) {
    $employee_id = $_GET['employee_id'];
}

$surname = '';
if (isset($_GET['surname'])) {
    $surname = $_GET['surname'];
}

$name = '';
if (isset($_GET['name'])) {
    $name = $_GET['name'];
}

$jobdescription = '';
if (isset($_GET['jobdescription'])) {
    $jobdescription = $_GET['jobdescription'];
}
$type='';
if(isset($_GET['stype'])) {
    $type = $_GET['stype'];
}


//Fetch all necessary information for Webelements from Database
$zip_array = $database->selectallZIPcodes();
$soldier_array = $database->selectallSoldiers();
$court_array = $database->selectallCourts();
$senate_array = $database->selectallSenates();
$person_array = $database->searchAllEmployees($employee_id, $surname, $name, $jobdescription, $type);
?>



<script>
    //checks if unique constraints from telephone and socialsecurity are met and if all values contain more than spaces, 
    //also conveniently eradicates spaces inserted before the first letter or number, however there seems to be an issue with required
    //My guess is that the function is called after required is checked
    function checkunique() {
        const socialsec = new Array(<?php $f=1; 
            foreach ($person_array as $person) : 
                if($f==1) {
                    $f=0;
                    print $person['SOCIALSECURITY'];
                } else {
                    print ", ".$person['SOCIALSECURITY'];
                }
            endforeach;?>);
        const tel = new Array(<?php $f=1; 
            foreach ($person_array as $person) : 
                if($f==1) {
                    $f=0;
                    print $person['TELEPHONENUMBER'];
                } else {
                    print ", ".$person['TELEPHONENUMBER'];
                }
            endforeach;?>);

        var usersec = document.getElementById('new_socialsecurity').value;
        var usertel = document.getElementById('new_telephone').value;


        //finds and eradicates useless spaces
        document.getElementById('new_name').value = document.getElementById('new_name').value.replace(/^\s+/g, '');
        document.getElementById('new_surname').value = document.getElementById('new_surname').value.replace(/^\s+/g, '');
        document.getElementById('new_socialsecurity').value = document.getElementById('new_socialsecurity').value.replace(/^\s+/g, '');
        document.getElementById('new_telephone').value = document.getElementById('new_telephone').value.replace(/^\s+/g, '');
        document.getElementById('new_jobdescription').value = document.getElementById('new_jobdescription').value.replace(/^\s+/g, '');
        document.getElementById('new_street').value = document.getElementById('new_street').value.replace(/^\s+/g, '');
        document.getElementById('new_housenumber').value = document.getElementById('new_housenumber').value.replace(/^\s+/g, '');
        document.getElementById('new_complexnumber').value = document.getElementById('new_complexnumber').value.replace(/^\s+/g, '');
        document.getElementById('new_doornumber').value = document.getElementById('new_doornumber').value.replace(/^\s+/g, '');


        //Checks if the  fields do contain any charakters apart from spaces
        if(!/\S/.test(document.getElementById('new_name').value)) {
            alert("Please insert a valid First Name!");
            return false;
        }
        if(!/\S/.test(document.getElementById('new_surname').value)) {
            alert("Please insert a valid Surname!");
            return false;
        }


        //Checks unique constraints
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


         //Checks if the  fields do contain any charakters apart from spaces
        if(!/\S/.test(document.getElementById('new_jobdescription').value)) {
            alert("Please insert a valid Jobdescription!");
            return false;
        }
        
        if(!/\S/.test(document.getElementById('new_street').value)) {
            alert("Please insert a valid Street-Name!");
            return false;
        }


        //Special checks depending on employeetype but basically the same as before
        if(document.getElementById('select_type').value == "soldier") {

            document.getElementById('new_department').value = document.getElementById('new_department').value.replace(/^\s+/g, '');

            if(!/\S/.test(document.getElementById('new_department').value)) {
                alert("Please insert a valid Department-Name!");
                return false;
            }

            document.getElementById('new_sector').value = document.getElementById('new_sector').value.replace(/^\s+/g, '');

            if(!/\S/.test(document.getElementById('new_sector').value)) {
                alert("Please insert a valid Assigned Sector-Name!");
                return false;
            }

        } else if (document.getElementById('select_type').value == "judicialofficer") {

            document.getElementById('new_jtitle').value = document.getElementById('new_jtitle').value.replace(/^\s+/g, '');
            document.getElementById('new_jobexperience').value = document.getElementById('new_jobexperience').value.replace(/^\s+/g, '');

        } else  if (document.getElementById('select_type').value == "politician") {

            document.getElementById('new_ptitle').value = document.getElementById('new_ptitle').value.replace(/^\s+/g, '');
            document.getElementById('new_party').value = document.getElementById('new_party').value.replace(/^\s+/g, '');

        } else {//in case ifsoemthing unexpected happens
            alert("Invalid parameters!");
            return false;
        }

        return true;
    }


    //Shows the correct inputs for Employeetype and hides the others depending on value in type
    function toggleType(typeval) {
        for (e of document.getElementsByName(typeval)){
            e.style.display = 'inline-block';
        }

        if(typeval != "soldier") {
            for (e of document.getElementsByName("soldier")){
                e.style.display = 'none';
            }
        }

        if(typeval != "judicialofficer") {
            for (e of document.getElementsByName("judicialofficer")){
                e.style.display = 'none';
            }
        }
        
        if(typeval != "politician") {
            for (e of document.getElementsByName("politician")){
                e.style.display = 'none';
            }
        }
    }
</script>
    

<html>

    <head>

    <link rel = 'icon' type='image/x-icon' href = 'logo.ico' >
        <title>Add new Employee</title>
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

            <div  style="text-align:center;align-items:center;" id="test">
                
                <img id="headerpic" src='Logo_Galactic_union.png' width="80" height="160" style="margin-right: 0px; position: relative; top: -8px">
                
                <h1 style="display:inline">Add new Employee</h1>

                <br>
                <br>

                <div>
                    
                    <form method="get" action="index.php" style="display:inline-block;">
                            <button type="submit">
                                Instructions
                            </button>
                    </form>

                    <form method="get" action="" style="display:inline-block;">
                        <button type="submit">
                            Add Employee
                        </button>
                    </form>

                    <form method="get" action="searchEmployee.php" style="display:inline-block;">
                            <button type="submit" >
                                Search Employees
                            </button>
                    </form>

                    <form method="get" action="registerForm.php" style="display:inline-block;">

                        <button type="submit" >
                            Register new Administrator
                        </button>

                    </form>

                    <form method="get" action="removeAdminForm.php" style="display:inline-block;">

                        <button type="submit" >
                            Remove Administrator
                        </button>

                    </form>

                    <form method="get" action="logOut.php" style="display:inline-block;">

                        <button type="submit" >
                            LogOut
                        </button>

                    </form>

                </div>

            </div>

            <br>

            <hr>

            <br>
            <br>
            <br>

            <form method="post" action="addEmployee.php" onsubmit="return checkunique()">
                <!-- These are the Input-Elements for Employee, EmployeeID is autogenerated -->

                <div class="row" style="text-align:center;align-items:center;">

                    <div class="col" style="margin-left:1%">

                        <div style="display:inline-block;">

                            <label for="new_name">First Name:</label>
                            <input id="new_name" name="name" type="text" maxlength="30" placeholder="John" required>

                        </div>

                        <br>

                        <div style="display:inline-block;">

                            <label for="new_surname">Surname:</label>
                            <input id="new_surname" name="surname" type="text" maxlength="30" placeholder="Doe" required>

                        </div>

                        <br>

                        <div style="display:inline-block;">

                            <label for="new_socialsecurity">Socialsecurity:</label>
                            <input id="new_socialsecurity" name="socialsecurity" type="number" min="1" placeholder="1" required>

                        </div>

                        <br>

                        <div style="display:inline-block;">

                            <label for="new_telephone">Telephone:</label>
                            <input id="new_telephone" name="telephone" type="number" min="1" placeholder="1">

                        </div>

                        <br>

                        <div style="display:inline-block;">

                            <label for="new_jobdescription">Jobdescription:</label>
                            <input id="new_jobdescription" name="jobdescr" type="text" maxlength="40" placeholder="Defaultjob" required>

                        </div>
                    </div>

                    <div class="col">

                        <div style="display:inline-block;">

                            <label for="new_street">Street:</label>
                            <input id="new_street" name="street" type="text" maxlength="70" placeholder="Default-Street" required>

                        </div>

                        <br>
                        
                        <div style="display:inline-block;">

                            <label for="new_housenumber">Housenumber:</label>
                            <input id="new_housenumber" name="house" type="number" min="1" placeholder="1" required>

                        </div>

                        <br>
                            
                        <div style="display:inline-block;">

                            <label for="new_complexnumber">Complexnumber:</label>
                            <input id="new_complexnumber" name="complex" type="number" min="1">

                        </div>

                        <br>
                                
                        <div style="display:inline-block;">

                            <label for="new_doornumber">Doornumber:</label>
                            <input id="new_doornumber" name="door" type="number" min="1">

                        </div>

                        <br>
                                
                        <div style="display:inline-block;">

                            <label for="new_zip">ZIP-Code:</label>
                            <select id="new_zip" name="zip">
                                <?php foreach ($zip_array as $zip) : ?>
                                    <option value="<?php print $zip['ZIPCODE']; ?>"><?php print $zip['ZIPCODE']; ?> - <?php print $zip['CITY']; ?>, <?php print $zip['PLANET']; ?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>

                        <br>

                    </div> 

                    <div class="col">  

                        <div style="display:inline-block;">

                            <label for="select_type">Type:</label>
                            <select id="select_type" name="type" onchange="toggleType(this.value)" required>
                            <option value="">-</option>
                            <option value="soldier">Soldier</option>
                            <option value="judicialofficer">Judicial Officer</option>
                            <option value="politician">Politician</option>
                            </select>

                        </div>

                        <br>

                        <div name="politician" style="display:none">

                            <label for="new_ptitle">Title:</label>
                            <input id="new_ptitle" name="ptitle" type="text" maxlength="30">

                        </div>

                        <br name="politician" style="display:none">
                        
                        
                        <div name="politician" style="display:none">

                            <label for="new_party">Party:</label>
                            <input id="new_party" name="party" type="text" maxlength="40">

                        </div>

                        <br name="politician" style="display:none">
                        
                        <div name="politician" style="display:none">

                            <label for="new_psenate">Senate:</label>
                            <select id="new_psenate" name="psenate">
                                <?php foreach ($senate_array as $senate) : ?>
                                    <option value="<?php print $senate['SENATEID']; ?>"><?php print $senate['SENATEID']." - ".$senate['NAME'].", Assigned Sector: ".$senate['ASSIGNEDSECTOR']; ?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>

                        <br name="politician" style="display:none">
                        <br name="politician" style="display:none">
                        <br name="politician" style="display:none">
                        <br name="politician" style="display:none">


                        <div name="judicialofficer" style="display:none">

                            <label for="new_jtitle">Title:</label>
                            <input id="new_jtitle" name="jtitle" type="text" maxlength="30">

                        </div>

                        <br name="judicialofficer" style="display:none"> 
                        
                        <div name="judicialofficer" style="display:none">

                            <label for="new_jobexperience">Jobexperience:</label>
                            <input id="new_jobexperience" name="jobexperience" type="number" min="1">

                        </div>

                        <br name="judicialofficer" style="display:none">

                        <div name="judicialofficer" style="display:none">

                            <label for="new_jobexperiencetime">Type:</label>
                            <select id="new_jobexperiencetime" name="jobexperiencetime">
                            <option value="Years">Years</option>
                            <option value="Months">Months</option>
                            </select>

                        </div>

                        <br name="judicialofficer" style="display:none">

                        <div name="judicialofficer" style="display:none">

                            <label for="new_jcourt">Court:</label>
                            <select id="new_jcourt" name="jcourt">
                                <?php foreach ($court_array as $court) : ?>
                                    <option value="<?php print $court['COURTID']; ?>"><?php echo $court['COURTID']." - ".$court['NAME'].", Assigned Sector: ".$court['ASSIGNEDSECTOR'].", Area of Law: ".$court['AREAOFLAW'];?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>

                        <br name="judicialofficer" style="display:none">


                        <div name="soldier" style="display:none">

                            <label for="select_rank">Rank:</label>
                            <select id="select_rank" name="rank">
                                <option value="General">General</option>
                                <option value="Colonel">Colonel</option>
                                <option value="Major">Major</option>
                                <option value="Captain">Captain</option>
                                <option value="Lieutenant">Lieutenant</option>
                                <option value="Private">Private</option>
                            </select>

                        </div>

                        <br name="soldier" style="display:none">
                        
                        
                        <div name="soldier" style="display:none">

                            <label for="new_department">Department:</label>
                            <input id="new_department" name="department" type="text" maxlength="40" placeholder="Default-Department">

                        </div>

                        <br name="soldier" style="display:none">
                        
                        <div name="soldier" style="display:none">
                            <label for="new_sector">Area of Operation:</label>
                            <input id="new_sector" name="sector" type="text" maxlength="40" placeholder="Entire Union"> <!--maybe need to adapt code for 3NF -->
                        </div>
                        <br name="soldier" style="display:none">       
                        
                        <div name="soldier" style="display:none">

                            <label for="new_commandingofficer">Commanding Officer:</label>
                            <select id="new_commandingofficer" name="commandingofficer">
                                <option value="">-</option>
                                <?php foreach ($soldier_array as $soldier) : ?>
                                    <option value="<?php print $soldier['EMPLOYEEID']; ?>"><?php print $soldier['EMPLOYEEID']." - ".$soldier['FIRSTNAME']." ".$soldier['SURNAME'].", ".$soldier['RANK']; ?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>

                        <br name="soldier" style="display:none">

                    </div>
                </div>

                <br>
                <br>

                <div>

                    <button type="submit" style="margin-top:20px;margin-left:4.3%">
                        Add
                    </button>

                </div>

            </form>
        </div>
    </body>
</html>