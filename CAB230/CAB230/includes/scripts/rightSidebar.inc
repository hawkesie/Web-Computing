<div id=rightbar>Right Sidebar<br><br>
<br><br>

<form name="loginForm" method = "post">
  Username:<br>
    <input type="text" name="loginUsername"><br><br>
  Password:<br>
    <input type="text" name="loginPassword"><br><br>
  <input type="submit" value="Login" name="login">
  <?php
    checkUsernamePasswordCombination();
  ?>
</form>



</div>
