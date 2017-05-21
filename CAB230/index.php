<!DOCTYPE html>

<html>
 <head >
<!-- Links to the javascript file which contains the functions that are excuted on this page   -->
 <script type="text/javascript" src="includes/scripts/UserRegistrationPage.js"></script>
<!--  Links to the css file which contains the syling instructions for the web page  -->
 <link href="lib/css/WebStyleSheet.css" rel="stylesheet" type="text/css"/>
<!-- Title which is shown in the tab of the web page  -->
<?php
  session_start();
  $id = $_SESSION['id'];
  $name = $_SESSION['name'];
  $email = $_SESSION['email'];
  $username = $_SESSION['username'];
?>

<title>Brisbane Parks</title>
<meta charset="UTF-8">
</head>
<body>
<!--  Heading at the top of the page  -->
 <h1>Brisbane Parks</h1>
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
<div id=content>
  Testing that session works<br><br>
  userID = <?php echo $id ?><br>
  name = <?php echo $name ?><br>
  email = <?php echo $email ?><br>
  username = <?php echo $username ?><br>

</div>
<!--  Holder for the footer of the web page  -->
<div id=footer>Footer</div>
 </body>
</html> 
