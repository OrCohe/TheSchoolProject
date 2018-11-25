<?php 
    include "main.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="styles/styles.css">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="functions/changeImg.js"></script>
    <script src="functions/delAlert.js"></script>
</head>
<body>
<div class="container">
        <?php include "top.php"; ?>
        <div class="main">
            <div class="left">
                    <?php include "listAdmins.php"; ?>
            </div> 
            <div class="right">
                    <?php 
                        if(isset($_GET['admin'])) {
                            include "showAdmin.php";
                        } else if(isset($_GET['addA'])) {
                            include "addAdmin.php";
                        } else if(isset($_GET['editA'])) {
                            include "editAdmin.php";
                        } else {
                            include "countAdmin.php";
                        }
                    ?>
            </div>
        </div>
</div>
</body>
</html>