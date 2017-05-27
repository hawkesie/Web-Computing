<script type="text/javascript" src="includes/scripts/UserRegistrationPage.js"></script>

Write a review<br>

<!-- Create a form area with a text area for review text and radio buttons for a rating. onsubmit function finds if no rating has been selected and prevents submission -->
<form onsubmit="return ratingCheck()" name="reviewForm" method = "post">
<textarea rows="4" cols="50" name="textbox"></textarea><br><br>

 Rate:<br>
    <input type="radio" name="rating" value="1">1
    <input type="radio" name="rating" value="2">2
    <input type="radio" name="rating" value="3">3
    <input type="radio" name="rating" value="4">4
    <input type="radio" name="rating" value="5">5

<br><br>
<input type="submit" value="submit" name="submit">
</form>