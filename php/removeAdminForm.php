<?php

require_once('DatabaseHelper.php');

header('Content-type: text/html; charset=utf-8');

$database = new DatabaseHelper();


if(isset($_COOKIE['username']) && isset($_COOKIE['password']) && password_verify($_COOKIE['password'], $database->gethash($_COOKIE['username']))) {
    ;
} else {
    header("location:logInForm.php");
}


$admin_array = $database->selectAllAdmins();
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

                <h1 style="display:inline">Remove Administrator</h1>

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

                    
                    <form method="get" action="" style="display:inline-block;">

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


            <br>
            <br>

            <hr>

                <div id="stable" style="height:850px;overflow-y:scroll;">

                    <table style="background-color: transparent">

                        <tr>

                            <th>Username</th>
                            <th style="width:125px"></th>

                        </tr>

                        <?php foreach ($admin_array as $admin) : ?>

                            <tr style="background-color: transparent">

                                <td><?php echo $admin['USERNAME']; ?>  </td>
                                <td>

                                    <form action="deleteAdmin.php" method="get" onsubmit="return assertDelete()">

                                        <button name="Delete" value="<?php print $admin['USERNAME']; ?>">Delete</button>

                                    </form>
                                    
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </table>

                </div>

            <script>

                function assertDelete() {

                    return confirm("Do you really wish to delete this Administrator (this action will be logged)?");

                }

            </script>

        </div>

    </body>
</html>