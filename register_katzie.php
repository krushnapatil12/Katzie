<?php

require_once "config.php";

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

$successfully_registered = 0;

$email = $name = "";
$email_err = $name_err = "";

$city = $contact ="";
$city_err = $contact_err = "";

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (empty(trim($_POST["username"]))) {
        $username_err = "Username can't be empty. Please fill this required field";
    }
   else {
       $sql = "SELECT id FROM users WHERE username = ?";
       $stmt = mysqli_prepare($conn, $sql);

       if ($stmt) {
           mysqli_stmt_bind_param($stmt, "s", $param_username);

           $param_username = trim($_POST['username']);

           if (mysqli_stmt_execute($stmt)) {
               mysqli_stmt_store_result($stmt);

               if (mysqli_stmt_num_rows($stmt) == 1) {
                   $username_err = "This username has been taken. Kindly choose another username";
               }
               else {
                   $username = trim($_POST["username"]);
               }
           }
           else {
               echo "Something went wrong :(";
           }
       }
   }
   mysqli_stmt_close($stmt);

  //  ---------------------------------------------------------------------------------------------------------------------

   if (empty($_POST["email"])) {
     $email_err = "Email is required";
   }
    else {
      $sql = "SELECT * FROM users WHERE email = ?";
      $stmt = mysqli_prepare($conn, $sql);

      if ($stmt) {
        $param_email = null;
          mysqli_stmt_bind_param($stmt, "s", $param_email);

          $param_email = trim($_POST['email']);

          if (mysqli_stmt_execute($stmt)) {
              mysqli_stmt_store_result($stmt);

              if (mysqli_stmt_num_rows($stmt)==1) { //mysqli_stmt_num_rows($stmt)==1 mysqli_stmt_fetch($stmt)
                  $email_err = "Err : User with this email already exists!";
              }
              else {
                  $email = trim($_POST["email"]);
              }
          }
          else {
              echo "Something went wrong :(";
          }
      }
  }
  mysqli_stmt_close($stmt);

  //  else {
  //    $select = mysqli_query($conn, "SELECT * FROM users WHERE email = '". $_POST['email']."'");
  //    if($select) {
  //      //echo "This email already exists!";
  //      $email_err = "This email already exists!";
  //    }
  //    else {
  //      $email = trim($_POST["email"]);
  //    }
  //  }

  //  ---------------------------------------------------------------------------------------------------------------------

   if (empty(trim($_POST["password"]))) {
     $password_err = "Password can't be empty! Please fill the required field";
   }
   elseif (strlen(trim($_POST["password"])) < 5) {
     $password_err = "Err : Minimum length of password should be 5";
   }
   else {
     $password = trim($_POST["password"]);
   }

   //  ---------------------------------------------------------------------------------------------------------------------

   if (trim($_POST["password"]) != trim($_POST["confirm_password"])) {
     $confirm_password_err = "Passwords didn't match!";
   }

   //  ---------------------------------------------------------------------------------------------------------------------

   $name = test_input($_POST["name"]);
   if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
     $name_err = "Only letters and white space allowed";
   }

   //-----------------------------------------------------------------------------------------------------------------------

   if (empty(trim($_POST["contact"]))) {
       $contact_err = "Field Empty. Enter Contact Number";
   }
   else {
       $contact = trim($_POST["contact"]);
   }
   //------------------------------------------------------------------------------

   $city = $_POST["city"];

   //  ---------------------------------------------------------------------------------------------------------------------

  //  if (empty($_POST["email"])) {
  //   $email_err = "Email is required";
  // } else {
  //   $email = test_input($_POST["email"]);
  //   // check if e-mail address is well-formed
  //   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  //     $email_err = "Invalid email format";
  //   }
  // }

   //  ---------------------------------------------------------------------------------------------------------------------
   if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($name_err) && empty($email_err) && empty($contact_err)) {
     $sql = "INSERT INTO users (username, password, name, email, contact, city) VALUES (?, ?, ?, ?, ?, ?)";
     $stmt = mysqli_prepare($conn, $sql);

     if ($stmt) {
       mysqli_stmt_bind_param($stmt, "ssssss", $param_username, $param_password, $param_name, $param_email, $param_contact, $param_city);
       $param_username = $username;
       $param_password = password_hash($password, PASSWORD_DEFAULT);

       $param_name = $name;
       $param_email = $email;

       $param_contact = $contact;
       $param_city = $city;

       if (mysqli_stmt_execute($stmt)) {
      //    echo '<script>alert("Thank You For Registering! Proceed further for login...");</script>';
      //    echo '<script>setTimeout(function(){
      //     window.location.href = "login.php";
      //  }, 5000);</script>';

        //  header("location: login.php");

        $successfully_registered += 1;
       }
       else {
         echo "Something went wrong :(";
       }
     }
     mysqli_stmt_close($stmt);
  }
  mysqli_close($conn);
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

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
    
    
    <div style="background: rgb(255, 151, 151); text-align: center;"><?php
    
           if (!empty($username_err)) {
             echo $username_err;
           }
           elseif (!empty($password_err)) {
             echo $password_err;
           }
           elseif (!empty($confirm_password_err)) {
             echo $confirm_password_err;
           }
           elseif (!empty($name_err)) {
             echo $name_err;
           }
           elseif (!empty($email_err)) {
            echo $email_err;
          }

           elseif (!empty($contact_err)) {
               echo $contact_err;
           }
          //  else {
          //    echo "Thank You For Registering!";
          //  }

    ?></div>

    <div style="background: rgb(231, 255, 195); text-align: center;"><?php
    
            if ($successfully_registered == 1) {
              echo "Thank You For Registering!";

              echo '<script>alert("Thank You For Registering! Proceed further for login...");</script>';

              echo '<script>setTimeout(function(){
                     window.location.href = "login.php";
                  }, 3000);</script>';
            }
    
    ?></div>


    <div class="container">
        
        <form action="" method="post" autocomplete = "off">
            <fieldset style="background-color: rgba(255, 255, 255, 0.63);">
                <legend><h1 style="font-family: cursive;"><u>Register</u></h1></legend>
            <table class="form_table">
                <tr>
                    <td>➼<label for="name">Name</label></td>
                    <td><input type="text" id="name" name="name" placeholder="Enter Your Name"></td>
                </tr>

                <tr>
                    <td>➼<label for="email">Email</label></td>
                    <td><input type="text" id="email" name="email" required placeholder="Enter Your Email Address"></td>
                </tr>

                <tr>
                    <td>➼<label for="city">City</label></td>
                    <td><input type="text" id="city" name="city" required placeholder="Enter City Name"></td>
                </tr>

                <tr>
                    <td>➼<label for="contact">Contact Number</label></td>
                    <td><input type="text" id="contact" name="contact" required placeholder="Enter Your 10 Digit Number" pattern="[0-9]{10}"></td>
                </tr>

                <tr>
                    <td>➼<label for="username">Username</label></td>
                    <td><input type="text" id="username" name="username" placeholder = "Enter A Username"></td>
                </tr>

                <tr>
                    <td>➼<label for="password">Password</label></td>
                    <td><input type="password" id="password" name="password" required placeholder="Enter Password"></td>
                </tr>

                <tr>
                    <td>➼<label for="confirm_password">Confirm Password</label></td>
                    <td><input type="password" id="confirm_password" name="confirm_password" required placeholder="Enter Password"></td>
                </tr>


            </table>
            <div style="text-align: center; margin-bottom: 10px; margin-top: 10px;"><button class="button button2" style="vertical-align:middle" value="submit"><span>Submit</span></button></div>
            </fieldset>
        </form>
    </div>
    
    <h4 style="margin-left: 45%;">Already registered? <a href = "login.php">Login Here</a></h4>

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
