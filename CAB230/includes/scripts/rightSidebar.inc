
<div id=rightbar>Right Sidebar<br><br>
<br><br>

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
