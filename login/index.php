<?php
    if(isset($_GET['err'])) {
        $errMsg = "";
        if($_GET['err'] == 1) {
            $errMsg = "Email or password is invalid!";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <div class="top">
        <header id="logTop">
            Welcome to Or's School, Please login below! </br>
        </header>
    </div>
    <div class="container">
        <form id="logForm" action="index.php?page=school" method="post">
            <span><?php if(isset($errMsg)) echo $errMsg; ?></span> </br>
            <input type="text" name="email" placeholder="Enter your email"> </br>
            <input type="text" name="password" placeholder="Enter your password"> </br>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
</body>
</html>


