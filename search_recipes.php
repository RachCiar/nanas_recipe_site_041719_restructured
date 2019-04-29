
<?php
// This is the View recipe page for the site.
require('includes/config.inc.php'); //include the config file
$page_title = 'Search Recipe'; //Set the page title
include('includes/member_header.html.php'); //include the header
$userid = $_SESSION['user_id']; //declare the user ID variable that was saved in the session

    
    
    if (isset($_POST['search'])) {
        $search = $_POST['search']; //declare the search variable that was saved in the session
        echo $search;
    } else {
        $search = NULL;
    }

    if (isset($_POST['category'])) {
        $category = $_POST['category']; //declare the category variable that was saved in the session
        echo $category;
    } else {
        $category = NULL;
    }
    ?>
    <body>


    <?php
// Make the query:
    if (isset($search) && (isset($category))) { //If both fields have something in them
        searchBoth($dbc, $search, $category); //Run searchBoth function
    } else {
        echo '<p class="error">There are currently no records for ' . $search . ' within ' . $category . '.</p>';
    }


    if (isset($search)) { //If only the search field has something in it
        searchOnly($dbc, $search); //Run the searchOnly function
    } else {
        echo '<p class="error">There are currently no records for' . $search . '.</p>';
    }

    if (isset($category)) {//If only the search field has something in it
        categoryOnly($dbc, $category); //Run the categoryOnly function
    } else {
        echo '<p class="error">There are currently no records for' . $category . '.</p>';
    }

    function searchBoth($dbc, $search, $category) {

        $q = "SELECT * FROM recipes AS R INNER JOIN category AS C ";
        $q .= "ON R.category_id = C.category_id ";
        $q .= "WHERE recipe_title LIKE '%$search%' AND R.category_id LIKE '$category'";
        $r = @mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($dbc));
        ; // Run the query.

        if ($r) {
            displayTable($r);
        } else {
            echo $q;
        }
    }

    function searchOnly($dbc, $search) {
        $q = "SELECT * FROM recipes AS R INNER JOIN category AS C ";
        $q .= "ON R.category_id = C.category_id ";
        $q .= "WHERE recipe_title LIKE '%$search%'";
        $r = @mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($dbc));
        ; // Run the query.

        if ($r) {
            displayTable($r);
        } else {
            echo $q;
        }
    }

    function categoryOnly($dbc, $category) {
        $q = "SELECT * FROM recipes AS R INNER JOIN category AS C ";
        $q .= "ON R.category_id = C.category_id ";
        $q .= "WHERE R.category_id LIKE '$category'";
        $r = @mysqli_query($dbc, $q)or trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($dbc));
        ; // Run the query.

        if ($r) {
            displayTable($r);
        } else {
            echo $q;
        }
    }

    function displayTable($r) {

        // Table header.
        echo '<table width="60%">
	<thead>
            <tr>
                <th align="left">Recipe</th><th align="left">Category</th><th align="left">Description</th>
            </tr>
	</thead>
	<tbody>
';
        // Fetch and print all the records:
        while ($row = mysqli_fetch_array($r, MYSQLI_BOTH)) {

            echo '<tr>'
            . '<td><b><a href="view_recipe.php?rid=' . $row['recipe_id'] . '">' . $row['recipe_title'] . '</a></b></td>
                        <td align="left">' . $row['category_name'] . '</td>
                        <td align="left">' . $row['description'] . '</td>'
            . '</tr>';
        }
        echo '</tbody></table>'; // Close the table.

        mysqli_free_result($r); // Free up the resources.
    }

    mysqli_close($dbc); // Close the database connection.

?>

    <?php include('includes/footer.html.php'); ?>
