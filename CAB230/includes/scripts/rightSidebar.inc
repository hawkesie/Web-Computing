
<div id=rightbar>Right Sidebar<br><br>
<br><br>

<form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="loginForm" method = "post">
  Username:<br>
    <input type="text" name="loginUsername"><br><br>
  Password:<br>
<<<<<<< HEAD
    <input type="text" name="loginPassword"><br><br>
=======
    <input type="text" name="logpassword" id="logpassword"><br><br>
>>>>>>> 86b9f29d6178a4fd526d6089e30690bb359db497
  <input type="submit" value="Login" name="login">
  <?php

    checkUsernamePasswordCombination();
  ?>
</form>



</div>
