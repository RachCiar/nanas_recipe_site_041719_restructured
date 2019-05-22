<?php
require('includes/config.inc.php'); //include the config file
$page_title = 'Favorite Recipes'; //Set the page title
include('includes/member_header.html.php'); //include the header
$userid = $_SESSION['user_id']; //declare the user ID variable that was saved in the session
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$favorite = $_POST['newFavUrlInt'];
$recipe_id = $_POST['recipe_id'];


$query = "INSERT INTO favorites(favorite_id, user_id, recipe_id, recipe_pos) VALUES('$userid', '$recipe_id'$favorite', , ', 99)";
$result = mysqli_query($dbc, $query);

if ($result === TRUE) {
    echo "New task created successfully";
} else {
    echo "Error: " . $query . "<br>" . $dbc->error;
}