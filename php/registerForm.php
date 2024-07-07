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
<script>
  function checkRegister() {

        var names = new Array(<?php $f=1; 
            foreach ($database->selectAllAdmins() as $admin) : 
                if($f==1) {
                    $f=0;
                    print "\"".$admin['USERNAME']."\"";
                } else {
                    print ", \"".$admin['USERNAME']."\"";
                }
            endforeach;?>);

        document.getElementById('new_username').value = document.getElementById('new_username').value.replace(/^\s+/g, '');
        document.getElementById('new_password').value = document.getElementById('new_password').value.replace(/^\s+/g, '');
        document.getElementById('compare_password').value = document.getElementById('compare_password').value.replace(/^\s+/g, '');

        var uname = document.getElementById('new_username').value;
        var pwd1 = document.getElementById('new_password').value;
        var pwd2 = document.getElementById('compare_password').value;


        if(!/\S/.test(document.getElementById('new_username').value)) {
            alert("Please enter a valid Username!");
            return false;
        }
        if(!/\S/.test(document.getElementById('new_password').value)) {
            alert("Please enter a valid Password!");
            return false;
        }

        for (name of names){
            if(name == uname) {
                alert("Username already exists!");
                return false;
            }
        }

        if(pwd1 == pwd2) {
          return true;
        } else {
          alert("Passwords don't match!");
          return false;
        }

  }
</script>
<!DOCTYPE html>
<html>
  <head>
  <link rel = 'icon' type='image/x-icon' href = 'logo.ico' >
        <title>Register new Account</title>

        <meta charset="utf-8">
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
        integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous"> 
        <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div class="websitecontent" style="margin-top: 20%">
      <form method="post" action="register.php" style="height:100vh" onsubmit="return checkRegister()">
      
        <div class="row" style="text-align:center;align-items:center;">

          <div class="col" style="margin-left:1%">
          
            <div style="display:inline-block;">

              <label for="new_username">Username:</label>
              <input id="new_username" name="username" type="text" maxlength="30" placeholder="john1" required>

            </div>
          </div>
        </div>

        <br>

        <div class="row" style="text-align:center;align-items:center;">

          <div class="col" style="margin-left:1%">
          
            <div style="display:inline-block;">

              <label for="new_password">Password:</label>
              <input id="new_password" name="password" type="password" maxlength="70" placeholder="******" required>

            </div>
          </div>
        </div>
        <div class="row" style="text-align:center;align-items:center;">

          <div class="col" style="margin-left:1%">
          
            <div style="display:inline-block;">

              <label for="compare_password">Reenter Password:</label>
              <input id="compare_password" name="passwordcomp" type="password" maxlength="70" placeholder="******" required>

            </div>
          </div>
        </div>

        <div class="row" style="margin-left:30vw; width:max-content; margin-top: 20px">
          <div class="col">

              <button style="margin-right: 20px; color: white; background-color:darkgreen" type="submit" >
                  Register
              </button>

          </div>
          <div class="col">
              <input style="color: white; background-color:grey" type="button" name="cancelbutton" value="Go back &#9166;" onClick="window.location.href='https://wwwlab.cs.univie.ac.at/~hejzef44/index.php';">
          </div>
        </div>
      </form>
    </div>
  </body>
</html>
