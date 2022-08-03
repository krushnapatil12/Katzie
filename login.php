<?php
session_start();

$already_loggedin = 0;
$successfullyloggedin = 0;

if (isset($_SESSION['username'])) {
        
         //header("location: welcome.php");
         //exit;

         $already_loggedin += 1;
    }
    require_once "config.php";

    $username = $password = "";
    $err = "";

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        if (empty(trim($_POST['username'])) || empty(trim($_POST['password']))) {
            $err = "Kindly fill both the fields";
        }
        else {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
        }

        if (empty($err)) {
            $sql = "SELECT id, username, password FROM users WHERE username = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $username;



            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);

                    if (mysqli_stmt_fetch($stmt)) {
                      if (password_verify($password, $hashed_password)) {
                        session_start();
                        $_SESSION["username"] = $username;
                        $_SESSION["id"] = $id;
                        $_SESSION["loggedin"] = true;

                        //header("location: welcome.php");
                         $successfullyloggedin+=1;
                      }
                       else {
                         $err = "Password incorrect! Kindly enter the correct password";
                       }
                    }
                }
            }

        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="form.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="footer.css">

    <!-- bootstrap css below
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> -->

    <style>
        .column {
            height: 200px;

            width: 24%;
        }

        .menu {
  margin-right: 0%;
}
    </style>
</head>
<body>
    <nav>
        <div class="logo">
            <!-- <span id="blue">CATS</span> -->
      <img src="images/catlogo_wix.jpeg" alt="caltogo" height="80px" width="80px" class="logo_img">
        </div>
        <div class="menu" style="margin-right: 5%; margin-left: 20%;">
        <a href="index.html">Home</a>
          <a href="breeds.html">Breeds</a>
          <a href="register_katzie.php">Register</a>
          <a href="login.php">Login</a>
          <a href="welcome.php">Adopt</a>
          <a href="logout.php">Logout</a>
      <!-- <form action="none" class="search" style="float: right;">
        <input type="text" id="search", name="search" placeholder="Search Here...">
        <button type="submit">Search</button>
      </form> -->
        </div>
    </nav>
    
    
    <div style="background: rgb(255, 151, 151); text-align: center;">    
<?php

      if (!empty($err)) {
        echo $err;
      }

?>
</div>

<div style="background: rgb(231, 255, 195); text-align: center;">
<?php

       if ($already_loggedin == 1) {
         echo "You are already logged in!";

        //  echo '<script>setTimeout(function(){window.location.href = "welcome.php";}, 7000);</script>';

         exit;
       }

      elseif ($successfullyloggedin == 1) {
        echo '<script>alert("Successfully logged in!")</script>';

        echo "You are successfully logged in!";

        echo '<script>setTimeout(function(){window.location.href = "welcome.php";}, 7000);</script>';
      }

?>
</div> 


    <div class="container">
        
        <form action="" method="post" autocomplete = "off">
            <fieldset style="background-color: rgba(255, 255, 255, 0.63);">
                <legend><h1 style="font-family: cursive;"><u>Login</u></h1></legend>
            <table class="form_table">
                

                <tr>
                    <td>➼<label for="username">Username</label></td>
                    <td><input type="text" id="username" name="username" placeholder = "Enter A Username"></td>
                </tr>

                <tr>
                    <td>➼<label for="password">Password</label></td>
                    <td><input type="password" id="password" name="password" required placeholder="Enter Password"></td>
                </tr>

                
            </table>
            <div style="text-align: center; margin-bottom: 10px; margin-top: 10px;"><button class="button button2" style="vertical-align:middle" value="submit"><span>Submit</span></button></div>
            </fieldset>
        </form>
    </div>
    
    <h4 style="margin-left: 45%;">Don't have an account? <a href = "register_katzie.php">Register Here</a></h4>

    <!-- footer below -->
    <div class="footer">
    <div class="column" style="height: 260px;">
        <h3 style="text-align: left;"><u>⌘Navigate</u></h3>
        <a href="index.html" class="footerlinks"><p class="footer_lines" style="color: #ffffff;">➲Home</p></a>
        <a href="breeds.html" class="footerlinks"><p class="footer_lines" style="color: #ffffff;">➲Breeds</p></a>
        <a href="register_katzie.php" class="footerlinks"><p class="footer_lines" style="color: #ffffff;">➲Register</p></a>
        <a href="login.php" class="footerlinks"><p class="footer_lines" style="color: #ffffff;">➲Login</p></a>
        <a href="welcome.php" class="footerlinks"><p class="footer_lines" style="color: #ffffff;">➲Adopt</p></a>
    </div>
    
          <div class="column">
              <h3 style="text-align: left;"><u>⌘Imp Links</u></h3>
              
              <a href="aboutus.html" class="footerlinks"><p class="footer_lines" style="color: #ffffff;">➲About</p></a>
              <a href="policy.html" class="footerlinks"><p class="footer_lines" style="color: #ffffff;">➲Policy</p></a>
              <a href="contactus.html" class="footerlinks"><p class="footer_lines" style="color: #ffffff;">➲Contact Us</p></a>
          </div>

        <div class="column">
            <h3 style="text-align: left;"><u>⌘Social Media</u></h3>

            <div style="text-align: left; margin-top: 10px;">
            <a href="#" class="fa fa-facebook"></a>
            <a href="#" class="fa fa-twitter"></a>
            <a href="#" class="fa fa-youtube"></a>
            <a href="#" class="fa fa-instagram"></a></div>

        </div>

        <div class="column">
            <h3 style="text-align: left;"><u>⌘Team</u></h3>
            <a href="#" class="footerlinks"><p class="footer_lines" style="color: #ffffff;">➲KRUSHNA PATIL</p></a>
            <a href="#" class="footerlinks"><p class="footer_lines" style="color: #ffffff;">➲MAITREYA ZALTE</p></a>
            <img src="images/catlogo_wix.jpeg" alt="caltogo" height="80px" width="80px" class="logo_img">
        </div>
    </div>

    <!-- bootstrap js below -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>
