<?php

# Script 18.5 - index.php
// This is the main page for the site.
// Include the configuration file:
require('includes/config.inc.php');

// Set the page title and include the HTML header:
$page_title = 'Welcome to this Site!';
include('includes/member_header.html.php');


$userid = $_SESSION['user_id']; //declare the user ID variable that was saved in the session
if (!isset($userid)){
// re-direct user to index.php if they are not logged in.
        $url = 'index.php'; // Define the URL.
	ob_end_clean(); // Delete the buffer.
	header("Location: $url");
	exit(); // Quit the script.
}

?>

<?php include('includes/footer.html.php'); ?>
