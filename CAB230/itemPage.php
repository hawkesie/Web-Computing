<!DOCTYPE html>

<?php
  // include files and scripts we will be using
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
<?php
  $title = "Individual Item Page";
  include "includes/partials/header.inc";
  include "includes/partials/leftBar.inc";

  //Checks if a session is set for the correct right sidebar
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
//Initiate globals
$GLOBAL['latitude']='';
$GLOBAL['longitude']='';
$GLOBAL['itemName']='';

//Checks if an ID has been input in the URL and clears it of any attempted XSS attack

if(isset($_GET['itemID'])){
  //Attempt to parse itemID, if can't, set ID to null and redirect
  $ID = ctype_digit($_GET['itemID']) ? intval($_GET['itemID']) : null;
  if ($ID == null) {
    echo "Whoops, something went wrong!<br><br>Please search for you item again.";
  } else {
    //Has already been parsed, but just to be safe we use function htmlspecialchars().
    $ID=htmlspecialchars($_GET['itemID']);
    $_SESSION['itemID']=$ID;

    $pdo = dbConnect();

    //Get park information from ID in the URL. ID is unique so there shouldnt be an error.
    $pdoQuery = "SELECT * FROM parks WHERE id LIKE $ID";
    $stmt = $pdo->prepare($pdoQuery);
    $pdoExec = $stmt->execute();
    $itemName='';
    //Checks to see if user manually entered a value greater than the amount of parks in the database
    if($stmt->rowCount()>0){
      //For each item returned by the query, set variables to those we use
      foreach($stmt as $row){
              $itemName=$row['Name'];
              $itemID=$row['id'];
              $street=$row['Street'];
              $suburb=$row['Suburb'];
              $latitude=$row['Latitude'];
              $longitude=$row['Longitude'];
              $averageRating=$row['AvgRating'];

              //Set globals to send to javascript for use in map function
              $GLOBAL['latitude']=$latitude;
              $GLOBAL['longitude']=$longitude;
              $GLOBAL['itemName']=$itemName;

              }

      //echoing HTML to create the dynamic page
      echo"<h3 itemprop='itemreviewed'>$itemName</h3>";
      echo $itemName.' is in '.$suburb."<br><br>";
      echo "Average rating: " . $averageRating;
      echo'<br><br>';
      ?>

          <!-- Create div "map" for google map -->
          <div id="map"></div>
          <!-- Set javascript variables to use in google maps -->
          <script type="text/javascript">
          var itemName= "<?php echo $GLOBAL['itemName']; ?>";
          var latitude= <?php echo $GLOBAL['latitude']; ?>;
          var longitude= <?php echo $GLOBAL['longitude']; ?>;
          </script>

          <!-- Google script told to defer until the rest of the page is rendered -->
          <script async defer
          src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCkcm-34HojWSbCSmhhT--vnT9sYTWti0U&callback=initMap">
          </script>


      <br><br>
      <?php
      //If user is logged in, show the user input options for adding a review
      if(isset($_SESSION['name'])){  
        include "includes/scripts/reviewContent.inc";
      }
      ?>  

      <?php

        //Displays all of the reviews for that particular park
        $itemID=$_GET['itemID'];
        $pdo = dbConnect();
        $pdoQ = "SELECT * FROM reviews INNER JOIN users ON users.id = reviews.userID ";
        $pdoQ.= "WHERE parkID = $itemID";
        $sub = $pdo->prepare($pdoQ);
        $pdoExec = $sub->execute();

        //HTML table titles created for each review
        echo'<div><b>Reviews:</b>';
        echo '<table id="reviews">';
        echo '<tr id="top"><td>Comments';
        echo"<td>User</td>";
        echo"<td>Rating</td></tr>";

        //For every review, save each row required as a variable
        foreach($sub as $row){
          $reviewID=$row['reviewID'];
          $userID=$row['userID'];
          $review=$row['review'];
          $rating=$row['rating'];
          $reviewDate=$row['reviewDate'];
          $userName=$row['name'];

          //Create a new table row with each review element
          echo"<tr>";
          echo"<td itemprop='description'>$review</td>";
          echo"<td>$userName</td>";
          $rating=5;
          echo"<td itemprop='rating'>$rating</td>";    
          echo"</tr>";
        }
          echo'</table>';
        } else {
          echo "Whoops, something went wrong!<br><br>Please search for you item again.";
        }


  }
  ?>
  </article>

  <!-- Required for microdata -->
  <article itemscope itemtype="http://data-vocabulary.org/Place">
  <div itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">
    <meta itemprop="latitude" content= <?php echo $GLOBAL['latitude'];?> />
    <meta itemprop="longitude" content=<?php echo $GLOBAL['longitude']; ?> />
  </div>

  </div><!--Close reviews div -->

  </div><!--Close content div -->

  <!--  Holder for the footer of the web page  -->
  <?php
    include "includes/partials/footer.inc";
  ?>
  </body>
  </html>
<?php
} else {
  //This will only run if user enteres itemPage.php into the browser.
  echo "Whoops, something went wrong!<br><br>Please search for you item again.";
}
?>