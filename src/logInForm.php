<?php
  if(isset($_COOKIE["unauthorized"])) {
    echo "<script>alert(\"Unauthorized access! \\nThis incident will be reported!\");</script>";
    setcookie("unauthorized", "", time() - 3600);

  }
?>
<!DOCTYPE html>
<html>
  <head>
  <link rel = 'icon' type='image/x-icon' href = 'logo.ico' >
        <title>LogIn</title>

        <meta charset="utf-8">
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
        integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous"> 
        <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div class="websitecontent" style="margin-top: 20%">
      <form method="post" action="logIn.php" style="height:100vh">
      
        <div class="row" style="text-align:center;align-items:center;">

          <div class="col" style="margin-left:1%">
          
            <div style="display:inline-block;">

              <label for="check_username">Username:</label>
              <input id="check_username" name="username" type="text" maxlength="30" placeholder="john1" required>

            </div>
          </div>
        </div>

        <br>

        <div class="row" style="text-align:center;align-items:center;">

          <div class="col" style="margin-left:1%">
          
            <div style="display:inline-block;">

              <label for="check_password">Password:</label>
              <input id="check_password" name="password" type="password" maxlength="30" placeholder="******" required>

            </div>
          </div>
        </div>

        <div class="row" style="margin-left:38vw; width:max-content; margin-top: 20px">
          <div class="col">

              <button style="margin-right: 20px; color: white; background-color:darkgreen" type="submit" >
                  LogIn
              </button>

          </div>
        </div>

      </form>

    </div>

  </body>

</html>
