<!DOCTYPE html>

<?php
  // include files and scripts we will be using
  include"config/DBconfig.inc";
  include "includes/scripts/login.inc";
  include "includes/scripts/register.inc";
?>

<html>
 <head >
<!-- Links to the javascript file which contains the functions that are excuted on this page   -->
 <script type="text/javascript" src="includes/scripts/UserRegistrationPage.js"></script>
<!--  Links to the css file which contains the syling instructions for the web page  -->
 <link href="lib/css/WebStyleSheet.css" rel="stylesheet" type="text/css"/>
<!-- Title which is shown in the tab of the web page  -->
 <title>User Registration Page</title>
 <meta charset="UTF-8">
 </head>
 <body>


<?php
  //Include left sidebar and header and gives correct title for header
  $title = "User Registration Page";
  include "includes/partials/header.inc";
  include "includes/partials/leftBar.inc";
  
  //Checks if a session is set for the correct right sidebar
  if (isset($_SESSION['name'])) {
    include "includes/scripts/rightSidebarLogged.inc";
  }
  else{
    include "includes/scripts/rightSidebar.inc";
  }
?>
  
<!-- Holder for the ain content area of the web page.   -->
<div id=content>

<!-- Form where users can input their information. The form elements include plain text and date formats  -->
<form onsubmit="return checkValues()" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="registerForm" method = "post">
  Name:<br>
    <!-- put their name back into the value boxes (after checking for XSS entries) for denied registration -->
    <input type="text" name="name" id="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>">
    <?php
      //JS function to check entry
      checkName();
    ?>
  <br><br>
  Email:<br>
    <!-- put their email back into the value boxes (after checking for XSS entries) for denied registration -->
    <input type="email" name="email" id="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
      <?php
      //JS function to check entry
        checkEmailEntered();
        checkEmail();
      ?>
    <br><br>
  Username:<br>
    <!-- put their username back into the value boxes (after checking for XSS entries) for denied registration -->
    <input type="text" name="username" id="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
      <?php
      //JS function to check entry
        checkUsernameEntered();
        checkUsername();
      ?>
    <br><br>
  Gender:<br>
    <!-- Radiobuttons for Gender -->
    <input type="radio" name="gender" value="Male">Male
    <input type="radio" name="gender" value="Female">Female
    <input type="radio" name="gender" value="Other" checked="true">Other
    <?php
      //JS function to check entry
      checkGender();
    ?>
    <br><br>
  Date of Birth:<br>

  <!-- 3 dropdown Select menus for date of birth (day, month, year) -->
  <select name="day" id="day">
    <option value="">Day</option>
    <?php for ($day = 1; $day <= 31; $day++) { ?>
    <option value="<?php echo strlen($day)==1 ? '0'.$day : $day; ?>"><?php echo strlen($day)==1 ? '0'.$day : $day; ?></option>
    <?php } ?>
  </select>
  <select name="month" id="month">
    <option value="">Month</option>
    <?php for ($month = 1; $month <= 12; $month++) { ?>
    <option value="<?php echo strlen($month)==1 ? '0'.$month : $month; ?>"><?php echo strlen($month)==1 ? '0'.$month : $month; ?></option>
    <?php } ?>
  </select>
  <select name="year" id="year">
    <option value="">Year</option>
    <?php for ($year = date('Y'); $year > date('Y')-100; $year--) { ?>
    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
    <?php } ?>
  </select>
    <?php
      //JS function to check entry
      checkBirthDate();
    ?>
  <br><br>

  Postcode:<br>
    <!-- put their postcode back into the value boxes (after checking for XSS entries) for denied registration -->
    <input type="text" name="postcode" id="postcode" value="<?php echo isset($_POST['postcode']) ? htmlspecialchars($_POST['postcode']) : '' ?>">
    <?php
      //JS function to check entry
      checkPostcode();
    ?>
  <br><br>
  Password:<br>
    <!-- put their password back into the value boxes (after checking for XSS entries) for denied registration -->
    <input type="password" name="password" id="password">
    <?php
      //JS function to check entry
      checkPassword();
    ?>
  <br><br>
  Confirm Password:<br>
    <!-- put their confirmed password back into the value boxes (after checking for XSS entries) for denied registration -->
    <input type="password" name="confirmPassword" id="confirmPassword">
    <?php
      //JS function to check correct entry
      checkConfirmPassword();
      checkPasswordMatch();
    ?>
  <br><br>
  <br>
  <input type="submit" value="Register">
</form>

</div>
<!--  Holder for the footer of the web page  -->
<?php
  include "includes/partials/footer.inc";
?>
 </body>
</html> 

