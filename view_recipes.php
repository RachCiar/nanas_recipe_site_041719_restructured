<?php

// This is the View recipe page for the site.
require('includes/config.inc.php'); //include the config file
$page_title = 'View Recipe'; //Set the page title 
include('includes/member_header.html.php'); //include the header
$userid = $_SESSION['user_id']; //declare the user ID variable that was saved in the session

       
if (isset($userid) && (isset($_GET['rid']) && is_numeric($_GET['rid']))) {
    
    $rid = ($_GET['rid']); //Assign Recipe_id to $rid
    $q = "SELECT * FROM recipes AS R INNER JOIN category AS C "; // SELECT from recipes where rid = recipe_id in database field
    $q .= "ON R.category_id = C.category_id ";
    $q .= "WHERE '$rid' LIKE recipe_id";
    $r = @mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($dbc));; // Run the query.
    if ($r) {
        // Fetch and print all the records:
        while ($row = mysqli_fetch_array($r, MYSQLI_BOTH)) {

            echo '<div><fieldset><h2>' . $row['recipe_title'] . '</h2></fieldset></div>
                        <div><fieldset><h3>' . $row['category_name'] . '</fieldset></h3></div>
                        <div><fieldset>' . $row['description'] . '</fieldset></div>
                            <div><fieldset>' . $row['ingredients'] . '</fieldset></div>
                                <div><fieldset>' . $row['directions'] . '</fieldset></div>';
        }


        echo '<p><input type="checkbox" checked="checked" name="favorites" value="1" id="favCheckbox">Add to favorites</p>';
    }
    mysqli_free_result($r); // Free up the resources.

    mysqli_close($dbc); // Close the database connection.
} else {
    	header("Location: index.php");
	
}

?>
  <?php include('includes/footer.html.php'); ?>

<script>
$("#favCheckbox").click(function (){
    var favorite = document.getElementbyId("favCheckbox").value;
    var newFavUrlInt = favorite;
    
    $.post("add_favorites.php", newFavUrlInt, function (response){
        
    })
    
});
</script>