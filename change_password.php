<!DOCTYPE html>
<?php # Script 18.11 - change_password.php
// This page allows a logged-in user to change their password.

require('includes/config.inc.php');
include('includes/header.html.php');

$page_title = 'Change Your Password';

// If no user_id session variable exists, redirect the user:
if (!isset($_SESSION['user_id'])) {
	$url = 'index.php'; // Define the URL.
	ob_end_clean(); // Delete the buffer.
	header("Location: $url");
	exit(); // Quit the script.
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	require(MYSQL);
	// Check for a new password and match against the confirmed password:
	$p = FALSE;
	if (strlen($_POST['password1']) >= 10) {
		if ($_POST['password1'] == $_POST['password2']) {
			$p = password_hash($_POST['password1'], PASSWORD_DEFAULT);
		} else {
			echo '<p class="error">Your password did not match the confirmed password!</p>';
		}
	} else {
		echo '<p class="error">Please enter a valid password!</p>';
	}
	if ($p) { // If everything's OK.
		// Make the query:
		$q = "UPDATE users SET password1='$p' WHERE user_id={$_SESSION['user_id']} LIMIT 1";
		$r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($dbc));
		if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
			// Send an email, if desired.
			echo '<h3>Your password has been changed.</h3>';
			mysqli_close($dbc); // Close the database connection.
			include('includes/footer.html.php'); // Include the HTML footer.
			exit();
		} else { // If it did not run OK.
			echo '<p class="error">Your password was not changed. Make sure your new password is different than the current password. Contact the system administrator if you think an error occurred.</p>';
		}
	} else { // Failed the validation test.
		echo '<p class="error">Please try again.</p>';
	}
	mysqli_close($dbc); // Close the database connection.
} // End of the main Submit conditional.
?>

<h1>Change Your Password</h1>
<form action="change_password.php" method="post">
	<fieldset>
	<p><strong>New Password:</strong> <input type="password" name="password1" size="20"> <small>At least 10 characters long.</small></p>
	<p><strong>Confirm New Password:</strong> <input type="password" name="password2" size="20"></p>
	</fieldset>
	<div align="center"><input type="submit" name="submit" value="Change My Password"></div>
</form>

<?php include('includes/footer.html.php'); ?>
