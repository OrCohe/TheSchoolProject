<?php
    if(isset($_SESSION["admins"]) && !empty($_SESSION["admins"])) {
        $num = count($_SESSION["admins"]);
    } else {
        $num = "None!";
    }
    echo "Admins: $num";
?>