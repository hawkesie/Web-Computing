<!-- replacement for the right sidebar which acknowledges the user that has logged in -->
<div id=rightbar>User<br><br>
<!-- Return the users name and a greeting message -->
Hello 
<?php echo $_SESSION['name'];?>
<br><br>
<!-- link for users to logout -->
<a href = 'logout.php'>Logout</a>


</div>