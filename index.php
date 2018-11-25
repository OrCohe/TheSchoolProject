<?php
    if(isset($_GET['page'])) {
        $page = $_GET['page'];
        $url = $page."/index.php";
    } else {
        $page = "school";
        $url = $page."/index.php";
    }
    
    require_once($url); 
?>