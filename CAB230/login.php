<!DOCTYPE html>

<?php
  include "includes/scripts/login.inc";
  include "includes/functions.inc";
?>

<html>
 <head >
<!-- Links to the javascript file which contains the functions that are excuted on this page   -->
 <script type="text/javascript" src="includes/scripts/UserRegistrationPage.js"></script>
<!--  Links to the css file which contains the syling instructions for the web page  -->
 <link href="lib/css/WebStyleSheet.css" rel="stylesheet" type="text/css"/>
<!-- Title which is shown in the tab of the web page  -->
 <title>Login</title>
 <meta charset="UTF-8">
 </head>
 <body>
<!--  Heading at the top of the page  -->
 <h1>Login</h1>
<div id=menu></div>
<div id=navigation>
Navigation<br><br>
<!-- Links in the navigation bar on the left side of the web page -->
<a href="UserRegistrationPage.html">Registration</a><br><br>
<a href="SearchPage.html">Search</a><br><br>
<a href="SampleResultsPage.html">Results</a><br><br>
<a href="SampleIndividualItemPage.html">Item</a><br>



</div>
<!--  Holder for the Right sidebar  -->
<?php
include "includes/scripts/righSidebar.inc"
?>
  
<!-- Holder for the ain content area of the web page.   -->
<div id=content>Login<br><br>

<!-- Form where users can login.-->
<form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="loginForm" method = "post">
  Username:<br>
    <input type="text" name="username"><br><br>
  Password:<br>
    <input type="text" name="password" id="password"><br><br>
  <input type="submit" value="Login" name="login">
  <?php
    checkUsernamePasswordCombination();
  ?>
</form>

</div>
<!--  Holder for the footer of the web page  -->
<div id=footer>Footer</div>
 </body>
</html> 
