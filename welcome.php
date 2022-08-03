<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
     //header("location: login.php");

     echo '<script>alert("You are logged out. Click OK to login!");</script>';

  echo '<script>setTimeout(function(){
      window.location.href = "login.php";
   }, 50);</script>';
}

//-----------------------------------------------------------------------------------

require_once "config.php";

$err = "";


$sent_adopt_request = 0;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    
        if (empty(trim($_POST["contact"])) || empty(trim($_POST["email"])) || empty(trim($_POST["cat"])) || empty(trim($_POST["address"])) || empty(trim($_POST["pincode"]))) {
            $err = "Kindly fill out all the fields...";
        }
        else {
            $sql = "INSERT INTO adopt (contact, email, cat, address, pincode) VALUES (?,?,?,?,?)";
            $stmt = mysqli_prepare($conn, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "sssss", $param_contact, $param_email, $param_cat, $param_address, $param_pincode);

                $param_contact = trim($_POST["contact"]);
                $param_email = trim($_POST["email"]);
                $param_cat = trim($_POST["cat"]);
                $param_address = trim($_POST["address"]);
                $param_pincode = trim($_POST["pincode"]);

                if (mysqli_stmt_execute($stmt)) {
                     $sent_adopt_request  += 1;
                     }
                     else {
                       echo "Something went wrong :(";
                     }
                   }
                   mysqli_stmt_close($stmt);
                
        
            }
        }
       


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adopt</title>

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

        if ($sent_adopt_request  == 1) {
          echo "We Appreciate That You Have Chosen To Adopt a " . $_POST["cat"] . "! Happy Parenting!";

           echo '<script>setTimeout(function(){window.location.href = "index.html";}, 7000);</script>';
        }

?>
</div> 


    <div class="container">
        
        <form action="" method="post" autocomplete = "off">
            <fieldset style="background-color: rgba(255, 255, 255, 0.63);">
                <legend><h1 style="font-family: cursive;"><u>Adopt</u></h1></legend>
            <table class="form_table">
                <tr>
                <td><label for="cat">➼Choose a cat to adopt :</label></td>
                  <td><select id="cat" name="cat">
                    <option value="Ragdoll">Ragdoll</option>
                    <option value="Persian">Persian</option>
                    <option value="British Shorthair">British Shorthair</option>
                    <option value="Abyssinian">Abyssinian</option>
                    <option value="Birman">Birman</option>
                    <option value="Russian Blue">Russian Blue</option>
                  </select></td>
                  </tr>

                  <tr>
                    <td>➼<label for="contact">Contact</label></td>
                    <td><input type="text" id="contact" name="contact" required placeholder="Enter Your 10 Digit Number" pattern="[0-9]{10}"></td>
                </tr>

                <tr>
                    <td>➼<label for="email">Email</label></td>
                    <td><input type="text" id="email" name="email" placeholder = "Enter Email"></td>
                </tr>

                  <tr>
                    <td><label for="address">➼Address</label></td>
                    <td><textarea name="address" id="" cols="30" rows="10"></textarea></td>
                </tr>

                <tr>
                    <td><label for="pincode">➼Pincode</label></td>
                    <td><input type="text" id = "pincode" name = "pincode" placeholder = "Enter Pincode"></td>
                </tr>
                <!-- options -->

                
            </table>
            <div style="text-align: center; margin-bottom: 10px; margin-top: 10px;"><button class="button button2" style="vertical-align:middle" value="submit"><span>Submit</span></button></div>
            </fieldset>
        </form>
    </div>
    
    <!-- <h4 style="margin-left: 45%;">Don't hav an account? <a href = "register_katzie.php">Register Here</a></h4> -->

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
