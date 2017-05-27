<div id=rightbar><br>Already a member?<br>
<br>
<!-- Login form for the right sidebar. This will be accessible from every page if a user is not logged in -->
<form name="loginForm" method = "post">
  Username:<br>
  <input type="text" name="loginUsername" id="loginText"><br><br>
  Password:<br>
  <input type="text" name="loginPassword" id="loginText"><br><br>
  <input type="submit" value="Login" name="login">
  <?php
    checkUsernamePasswordCombination();
  ?>
</form>

</div>
