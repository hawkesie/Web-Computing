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
<?php
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
<div id=content>Search<br><br>
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

<?php
if (isset($_POST['submit'])){

  $pdo = dbConnect();

  $pdoQuery = "SELECT DISTINCT id, Name, Street, Suburb, AvgRating, Latitude, Longitude FROM parks ";

  $pdoQuery.= "WHERE name LIKE :itemName ";
  $pdoQuery.= "AND Suburb LIKE :searchSuburb ";

  $location = htmlspecialchars($_POST['location']);

  if (!empty($location)) {
    $pdoQuery.= "AND ( 6371 * acos( cos( radians(:latitude) ) * cos( radians( latitude ) ) 
* cos( radians( longitude ) - radians(:longitude) ) + sin( radians(:latitude) ) * sin(radians(latitude)) ) ) <= :location ";
  }

  if(!empty($_POST['rating'])) {

    $pdoQuery.= "AND (AvgRating IN ( ";
    $ratingArray = implode(",", $_POST['rating']);
    $pdoQuery.= $ratingArray." ) ";

    if(isset($_POST['checkAll'])) {
      $pdoQuery.= "OR AvgRating IS NULL ";
    }
    $pdoQuery.= ")";
  }

  $stmt = $pdo->prepare($pdoQuery);

  $itemNameSecure = htmlspecialchars($_POST['itemName']);
  $searchSuburbSecure = htmlspecialchars($_POST['suburb']);

  $itemName = "%".$itemNameSecure."%";
  $searchSuburb = "%".$searchSuburbSecure."%";
  $latitude = htmlspecialchars($_POST['latitude']);
  $longitude = htmlspecialchars($_POST['longitude']);

  if (!empty($location)) {
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
      if (!empty($itemNameSecure)) {
        echo(" containing \"" . $itemNameSecure . "\"");
      }
      if (!empty(htmlspecialchars($_POST['suburb']))) {
        echo(" in " . htmlspecialchars($_POST['suburb']));
      }
      if (!empty($_POST['rating'])) {
        echo(" with average ratings of " . implode(", ", $_POST['rating']));
      }
      if (!empty($location)) {
        echo(" within " . $location . " kilometer");
        if ($location != 1) {
          echo("s");
        }
        echo(" of your location");
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
        <script type="text/javascript">
          var latitudeArray = [];
          var longitudeArray = [];
          var nameArray = [];
          var idArray = [];
        </script>

        <?php

        $php_latitudeArray = array();
        $php_longitudeArray = array();
        $php_nameArray = array();
        $php_idArray = array();

        foreach($stmt as $row){
          $itemName=$row['Name'];
          $itemID=$row['id'];
          $latitude=$row['Latitude'];
          $longitude=$row['Longitude'];
          $suburbResult=$row['Suburb'];
          $streetResult=$row['Street'];

          array_push($php_latitudeArray, $latitude);
          array_push($php_longitudeArray, $longitude);
          array_push($php_nameArray, $itemName);
          array_push($php_idArray, $itemID);

          echo("<tr>");
            ?>
            <td><a href="itemPage.php?itemID=<?php echo $itemID;?>"><?php echo $itemName;?></a></td>
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
?>
    <script type='text/javascript'>
    <?php
      $js_latitudeArray = json_encode($php_latitudeArray);
      $js_longitudeArray = json_encode($php_longitudeArray);
      $js_nameArray = json_encode($php_nameArray);
      $js_idArray = json_encode($php_idArray);
      echo "var latitudeArray = " . $js_latitudeArray . ";";
      echo "var longitudeArray = " . $js_longitudeArray . ";";
      echo "var nameArray = " . $js_nameArray . ";";
      echo "var idArray = " . $js_idArray . ";";
    ?>
    </script>
    <script async defer

      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCkcm-34HojWSbCSmhhT--vnT9sYTWti0U&callback=initMap" >
    </script>
<?php
}
?>


</div>
<!--  Holder for the footer of the web page  -->
<div id=footer>Footer</div>
 </body>
</html