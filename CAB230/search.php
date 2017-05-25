<!DOCTYPE html>


<?php

  include"config/DBconfig.inc";
  include "includes/scripts/login.inc";

?>

<html>
 <head >
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
 <h1>Search Page</h1>
<div id=menu></div>
<div id=navigation>
Navigation<br><br>
<!-- Links in the navigation bar on the left side of the web page -->
<a href="UserRegistrationPage.php">Registration</a><br><br>
<a href="search.php">Search</a><br><br>
<a href="itemPage.php">Item</a><br>

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
    <label><input type="checkbox" name="checkAll" onClick="toggle(this)"/>Any</label>

    <div id="checkboxlist">
        <label><input type="checkbox" value="1" name="rating[]" class="rating"/>1</label>
        <label><input type="checkbox" value="2" name="rating[]" class="rating"/>2</label>
        <label><input type="checkbox" value="3" name="rating[]" class="rating"/>3</label>
        <label><input type="checkbox" value="4" name="rating[]" class="rating"/>4</label>
        <label><input type="checkbox" value="5" name="rating[]" class="rating"/>5</label>
    </div>
    <br>
  Distance from me in km (Location must be enabled)<br>
    <input type="text" name="location" id="location" readonly>
    <input type="checkbox" onClick="locationToggle()">Enable<br><br>

  <input type="hidden" name="latitude" id="latitude"></input>
  <input type="hidden" name="longitude" id="longitude"></input>

  <input type="submit" name="submit" value="Search">
</form><br><br>
<?php



if (isset($_POST['submit'])){
  $pdo = dbConnect();

  $pdoQuery = "SELECT DISTINCT id, Name, Street, Suburb, AvgRating, Latitude, Longitude FROM parks ";

  if(!empty($_POST['rating'])) {
    $pdoQuery.= "INNER JOIN reviews ON parks.id = reviews.parkID ";
  }

  $pdoQuery.= "WHERE name LIKE :itemName ";
  $pdoQuery.= "AND Suburb LIKE :searchSuburb ";

  if (!empty($_POST['location'])) {
    $pdoQuery.= "AND ( 6371 * acos( cos( radians(:latitude) ) * cos( radians( latitude ) ) 
* cos( radians( longitude ) - radians(:longitude) ) + sin( radians(:latitude) ) * sin(radians(latitude)) ) ) <= :location ";
  }

  if(!empty($_POST['rating'])) {
    $pdoQuery.= "AND AvgRating IN ( ";
    $ratingArray = implode(",", $_POST['rating']);
    $pdoQuery.= $ratingArray." )";
  }

  $stmt = $pdo->prepare($pdoQuery);

  $itemName = "%".$_POST['itemName']."%";
  $searchSuburb = "%".$_POST['suburb']."%";
  $location = $_POST['location'];
  $latitude = $_POST['latitude'];
  $longitude = $_POST['longitude'];

  if (!empty($_POST['location'])) {
    $pdoExec = $stmt->execute(array(
      ":itemName"=>$itemName,
      ":searchSuburb"=>$searchSuburb,
      ":latitude"=>$latitude,
      ":longitude"=>$longitude,
      ":location"=>$location));
  } else {
    $pdoExec = $stmt->execute(array(
      ":itemName"=>$itemName,
      ":searchSuburb"=>$searchSuburb));
  }

  if($pdoExec){

      echo("Showing results");
      if (!empty($_POST['itemName'])) {
        echo(" containing \"" . $_POST['itemName'] . "\"");
      }
      if (!empty($_POST['suburb'])) {
        echo(" in " . $_POST['suburb']);
      }
      if (!empty($_POST['rating'])) {
        echo(" with average ratings of " . implode(", ", $_POST['rating']));
      }
      if (!empty($_POST['location'])) {
        echo(" within " . $_POST['location'] . " kilometers of your location");
      }
      echo(".<br><br>");




    if($stmt->rowCount()>0){
      echo("Found " . $stmt->rowCount() . " result");
      if($stmt->rowCount() > 1) {
        echo("s");
      }
      echo(".<br><br>");
      ?>

      <table id="searchResults">
        <tr>
            <th>Name</th>
            <th>Suburb</th> 
            <th>Street</th>
        </tr>

        <?php
        foreach($stmt as $row){
          $itemName=$row['Name'];
          $itemID=$row['id'];
          $latitude=$row['Latitude'];
          $longitude=$row['Longitude'];
          $suburbResult=$row['Suburb'];
          $streetResult=$row['Street'];
          echo("<tr>");
            ?>
            <td><a href="http://localhost/web-computing/CAB230/itemPage.php?itemID=<?php echo $itemID;?>"><?php echo $itemName;?></a></td>
            <?php
            echo("<td>" . $suburbResult . "</td>");
            echo("<td>" . $streetResult . "</td>");
          echo("</tr>");
        }
        echo("</table>");
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

