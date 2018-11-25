<?php
    $course = $_SESSION["courses"][$_GET['course']];
    if($course['users'][0] == "No Users") {
        $numS = 0;
    } else {
        $numS = count($course['users']);
    } 
?>
    <header>
        Course <?= $course['name'] ?>
<?php
        if($_SESSION['loggedInUser']['role'] > 1) {
?>
            <a id=linkE href=index.php?page=school&editC=<?= $_GET['course'] ?>>Edit</a>
<?php
        }
?>
    </header>
    <div class=mainCont>
        <div class=mainImage><img src=<?= $course['image'] ?> width=150 height=150 align=left></div>
        <div class=mainRest>
            <h2>Course <?= $course['name'] ?>, <?= $numS ?> Students</h2></br>
            <?= $course['des'] ?> </br></br>
        </div>
    </div>
<?php
    if($course['users'][0] != "No Users") {
        foreach($course['users'] as $user) { 
?>
            <div class=mainUsers> 
                <a href=index.php?page=school&user=<?= $user['id'] ?>> 
                    <img src=<?= $user['image'] ?> width=30 height=30 align=left>
                    Name: <?= $user['name'] ?> </br>
                    Phone: <?= $user['phone'] ?>
                </a>
            </div>
<?php
        } 
    } else { 
?>
        <div class=mainUsers> 
            No Users!
        </div>
<?php
    }
?>