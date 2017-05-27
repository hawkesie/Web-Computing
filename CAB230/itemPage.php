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
<div id=content>
  <!-- Open and close the status div containers -->
<article itemscope itemtype="http://data-vocabulary.org/Review">
<?php
$GLOBAL['latitude']='';
$GLOBAL['longitude']='';
$GLOBAL['itemName']='';
if(isset($_GET['itemID'])){
  $ID=$_GET['itemID'];
  $_SESSION['itemID']=$ID;

  $pdo = dbConnect();

  //Get park information from ID in the URL. ID is unique so there shouldnt be an error.
  $pdoQuery = "SELECT * FROM parks WHERE id LIKE $ID";
  $stmt = $pdo->prepare($pdoQuery);
  $pdoExec = $stmt->execute();
  $itemName='';
  foreach($stmt as $row){
          $itemName=$row['Name'];
          $itemID=$row['id'];
          $street=$row['Street'];
          $suburb=$row['Suburb'];
          $latitude=$row['Latitude'];
          $longitude=$row['Longitude'];
          $averageRating=$row['AvgRating'];

          $GLOBAL['latitude']=$latitude;
          $GLOBAL['longitude']=$longitude;
          $GLOBAL['itemName']=$itemName;

          }

  echo"<h3 itemprop='itemreviewed'>$itemName</h3>";
  echo $itemName.' is in '.$suburb."<br><br>";
  echo "Average rating: " . $averageRating;
  echo'<br><br>';
  ?>

      <div id="map"></div>
      <script type="text/javascript">
      var itemName= "<?php echo $GLOBAL['itemName']; ?>";
      var latitude= <?php echo $GLOBAL['latitude']; ?>;
      var longitude= <?php echo $GLOBAL['longitude']; ?>;
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

  <?php
  if(isset($_GET['itemID'])){
    $itemID=$_GET['itemID'];
    $pdo = dbConnect();
    $pdoQ = "SELECT * FROM reviews INNER JOIN users ON users.id = reviews.userID ";
    $pdoQ.= "WHERE parkID = $itemID";
    $sub = $pdo->prepare($pdoQ);
    $pdoExec = $sub->execute();

    echo'<div><b>Reviews:</b>';
    echo '<table id="reviews">';
    echo '<tr id="top"><td>Comments';
    echo"<td>User</td>";
    echo"<td>Rating</td></tr>";

    foreach($sub as $row){
      $reviewID=$row['reviewID'];
      $userID=$row['userID'];
      $review=$row['review'];
      $rating=$row['rating'];
      $reviewDate=$row['reviewDate'];
      $userName=$row['name'];

      echo"<tr>";
      echo"<td itemprop='description'>$review</td>";
      echo"<td>$userName</td>";
      $rating=5;
      echo"<td itemprop='rating'>$rating</td>";    
      echo"</tr>";
    }
      echo'</table>';

  }
  ?>
  </article>

  <article itemscope itemtype="http://data-vocabulary.org/Place">
  <div itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">
    <meta itemprop="latitude" content= <?php echo $GLOBAL['latitude'];?> />
    <meta itemprop="longitude" content=<?php echo $GLOBAL['longitude']; ?> />
  </div>

  </div><!--Close reviews div -->

  </div><!--Close content div -->

  <!--  Holder for the footer of the web page  -->
  <div id=footer>Footer</div>
  </body>
  </html>
<?php
}
?>