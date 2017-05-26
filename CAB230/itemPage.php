<!DOCTYPE html>


<?php
  include"config/DBconfig.inc";
  include "includes/scripts/login.inc";
  include "includes/scripts/review.inc";
?>



<html>
 <head >
<!-- Links to the javascript file which contains the functions that are excuted on this page   -->
 <script type="text/javascript" src="includes/scripts/individualMap.js"></script>
<!--  Links to the css file which contains the syling instructions for the web page  -->
 <link href="lib/css/WebStyleSheet.css" rel="stylesheet" type="text/css"/>
<!-- Title which is shown in the tab of the web page  -->
 <title>Individual Item Page</title>
 <meta charset="UTF-8">
 </head>
 <body>
<!--  Heading at the top of the page  -->
 <h1>Individual Item Page</h1>
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

?>

<!-- Holder for the ain content area of the web page.   -->
<div id=content>Item Page<br><br>
  <!-- Open and close the status div containers -->

<?php
$GLOBAL['latitude']='';
$GLOBAL['longitude']='';
if(isset($_GET['itemID'])){
  $ID=$_GET['itemID'];
  $_SESSION['itemID']=$ID;

  $pdo = dbConnect();

  //Get park information from ID in the URL. ID is unique so there shouldnt be an error.
  $pdoQuery = "SELECT * FROM parks WHERE id LIKE $ID";
  $stmt = $pdo->prepare($pdoQuery);
  $pdoExec = $stmt->execute();
  foreach($stmt as $row){
          $itemName=$row['Name'];
          $itemID=$row['id'];
          $street=$row['Street'];
          $suburb=$row['Suburb'];
          $latitude=$row['Latitude'];
          $GLOBAL['latitude']=$latitude;
          
          $longitude=$row['Longitude'];
          $GLOBAL['longitude']=$longitude;
          $averageRating=$row['AvgRating'];

          }

  echo $itemName.' is in '.$suburb."<br><br>";
  echo "Average rating: " . $averageRating;
  echo'<br><br>';


}
?>

    <div id="map"></div>
    <script type="text/javascript">
      var latitude= <?php echo $GLOBAL['latitude']; ?>;
      var longitude= <?php echo $GLOBAL['longitude']; ?>;
      initMap();
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCkcm-34HojWSbCSmhhT--vnT9sYTWti0U&callback=initMap">
    </script>


<br><br>
<?php
if(isset($_SESSION['name'])){
  
  include "includes/scripts/reviewContent.inc";
}
?>
<br><br>

<?php
if(isset($_GET['itemID'])){
  $itemID=$_GET['itemID'];
  $pdo = dbConnect();
  $pdoQ = "SELECT * FROM reviews INNER JOIN users ON users.id = reviews.userID ";
  $pdoQ.= "WHERE parkID = $itemID";
  $sub = $pdo->prepare($pdoQ);
  $pdoExec = $sub->execute();
  echo'<div>Reviews:';
  echo '<table id="reviews">';
  echo '<tr id="top"><td>Comments';
  echo"<td>User</td>";
  echo"<td>Rating<br></td></tr>";

  foreach($sub as $row){
          $reviewID=$row['reviewID'];
          $userID=$row['userID'];
          $review=$row['review'];
          $rating=$row['rating'];
          $reviewDate=$row['reviewDate'];
          $userName=$row['name'];

    echo"<tr><td>";
    echo"$review</td>";

    echo"<td>$userName<br></td>";
    echo"<td>$rating<br></td>";
      
    echo"</tr>";


        }
        echo'</table>';

}

?>
</div>


</div>

<!--  Holder for the footer of the web page  -->
<div id=footer>Footer</div>
 </body>
</html> 