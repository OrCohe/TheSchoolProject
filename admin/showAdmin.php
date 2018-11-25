<?php 
    $admin = $_SESSION["admins"][$_GET['admin']];
?>
    <header>
        <?= checkRole($admin['role']) ?> - <?= $admin['name'] ?>
<?php
        if($_SESSION['loggedInUser']['role'] > 2) {
?>
            <a id=linkE href=index.php?page=admin&editA=<?= $_GET['admin'] ?>>Edit</a>
<?php
        }
?>
    </header>
    <div class=mainCont>
        <div class=mainImage><img src=<?= $admin['image'] ?> width=150 height=150 align=left></div>
        <div class=mainRest>
            <h2> <?= $admin['name'] ?> </h2></br>
                 <?= $admin['phone'] ?> </br>
                 <?= $admin['email'] ?> </br></br>
        </div>
    </div>