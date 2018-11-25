<?php
    if(isset($_SESSION["users"]) && !empty($_SESSION["users"])) {
        $numS = count($_SESSION["users"]);
    } else {
        $numS = "None!";
    }
    if(isset($_SESSION["courses"]) && !empty($_SESSION["courses"])) { 
        $numC = count($_SESSION["courses"]);
    } else {
        $numC = "None!";
    }
    echo "Students: $numS </br>
          Courses: $numC";
?>