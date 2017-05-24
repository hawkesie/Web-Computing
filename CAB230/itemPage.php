<!DOCTYPE html>


<?php
  include"config/DBconfig.inc";
  include "includes/scripts/login.inc";
  include "includes/scripts/review.inc";
?>



<html>
 <head >
<!-- Links to the javascript file which contains the functions that are excuted on this page   -->
 <script type="text/javascript" src="includes/scripts/search.js"></script>
<!--  Links to the css file which contains the syling instructions for the web page  -->
 <link href="lib/css/WebStyleSheet.css" rel="stylesheet" type="text/css"/>
<!-- Title which is shown in the tab of the web page  -->
 <title>Individual Item Page</title>
 <meta charset="UTF-8">
 </head>
 <body>
<!--  Heading at the top of the page  -->
 <h1>Individual Item Page</h1>
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

?>

<!-- Holder for the ain content area of the web page.   -->
<div id=content>Item Page<br><br>
  <!-- Open and close the status div containers -->

<?php
if(isset($_GET['itemID'])){
$ID=$_GET['itemID'];


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
        $longitude=$row['Longitude'];
        }

echo $itemName.' is in '.$suburb;
echo'<br><br>';

//Generate google map image of park
$imgurl='http://maps.googleapis.com/maps/api/staticmap?center='.$latitude.','.$longitude.'&zoom=14&size=400x300&sensor=false';
$imageData = base64_encode(file_get_contents($imgurl));
echo '<img src="data:image/jpeg;base64,'.$imageData.'">';
}
?>

<br><br>
<?php
if(isset($_SESSION['name'])){
  include "includes/scripts/reviewContent.inc";;
}
?>

</div>

<!--  Holder for the footer of the web page  -->
<div id=footer>Footer</div>
 </body>
</html> 