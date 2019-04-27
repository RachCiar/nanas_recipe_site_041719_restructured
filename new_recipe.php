<!DOCTYPE html>
<?php

// This is the Add new recipe page for the site.


require('includes/config.inc.php'); //include the config file
$page_title = 'New Recipe'; //Set the page title
include('includes/member_header.html.php'); //include the header
$userid = $_SESSION['user_id']; //declare the user ID variable that was saved in the session

if (isset($userid)){
    

if ($_SERVER['REQUEST_METHOD'] == 'POST') { //Handle the form.
    
    //Need the database connection:
    //require (MYSQL);
    
    //Trim all the incoming data:
    $trimmed= array_map('trim', $_POST);
   
    //Assume invalid values:
    $category = $recipeTitle = $description = $ingredients = $directions = FALSE;
    
       
    //Check for category
    if (isset($_POST['category_id'])){
        $category = $_POST['category_id'];
    }else{
        echo '<p class="error">Please choose a category.</p>';
    }
    
    // Check for a recipe title:
    if (preg_match('/^[A-Z \'.-]{2,20}$/i', $trimmed['recipe_title'])) {
        $recipeTitle = mysqli_real_escape_string($dbc, $trimmed['recipe_title']);
    } else {
        echo '<p class="error">Please enter the recipe title.</p>';
    }
     // Check for a description:
    if (isset($_POST['description'])) {
        $description = mysqli_real_escape_string($dbc, $trimmed['description']);
    } else {
        echo '<p class="error">Please enter the description.</p>';
    }
    
     // Check for a ingredients:
    if (isset($_POST['ingredients'])) {
        $ingredients = mysqli_real_escape_string($dbc, $trimmed['ingredients']);
    } else {
        echo '<p class="error">Please enter the ingredients.</p>';
    }
    
     // Check for a ingredients:
    if (isset($_POST['directions'])) {
        $directions = mysqli_real_escape_string($dbc, $trimmed['directions']);
    } else {
        echo '<p class="error">Please enter the directions.</p>';
    }
    
    if ($category && $recipeTitle && $description && $ingredients && $directions){
        //If everything is OK
        //Add to database
        $q = "INSERT INTO recipes (user_id, recipe_title, description, ingredients, directions, category_id) "
                . "VALUES ('$userid','$recipeTitle','$description','$ingredients','$directions','$category')";
        $r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($dbc));
        if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
            echo '<h3>Thank you for submitting a recipe.</h3>';
        }else{
            echo '<p class="error">We could not enter the new recipe due to a system error. We apologize for any inconvenience.</p>';
        }
    }
    mysqli_close($dbc);
    }//End of the submit conditional
?>
<body>
    <div id="Header">New Recipe</div>
    <div id="Content">
        <h1>Add New Recipe</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <fieldset>

                <p><strong>Category</strong> <select name="category_id">
                        <option value=""></option>
                        <option value="1">Appetizers</option>
                        <option value="2">Soups</option>
                        <option value="3">Entrees</option>
                        <option value="4">Meat</option>
                        <option value="5">Side Dishes</option>
                        <option value="6">Bread</option>
                        <option value="7">Salads</option>
                        <option value="8">Desserts</option>
                    </select></p>

                <p><strong>Recipe Title</strong><br>
                    <input type="text" name="recipe_title" size="60" maxlength="60" value="<?php
                    if (isset($trimmed['recipe_title'])) {
                        echo $trimmed['recipe_title'];
                    }
                    ?>"></p>

                <p><strong>Description</strong><br>
                    <textarea name="description" rows="4" cols="60"><?php
                    if (isset($trimmed['description'])) {
                        echo $trimmed['description'];
                    }
                    ?></textarea></p>


                <p><strong>Ingredients</strong>  Please put each ingredient on a new line.<br>
                    <textarea name="ingredients" rows="10" cols="60"><?php
                    if (isset($trimmed['ingredients'])) {
                        echo $trimmed['ingredients'];
                    }
                    ?></textarea></p>

                <p><strong>Directions</strong>  Please put each step on a new line.<br>
                    <textarea name="directions" rows="10" cols="60"><?php
                        if (isset($trimmed['directions'])) {
                            echo $trimmed['directions'];
                        }
                    ?></textarea></p>
              
            </fieldset>


            <div><input type="submit" name="submit" value="Submit"></div>
        </form>
    </div>

<?php 
}else{
    $url = 'index.php'; // Define the URL.
	ob_end_clean(); // Delete the buffer.
	header("Location: $url");
	exit(); // Quit the script.
}

include('includes/footer.html.php');
?>


