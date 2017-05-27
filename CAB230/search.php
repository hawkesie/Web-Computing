<!DOCTYPE html>


<?php
  include"config/DBconfig.inc";
  include "includes/scripts/login.inc";
?>

<html>
<head>
<!-- Links to the javascript file which contains the functions that are excuted on this page   -->
  <script type="text/javascript" src="includes/scripts/search.js"></script>
<!--  Links to the css file which contains the syling instructions for the web page  -->
  <link href="lib/css/WebStyleSheet.css" rel="stylesheet" type="text/css"/>
<!-- Title which is shown in the tab of the web page  -->
  <title>Search Page</title>
  <meta charset="UTF-8">
</head>
<body>
<!--  Heading at the top of the page  -->
<?php
  $title = "Search Page";
  include "includes/partials/header.inc";
  include "includes/partials/leftBar.inc";
?>
<!--  Holder for the Right sidebar  -->
<?php

  if (isset($_SESSION['name'])) {
      include "includes/scripts/rightSidebarLogged.inc";
  }
  else{
    include "includes/scripts/rightSidebar.inc";
  }

  $pdo = dbConnect();

  $sql = "SELECT DISTINCT suburb FROM parks ";
  $sql.= "ORDER BY suburb ASC;";

  $stmt = $pdo->prepare($sql);
  $stmt->execute();

  $suburbArray = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

?>

<!-- Holder for the ain content area of the web page.   -->
<div id=content>
<form action="search.php" method="post" onSubmit="initMap()">
  Name<br>
    <input type="text" name="itemName" id="itemName" value="<?php echo isset($_POST['itemName']) ? htmlspecialchars($_POST['itemName']) : '' ?>"><br><br>

  Suburb<br>
    <select name="suburb" id="suburb">

      <?php if (!empty($_POST['suburb'])) { ?>
        <option value="<?php echo $_POST["suburb"] ?>"><?php echo htmlspecialchars($_POST["suburb"]) ?></option>
      <?php } ?>

      <option value=""></option>
      <?php foreach($suburbArray as $suburb => $value) { ?>
        <option value="<?php echo $value ?>"><?php echo $value ?></option>
      <?php } ?>
    </select><br><br>

  Rating<br>
    <label><input type="checkbox" name="checkAll" onClick="toggle(this)"/>Any</label>

    <div id="checkboxlist">
        <label><input type="checkbox" value="1" name="rating[]" class="rating"/>1</label>
        <label><input type="checkbox" value="2" name="rating[]" class="rating"/>2</label>
        <label><input type="checkbox" value="3" name="rating[]" class="rating"/>3</label>
        <label><input type="checkbox" value="4" name="rating[]" class="rating"/>4</label>
        <label><input type="checkbox" value="5" name="rating[]" class="rating"/>5</label>
    </div>
    <br>
  Maximum distance in kilometres (Location must be enabled)<br>
    <input type="text" name="location" id="location" readonly>
    <input type="checkbox" onClick="locationToggle()">Enable<br><br>

  <input type="hidden" name="latitude" id="latitude"></input>
  <input type="hidden" name="longitude" id="longitude"></input>

  <input type="submit" name="submit" value="Search">
</form><br><br>

<div id="map"></div>

<!-- Run the search.inc script -->
<?php
  include "includes/scripts/search.inc";
?>


</div>
<!--  Holder for the footer of the web page  -->
<?php
  include "includes/partials/footer.inc";
?>
 </body>
</html