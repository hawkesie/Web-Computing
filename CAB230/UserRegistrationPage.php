<!DOCTYPE html>
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
<!--  Heading at the top of the page  -->
 <h1>User Registration Page</h1>
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
<div id=rightbar>Right Sidebar<br><br>
<br><br>

</div>
  
<!-- Holder for the ain content area of the web page.   -->
<div id=content>Registration<br><br>

<!-- Form where users can input their information. The form elements include plain text and date formats  -->
<form onsubmit="return checkValues();">
   Name:<br>
    <input type="text" name="name" id="name"><br><br>
  Email:<br>
    <input type="text" name="email" id="email"><br><br>
  Username:<br>
    <input type="text" name="username"><br><br>
  Gender:<br>
    <input type="radio" name="gender" value="Male">Male
    <input type="radio" name="gender" value="Female">Female
    <input type="radio" name="gender" value="Other">Other<br><br>
  Date of Birth:<br>

  <select name="day">
    <option value="">Day</option>
    <?php for ($day = 1; $day <= 31; $day++) { ?>
    <option value="<?php echo strlen($day)==1 ? '0'.$day : $day; ?>"><?php echo strlen($day)==1 ? '0'.$day : $day; ?></option>
    <?php } ?>
  </select>
  <select name="month">
    <option value="">Month</option>
    <?php for ($month = 1; $month <= 12; $month++) { ?>
    <option value="<?php echo strlen($month)==1 ? '0'.$month : $month; ?>"><?php echo strlen($month)==1 ? '0'.$month : $month; ?></option>
    <?php } ?>
  </select>
  <select name="year">
    <option value="">Year</option>
    <?php for ($year = date('Y'); $year > date('Y')-100; $year--) { ?>
    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
    <?php } ?>
  </select><br><br>

  Postcode:<br>
    <input type="text" name="postcode" id="postcode"><br><br>
  Password:<br>
    <input type="text" name="password" id="password"><br><br>
  Confirm Password:<br>
    <input type="text" name="confirmPassword" id="confirmPassword"><br><br>
  <br>
  <input type="submit" value="Sign Up">
</form>

</div>
<!--  Holder for the footer of the web page  -->
<div id=footer>Footer</div>
 </body>
</html> 