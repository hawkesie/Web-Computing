<div id=navigation>
Navigation<br><br>
<!-- Links in the navigation bar on the left side of the web page -->
<?php
if (!isset($_SESSION['name'])) {
?>
	<a href="UserRegistrationPage.php">Registration</a><br><br>
<?php }?>
<a href="search.php">Search</a><br><br>

</div>