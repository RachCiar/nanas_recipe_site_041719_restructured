<!DOCTYPE html>
<?php # Script 18.8 - login.php
#

// This is the login page for the site.
require('includes/config.inc.php');
$page_title = 'Login';
include('includes/login_header.html.php');
$page_type = 'login';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	require(MYSQL);
        
	// Validate the email address:
	if (!empty($_POST['email'])) {
		$e = mysqli_real_escape_string($dbc, $_POST['email']);
	} else {
		$e = FALSE;
		echo '<p class="error">You forgot to enter your email address!</p>';
	}
        
	// Validate the password:
	if (!empty($_POST['password1'])) {
		$p = trim($_POST['password1']);
	} else {
		$p = FALSE;
		echo '<p class="error">You forgot to enter your password!</p>';
	}
        
	if ($e && $p) { // If everything's OK.
		// Query the database:
		$q = "SELECT user_id, first_name, user_level, password1 FROM users WHERE email='$e'";
		$r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($dbc));
		if (@mysqli_num_rows($r) == 1) { // A match was made.
                
			// Fetch the values:
			list($user_id, $first_name, $user_level, $pass) = mysqli_fetch_array($r, MYSQLI_NUM);
			mysqli_free_result($r);
                        
			// Check the password:
			if (password_verify($p, $pass)) {
                            
				// Store the info in the session:
				$_SESSION['user_id'] = $user_id;
				$_SESSION['first_name'] = $first_name;
				$_SESSION['user_level'] = $user_level;
				mysqli_close($dbc);
                              
				// Redirect the user:
				$url = 'member_index.php'; // Define the URL.
				ob_end_clean(); // Delete the buffer.
				header("Location: member_index.php");
				exit(); // Quit the script.
			} else {
				echo '<p class="error">Either the email address and password entered do not match those on file or you have not yet activated your account.</p>';
			}
		} else { // No match was made.
			echo '<p class="error">Either the email address and password entered do not match those on file or you have not yet activated your account.</p>';
		}
	} else { // If everything wasn't OK.
		echo '<p class="error">Please try again.</p>';
	}
	mysqli_close($dbc);
        
} // End of SUBMIT conditional.
?>
<div id="login-form">
<h1>Login</h1>
<p>Your browser must allow cookies in order to log in.</p>
<form action="login.php" method="post">
	<p><strong>Email Address:</strong> <input type="email" name="email" size="20" maxlength="60"></p>
	<p><strong>Password:</strong> <input type="password" name="password1" size="20"></p>
        <div><input type="submit" name="submit" value="Login" id="rSubmit"></div><br>
        <br>
	</form>
</div>
</div> <!-- This is the ending div for the hero-image on the header-->
<?php include('includes/footer.html.php'); ?>
