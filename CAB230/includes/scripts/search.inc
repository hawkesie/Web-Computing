<?php
if (isset($_POST['submit'])){

  $pdo = dbConnect();

  //Query to find distinct parks only which match users search
  $pdoQuery = "SELECT DISTINCT id, Name, Street, Suburb, AvgRating, Latitude, Longitude FROM parks ";
  //Since we concat wildcard % to :itemName and :searchSuburb we don't have to run an if statement to check if null
  $pdoQuery.= "WHERE name LIKE :itemName ";
  $pdoQuery.= "AND Suburb LIKE :searchSuburb ";

  //Prevent XSS attacks prior to any execution
  $location = htmlspecialchars($_POST['location']);

  if (!empty($location)) {
    //Crazy code that draws a big circle around coordinates given by users location by the distance set by the user
    $pdoQuery.= "AND ( 6371 * acos( cos( radians(:latitude) ) * cos( radians( latitude ) ) 
* cos( radians( longitude ) - radians(:longitude) ) + sin( radians(:latitude) ) * sin(radians(latitude)) ) ) <= :location ";
  }

  //If rating is not empty, we want to search for it too
  if(!empty($_POST['rating'])) {

    $pdoQuery.= "AND (AvgRating IN ( ";
    //create an array and implode it to a format readable by SQL
    $ratingArray = implode(",", $_POST['rating']);
    //Add new SQL readable array to Query
    $pdoQuery.= $ratingArray." ) ";

    //if 'checkAll' is selected, also return results with no ratings (rating column == null)
    if(isset($_POST['checkAll'])) {
      $pdoQuery.= "OR AvgRating IS NULL ";
    }
    //Close the SQL 'IN' statement
    $pdoQuery.= ")";
  }


  //Prepare statement to prevent from any potential SQL injection attacks
  $stmt = $pdo->prepare($pdoQuery);

  //prevent XSS attacks
  $itemNameSecure = htmlspecialchars($_POST['itemName']);
  $searchSuburbSecure = htmlspecialchars($_POST['suburb']);

  //Add SQL wildcards
  $itemName = "%".$itemNameSecure."%";
  $searchSuburb = "%".$searchSuburbSecure."%";
  //Prevent XSS attacks to hidden fields in case hacker finds a way to input values into them
  $latitude = htmlspecialchars($_POST['latitude']);
  $longitude = htmlspecialchars($_POST['longitude']);

  //if location search is enabled, input values including those
  if (!empty($location)) {
    $pdoExec = $stmt->execute(array(
      ":itemName"=>$itemName,
      ":searchSuburb"=>$searchSuburb,
      ":latitude"=>$latitude,
      ":longitude"=>$longitude,
      ":location"=>$location));
  } else {
    //if location search not enabled, search only based on itemName and suburb (rating is added automatically)
    $pdoExec = $stmt->execute(array(
      ":itemName"=>$itemName,
      ":searchSuburb"=>$searchSuburb));
  }

  if($pdoExec){
      //Show the user what they searched for while preventing from XSS attacks
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



    //Return how many results were found
    if($stmt->rowCount()>0){
      echo("Found " . $stmt->rowCount() . " result");
      if($stmt->rowCount() > 1) {
        echo("s");
      }
      echo(".<br><br>");
      ?>

      <!-- Create table with a headins showing name, suburb and street -->
      <table id="searchResults">
        <tr>
            <th>Name</th>
            <th>Suburb</th> 
            <th>Street</th>
        </tr>
        <!-- initialise javascript arrays containing coordinates and name of each search to add a marker onto google maps -->
        <script type="text/javascript">
          var latitudeArray = [];
          var longitudeArray = [];
          var nameArray = [];
          var idArray = [];
        </script>

        <?php
        
        // initialise php arrays containing coordinates and name of each search to add a marker onto google maps
        $php_latitudeArray = array();
        $php_longitudeArray = array();
        $php_nameArray = array();
        $php_idArray = array();

        //For each result in the search
        foreach($stmt as $row){
          $itemName=$row['Name'];
          $itemID=$row['id'];
          $latitude=$row['Latitude'];
          $longitude=$row['Longitude'];
          $suburbResult=$row['Suburb'];
          $streetResult=$row['Street'];

          //Add each item onto the end of the arrays for map markers
          array_push($php_latitudeArray, $latitude);
          array_push($php_longitudeArray, $longitude);
          array_push($php_nameArray, $itemName);
          array_push($php_idArray, $itemID);

          echo("<tr>");
            ?>
            <!-- Turn the name of the park into a link to the individual parks page -->
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
  //Close the database connection
  dbClose($pdo, $stmt);
?>
    <script type='text/javascript'>
    <?php
      //Encode arrays to javascript readable arrays and make them javascript variables to be used for map markers
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

    <!-- Google map code to defer map from being created until the rest of the page has rendered -->
    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCkcm-34HojWSbCSmhhT--vnT9sYTWti0U&callback=initMap" >
    </script>
<?php
}
?>