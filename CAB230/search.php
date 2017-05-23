<!DOCTYPE html>


<?php

  include"config/DBconfig.inc";
  include "includes/scripts/login.inc";
?>



<html>
 <head >
<!-- Links to the javascript file which contains the functions that are excuted on this page   -->
 <script type="text/javascript" src="includes/scripts/UserRegistrationPage.js"></script>
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

$itemName="";
?>

<!-- Holder for the ain content area of the web page.   -->
<div id=content>Search<br><br>
<form action="search.php" method="post">
  <input type="text" name="itemName" id="itemName" value="<?php echo $itemName;?>"> Name<br><br>

  <select name="suburb" id="suburb">
    <option value=""> Suburb</option>
    <?php foreach($suburbArray as $suburb => $value) { ?>
      <option value="<?php echo $suburb ?>"><?php echo $value ?></option>
    <?php }?>
  </select>

  <input type="text" name="rating" id="rating"> Rating
  <input type="text" name="location" id="location"> Location<br><br>
  <input type="submit" name="submit" value="Search">
</form><br><br>


<?php

if (isset($_POST['submit'])){
  $pdo = dbConnect();
  $itemName = "%".$_POST['itemName']."%";
  $pdoQuery = "SELECT * FROM parks WHERE Name LIKE :itemName";
  $stmt = $pdo->prepare($pdoQuery);
  $pdoExec = $stmt->execute(array(":itemName"=>$itemName));

  if($pdoExec){
    if($stmt->rowCount()>0){
      foreach($stmt as $row){
        $itemName=$row['Street'];
        echo $itemName;
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

