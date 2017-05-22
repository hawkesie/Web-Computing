<div id=rightbar>Right Sidebar<br><br>
Hello 
<?php echo $_SESSION['name'];?>
<br><br>

<button onclick="<?php if(isset($_SESSION['name'])){
	session_destroy();
	}
?>"
>Logout</button>


</div>