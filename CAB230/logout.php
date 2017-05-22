

<?php
  
  include"config/DBconfig.inc";
  include "includes/scripts/login.inc";
  session_destroy();
  header("Location: userregistrationpage.php");
?>



