<?php
require_once('DatabaseHelper.php');

header('Content-type: text/html; charset=utf-8');

$database = new DatabaseHelper();

if(isset($_COOKIE['username']) && isset($_COOKIE['password']) && password_verify($_COOKIE['password'],$database->gethash($_COOKIE['username']))) {
    ;
} else {
    header("location:logInForm.php");
}
?>
<html>
    <head>

    <link rel = 'icon' type='image/x-icon' href = 'logo.ico' >
        <title>Panviacan Union Official Website</title>

        <meta charset="utf-8">
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
        integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous"> 
        <link rel="stylesheet" href="style.css">

    </head>

    <body>
        <div class="b-img"></div>

        <div class="websitecontent">

            <br>

            <div  style="text-align:center;align-items:center;" id="test">

                <img id="headerpic" src='Logo_Galactic_union.png' width="80" height="160" style="margin-right: 0px;
                position: relative;
                top: -8px">

                <h1 style="display:inline">Panvican Union <br> Employee Administration</h1>

                <br>
                <br>

                <div>
                        
                    <form method="get" action="" style="display:inline-block;">

                        <button type="submit">
                            Instructions
                        </button>

                    </form>
                            
                    <form method="get" action="addEmployeeForm.php" style="display:inline-block;">

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

            <p> Dear Database Administrator:</p> <br>
            
            <p>This is the official website for database adminitration and database queries concerning our <b>Glorious Union</b>. <br> 
            Any Person claiming to work for us not registered in this database is a fraud and needs to be arrested immediately. <br>
            Every such individual is to be charged of <b>Conspiracy against the Union</b> with a following investigation. <br>
            If this does not happen, the employee responsible is to be regarded as <b>co-conspirator</b> and prosecuted as such as is referred to in the constitution.</p> <br>
            
            <p>The wesite can be used to add new Employees to the database, in case of new employments <br>
            or if the Employee decides to switch between different branches of the State (military, politics, or judicial system). <br>
            If this is not the case, it is also possible changing the entry of the employee correspondingly, <br>
            thus allowing the employee to keep his or her or its (depending on Pronoun this section may be adapted accordingly) ID. <br>
            Noncompliance with authorized requests from staff members is considered <b>Conspiracy against the Union</b>.</p> <br>
            
            <p>If an Employee is not working for our <b>Glorious Union</b> any longer he or she is to be <b>removed</b> from the database <b>as soon as possible</b>.<br>
            Noncompliance with this obligaton shall lead to prosecution for <b>Conspiracy against the Union</b>. </p> <br>

            <p>This website and database also serves informational purposes, to those with <b>sufficient security clearance</b>, as declared in the Constitution, Paragraph 367b. <br>
            Under <b>no</b> circumstances is the requestee to access the database on his or her or its (depending on Pronoun this section may be adapted accordingly) own. <br>
            The <b>Database Adminsitrator</b> always accesses the information, and hands it over to the requestee after removing information above security Clearance.</p> <br>

            <p>To access detailed information, search for desired Employee and click on the button <b>Details</b>. While in the Detail-Screen it is also possible to <b>change the Information</b> <br>
            of the corresponding entry, as well as to <b>delete</b> it. If a soldier has no commanding officer choose <b>"-"</b>, <b>not</b> the <b>ID</b> of the soldier.</p> <br>

            <p><b>Vidra Vidris!</b></p>

        </div>

    </body>
</html>