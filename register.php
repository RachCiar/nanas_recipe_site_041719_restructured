<!DOCTYPE html>
<?php # Script 18.6 - register.php
// This is the registration page for the site.
require('includes/config.inc.php');
$page_title = 'Register';
include('includes/header.html.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Handle the form.
    // Need the database connection:
    require(MYSQL);

    // Trim all the incoming data:
    $trimmed = array_map('trim', $_POST);

    // Assume invalid values:
    $fn = $ln = $e = $p = FALSE;

    // Check for a first name:
    if (preg_match('/^[A-Z \'.-]{2,20}$/i', $trimmed['first_name'])) {
        $fn = mysqli_real_escape_string($dbc, $trimmed['first_name']);
    } else {
        echo '<p class="error">Please enter your first name!</p>';
    }
    // Check for a last name:
    if (preg_match('/^[A-Z \'.-]{2,40}$/i', $trimmed['last_name'])) {
        $ln = mysqli_real_escape_string($dbc, $trimmed['last_name']);
    } else {
        echo '<p class="error">Please enter your last name!</p>';
    }
    // Check for an email address:
    if (filter_var($trimmed['email'], FILTER_VALIDATE_EMAIL)) {
        $e = mysqli_real_escape_string($dbc, $trimmed['email']);
    } else {
        echo '<p class="error">Please enter a valid email address!</p>';
    }
    // Check for a password and match against the confirmed password:
    if (strlen($trimmed['password1']) >= 10) {
        if ($trimmed['password1'] == $trimmed['password2']) {
            $p = password_hash($trimmed['password1'], PASSWORD_DEFAULT);
        } else {
            echo '<p class="error">Your password did not match the confirmed password!</p>';
        }
    } else {
        echo '<p class="error">Please enter a valid password!</p>';
    }
    if ($fn && $ln && $e && $p) { // If everything's OK...
        // Make sure the email address is available:
        $q = "SELECT user_id FROM users WHERE email='$e'";

        $r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($dbc));

        if (mysqli_num_rows($r) == 0) { // Available.
            // Create the activation code:
            $a = md5(uniqid(rand(), true));

            // Add the user to the database:
            $q = "INSERT INTO users (first_name, last_name, email, password1, active) VALUES ('$fn','$ln','$e','$p','$a')";
            $r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($dbc));
            if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
              // Send the email:
              $body = "Thank you for registering at <whatever site>. To activate your account, please click on this link:\n\n";
              $body .= BASE_URL . 'activate.php?x=' . urlencode($e) . "&y=$a";
              mail($trimmed['email'], 'Registration Confirmation', $body, 'From: rach.ciarlante@gmail.com');
              // Finish the page:
              echo '<h3>Thank you for registering! A confirmation email has been sent to your address. Please click on the link in that email in order to activate your account.</h3>';
              include('includes/footer.html.php'); // Include the HTML footer.
              exit(); // Stop the page.
              } else { // If it did not run OK.
              echo '<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';
              }
              } else { // The email address is not available.
              echo '<p class="error">That email address has already been registered. If you have forgotten your password, use the link at right to have your password sent to you.</p>';
              }
              } else { // If one of the data tests failed.
              echo '<p class="error">Please try again.</p>';
              } 
            mysqli_close($dbc);
        } // End of the main Submit conditional.
        ?>

<body>
<div id="Header">Register</div>
<div id="Content">
        <h1>Register</h1>
        <form action="register.php" method="post">
            <fieldset>

                <p><strong>First Name:</strong> <input type="text" name="first_name" size="20" maxlength="20" value="<?php if (isset($trimmed['first_name'])) {
            echo $trimmed['first_name'];
        } ?>"></p>

                <p><strong>Last Name:</strong> <input type="text" name="last_name" size="20" maxlength="40" value="<?php if (isset($trimmed['last_name'])) {
            echo $trimmed['last_name'];
        } ?>"></p>

                <p><strong>Email Address:</strong> <input type="email" name="email" size="30" maxlength="60" value="<?php if (isset($trimmed['email'])) {
            echo $trimmed['email'];
        } ?>"> </p>

                <p><strong>Password:</strong> <input type="password" name="password1" size="20" value="<?php if (isset($trimmed['password1'])) {
            echo $trimmed['password1'];
        } ?>"> <small>At least 10 characters long.</small></p>

                <p><strong>Confirm Password:</strong> <input type="password" name="password2" size="20" value="<?php if (isset($trimmed['password2'])) {
            echo $trimmed['password2'];
        } ?>"></p>
            </fieldset>

            <div><input type="submit" name="submit" value="Register"></div>

        </form>
        <?php include('includes/footer.html.php'); ?>
        


