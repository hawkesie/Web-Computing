<div id=rightbar>Right Sidebar<br><br>
Hello 
<?php echo $_SESSION['name'];?>
<br><br>

<button onclick="
<?php
	session_unset();
	session_destroy();
?>
"
>Logout</button>


</div>