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


//Fetch data from database
$zip_array = $database->selectallZIPcodes();
$soldier_array = $database->selectallSoldiers();
$court_array = $database->selectallCourts();
$senate_array = $database->selectallSenates();
$person_array = $database->searchAllEmployees($employee_id, $surname, $name, $jobdescription, $type);
?>

    
<html>
    <head>

    <link rel = 'icon' type='image/x-icon' href = 'logo.ico' >
        <title>Search Employees</title>

        <meta charset="utf-8">
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
        integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous"> 
        <link rel="stylesheet" href="style.css">

    </head>

    <body>

        <div  id="bim" class="b-img" ></div>

        <div id="wct" class="websitecontent">

            <br>
            <br>

            <div  style="text-align:center;align-items:center;" id="test">

                <img id="headerpic" src='Logo_Galactic_union.png' width="80" height="160" style="margin-right: 0px;
                position: relative;
                top: -8px">

                <h1 style="display:inline">Search Employees</h1>

                <br>
                <br>

                <div>
                    
                    <form method="get" action="index.php" style="display:inline-block;">

                        <button type="submit">
                            Instructions
                        </button>

                    </form>

                    <form method="get" action="addEmployeeForm.php" style="display:inline-block;">

                        <button type="submit">
                            Add Employee
                        </button>

                    </form>

                    <form method="get" action="" style="display:inline-block;">

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
            <br>
            <br>

            <!-- collapable refers to the button capable of showing and collapsing the search criteria, colcontent is the area collapsed -->
            <button type="button" class="collapable activated">Search-Criteria</button>
            <div class="colcontent">

                <form method="get">

                    <div class="row" style="text-align:center;align-items:center;">

                        <div class="col" style="width:max-content;float:right">

                            <div style="display:inline-block;">

                                <label for="employee_id">ID:</label>
                                <input class="colcontains" id="employee_id" name="employee_id" type="number" value='<?php echo $employee_id; ?>' 
                                min="0" placeholder="Snaps to value if entered">

                            </div>

                            <br>

                            <div style="display:inline-block;">
                            
                                <label for="name">First Name:</label>
                                <input class="colcontains" id="name" name="name" type="text" 
                                value='<?php echo $name; ?>' maxlength="30">

                            </div>

                            <br>

                            <div style="display:inline-block;">

                                <label for="surname">Surname:</label>
                                <input class="colcontains" id="surname" name="surname" type="text"
                                    value='<?php echo $surname; ?>' maxlength="30">

                            </div>

                            <br>

                        </div>

                        <div class="col" style="width:max-content;float:right">

                            <div style="display:inline-block;">

                                <label for="jobdescription">Jobdescription:</label>
                                <input class="colcontains" id="jobdescription" name="jobdescription" type="text"
                                    value='<?php echo $jobdescription; ?>' maxlength="70">

                            </div>

                            <br>

                            <div style="display:inline-block;">

                                <label for="search_type">Type:</label>
                                <select class="colcontains" id="search_type" name="stype" onchange="">
                                    <option value="">-</option>
                                    <option value="Soldier" <?php if($type=="Soldier") {print "selected";} ?>>Soldier</option>
                                    <option value="JudicialOfficer"  <?php if($type=="JudicialOfficer") {print "selected";} ?>>Judicial Officer</option>
                                    <option value="Politician" <?php if($type=="Politician") {print "selected";} ?>>Politician</option>
                                </select>

                            </div>
                        </div>
                    </div>

                    <br>
                    <br>

                    <div>

                        <button class="colcontainsb" id='submit' type='submit' style="margin:top20px;margin-left:4.3%">
                            Search
                        </button>

                    </div>
                    
                </form>

            </div>

            <br>
            <br>

            <hr>

                <div id="stable" style="height:850px;overflow-y:scroll;">

                    <table style="background-color: transparent">

                        <tr>

                            <th style="width: 5%;">ID</th>
                            <th style="min-width: 5%;">First Name</th>
                            <th style="min-width: 5%;">Surname</th>
                            <th style="min-width: 5%;">Jobdescription</th>
                            <th style="width:125px"></ph>

                        </tr>

                        <?php foreach ($person_array as $person) : ?>

                            <tr style="background-color: transparent">

                                <td><?php echo $person['EMPLOYEEID']; ?>  </td>
                                <td><?php echo $person['FIRSTNAME']; ?>  </td>
                                <td><?php echo $person['SURNAME']; ?>  </td>
                                <td><?php echo $person['JOBDESCRIPTION']; ?>  </td>
                                <td>

                                    <form action="details.php" method="get">

                                        <button name="Details" value="<?php print $person['EMPLOYEEID']; ?>">Details</button>

                                    </form>
                                    
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </table>

                </div>

            <script>

                var c = document.getElementsByClassName("collapable activated");
                var i;

                for(i=0; i< c.length; i++) {

                    c[i].addEventListener("click", function() {

                        this.classList.toggle("activated");

                        var ct = this.nextElementSibling;

                        if(ct.style.display == "none") {

                            ct.style.display = "block";
                            document.getElementById("bim").style.height = "160%";

                        } else {

                            ct.style.display = "none";
                            document.getElementById("bim").style.height = "110%";
                        }

                    });

                }

            </script>

        </div>

    </body>
</html>