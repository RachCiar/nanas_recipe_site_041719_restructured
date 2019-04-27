<?php
# Script 18.1 - header.html
// This page begins the HTML header for the site.
// Start output buffering:
ob_start();

// Initialize a session:
session_start();

// Check for a $page_title value:
if (!isset($page_title)) {
    $page_title = 'Nanas Recipes';
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $page_title; ?></title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=EB+Garamond" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <?php
// Display search menu on home page if user is logged in:
        if (isset($_SESSION['user_id'])) {
            $page_type = 'member_index';
            require(MYSQL); // Connect to the db.
            // Add links if the user is an administrator:
            ?>

            <div class="hero-image">
                <div class="welcome-message">
                    <h1>Welcome <?php
                        if (isset($_SESSION['first_name'])) {
                            echo ", {$_SESSION['first_name']}";
                        }
                        ?>
                    </h1>    
                </div>
                <div>
                    <div id="logout"> 
                        <a href="logout.php" title="Logout"><h1>Logout</h1></a>
                    </div>
                    <div id="chPass">
                        <a href="change_password.php" title="Change Your Password"><h1>Change Password</h1></a>
                    </div>
                </div>

                <div class="hero-text">
                    <h1>Nana's Recipes</h1>
                </div>
            </div>
            <div class="topnav" id="myTopnav">
                <a href="index.php" title="Home Page">Home  </a>
                <a href="" title="favorites"> Favorites  </a>
                <a href="new_recipe.php" title="Add New Recipe">  Add New Recipe </a>
                <?php
                if ($_SESSION['user_level'] == 1) {
                    echo '<a href="view_users.php" title="View All Users">View Users</a>';
                }
                ?>
                <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                    <i class="fa fa-bars"></i>
                </a>
                <div class="search-container">
                    <form action="view_recipes.php" method="post">
                        <input type="text" id="search" placeholder="Search.." name="search" size="60" maxlength="60">
                        <strong>Category</strong> 
                        <select id="category" name="category">
                            <?php
                            $q = "SELECT category_id, category_name FROM recipedb.category"; //SELECT the names of the category
                            $r = @mysqli_query($dbc, $q); // Run the query.
                            ?>
                            <option value=""></option>
                            <?php
                            while ($row = mysqli_fetch_array($r, MYSQLI_BOTH)) { //While there is a row to run, value=category_id and name=category_name
                                echo '<option value ="' . $row['category_id'] . '">' . $row['category_name'] . '</option>';
                            }
                            ?>
                        </select>
                        <input type="submit" name="submit" value="Search">              
                    </form>
                </div>
            </div>



            <script src="js/style.js"></script> <!-- This javascript src references the main js page for all the pages-->


            <?php
        } else { //  Not logged in. Re-direct them to the default home page. 
            header("Location: index.php");
        }
        ?>



        <!-- End of Header -->