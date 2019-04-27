<!-- Start of Footer -->
</div><!-- Content -->



<?php
$css = "";
$js = "";

switch($page_type)
{
    case 'index':
        $css = "index.css";
        $js = "index.js";
        break;
    case 'member_index':
        $css = "member_index.css";
        $js = "member_index.js";
        break;
    case 'login':
        $css = "login.css";
        $js = "login.js";
        break;
    case 'register':
        $css = "register.css";
        $js = "register.js";
        break;
    
    case 'viewAddComment':
        $css = "viewAddComment.css";
        $js = "viewAddcomment.js";
        break;
    
}

echo '<head><link rel="stylesheet" type="text/css"  href="css/' . $css .'"></head>'; 
echo'<script src="js/'. $js .'"></script>';


?>
</body>
</html>
<?php
// Flush the buffered output.
ob_end_flush();
?>
