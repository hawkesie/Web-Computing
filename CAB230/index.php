<!DOCTYPE html>
<?php

  include"config/DBconfig.inc";
  include "includes/scripts/login.inc";

?>
<html>
 <head >
<!-- Links to the javascript file which contains the functions that are excuted on this page   -->
 <script type="text/javascript" src="includes/scripts/UserRegistrationPage.js"></script>
<!--  Links to the css file which contains the syling instructions for the web page  -->
 <link href="lib/css/WebStyleSheet.css" rel="stylesheet" type="text/css"/>
<!-- Title which is shown in the tab of the web page  -->


<title>Brisbane Parks</title>
<meta charset="UTF-8">
</head>
<body>
<!--  Heading at the top of the page  -->
<?php
	$title = "Brisbane Parks";
    include "includes/partials/header.inc";
    include "includes/partials/leftBar.inc";
?>



</div>
<!--  Holder for the Right sidebar  -->
<?php

if (isset($_SESSION['name'])) {
    include "includes/scripts/rightSidebarLogged.inc";
}
else{
  include "includes/scripts/rightSidebar.inc";
}
?>

</div>
  
<!-- Holder for the ain content area of the web page.   -->
<div id=content>
  <h3>Welcome to Brisbane Parks</h3>
  <p>Have a lovely day!</p>

</div>
<!--  Holder for the footer of the web page  -->
<?php
  include "includes/partials/footer.inc";
?>
 </body>
</html> 
