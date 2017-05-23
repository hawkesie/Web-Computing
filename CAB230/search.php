<!DOCTYPE html>


<?php

  include"config/DBconfig.inc";
  include "includes/scripts/login.inc";

?>



<html>
 <head >
<!-- Links to the javascript file which contains the functions that are excuted on this page   -->
 <script type="text/javascript" src="includes/scripts/search.js"></script>
 <script type="text/javascript" src="includes/scripts/geolocation.js"></script>
<!--  Links to the css file which contains the syling instructions for the web page  -->
 <link href="lib/css/WebStyleSheet.css" rel="stylesheet" type="text/css"/>
<!-- Title which is shown in the tab of the web page  -->
 <title>Search Page</title>
 <meta charset="UTF-8">
 </head>
 <body>
<!--  Heading at the top of the page  -->
 <h1>Search Page</h1>
<div id=menu></div>
<div id=navigation>
Navigation<br><br>
<!-- Links in the navigation bar on the left side of the web page -->
<a href="UserRegistrationPage.php">Registration</a><br><br>
<a href="search.php">Search</a><br><br>
<a href="SampleResultsPage.html">Results</a><br><br>
<a href="SampleIndividualItemPage.html">Item</a><br>



</div>
<!--  Holder for the Right sidebar  -->
<?php

if (isset($_SESSION['name'])) {
    include "includes/scripts/rightSidebarLogged.inc";
}
else{
  include "includes/scripts/rightSidebar.inc";
}

//$suburbArray = array();
$pdo = dbConnect();

$sql = "SELECT DISTINCT suburb FROM parks ";
$sql.= "ORDER BY suburb ASC;";

$stmt = $pdo->prepare($sql);
$stmt->execute();

$suburbArray = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

//$itemName="";
?>

<!-- Holder for the ain content area of the web page.   -->
<div id=content>Search<br><br>
<form action="search.php" method="post">
  Name<br>
    <input type="text" name="itemName" id="itemName" value="<?php echo isset($_POST['itemName']) ? $_POST['itemName'] : '' ?>"><br><br>

  Suburb<br>
    <select name="suburb" id="suburb">

      <?php if (!empty($_POST['suburb'])) { ?>
        <option value="<?php echo $_POST["suburb"] ?>"><?php echo $_POST["suburb"] ?></option>
      <?php } ?>

      <option value=""></option>
      <?php foreach($suburbArray as $suburb => $value) { ?>
        <option value="<?php echo $value ?>"><?php echo $value ?></option>
      <?php } ?>
    </select><br><br>

  Rating<br>
    <label><input type="checkbox" name="checkAll" onClick="toggle(this)"/>Select/Deselect All</label>

    <div id="checkboxlist">
        <label><input type="checkbox" value="1" name="rating1" class="rating"/>1</label>
        <label><input type="checkbox" value="2" name="rating2" class="rating"/>2</label>
        <label><input type="checkbox" value="3" name="rating3" class="rating"/>3</label>
        <label><input type="checkbox" value="4" name="rating4" class="rating"/>4</label>
        <label><input type="checkbox" value="5" name="rating5" class="rating"/>5</label>
    </div>
    <br>
  Distance from me (km)<br>
    <input type="text" name="location" id="location" value="<?php echo isset($_POST['location']) ? $_POST['location'] : '' ?>"><br><br>
  <input type="submit" name="submit" value="Search" onclick="getLocation();">
</form><br><br>
  <input type="submit" name="get Location" value="Get Location" onclick="getLocation();">

<div id="status"></div>
<div id="mapholder"></div>
<?php



if (isset($_POST['submit'])){
  $pdo = dbConnect();

  $latitude = -27.451570399999998;
  $longitude = 153.0059279;

  $pdoQuery = "SELECT * FROM parks WHERE name LIKE :itemName ";
  $pdoQuery.= "AND Suburb LIKE :searchSuburb ";
  //$pdoQuery.= "AND (ACOS(SIN(RADIANS('latitude')) * SIN( RADIANS($latitude)) + COS(RADIANS('latitude')) * COS(RADIANS( $latitude)) * COS(RADIANS('longitude') - RADIANS($longitude))) * 6380) <= 5";
  $stmt = $pdo->prepare($pdoQuery);

  $itemName = "%".$_POST['itemName']."%";
  $searchSuburb = "%".$_POST['suburb']."%";

  $pdoExec = $stmt->execute(array(
    ":itemName"=>$itemName,
    ":searchSuburb"=>$searchSuburb));

  if($pdoExec){
    if($stmt->rowCount()>0){
      foreach($stmt as $row){
        $itemName=$row['Street'];
        echo $itemName."<br>";
      }
    }
    else{
      echo'Did not find anything';
    }
  }
  else{
  echo 'Error';
  }
  dbClose($pdo, $stmt);
}
?>  


</div>
<!--  Holder for the footer of the web page  -->
<div id=footer>Footer</div>
 </body>
</html> 

