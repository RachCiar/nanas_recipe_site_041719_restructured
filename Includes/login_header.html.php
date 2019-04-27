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
        <link rel="stylesheet" type="text/css" href="css/login.css">
        <link href="https://fonts.googleapis.com/css?family=EB+Garamond" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>  
    <body>
        <?php
//If user is logged in, re-direct them to the member homepage which is member_index.php
        if (isset($_SESSION['user_id'])) {

            header("Location: member_index.php");
        } else { //  If the user is not logged in, display the default navigation bar
            $page_type = 'index';
            ?>

       
            <div class="hero-image"> 
                <div class="hero-text">
                    <h1 id="nana_title">Nana's Recipes</h1>
                </div>
                <div class="topnav" id="myTopnav"> 
                    <a href="index.php" title="Home Page">Home</a>
                    <a href="register.php" title="Register for the Site">Register</a>
                    <a href="login.php" title="Login">Login</a>
                    <a href="forgot_password.php" title="Password Retrieval">Retrieve Password</a>
                    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                        <i class="fa fa-bars"></i>
                    </a>
                </div>
           
       
        <?php } ?>

        <script src="js/style.js"></script>

        <!-- End of Header -->