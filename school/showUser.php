<?php
    $user = $_SESSION["users"][$_GET['user']];
?>
    <header>
        Student
        <a id=linkE href=index.php?page=school&editS=<?= $_GET['user'] ?> >Edit</a>
    </header>
    <div class=mainCont>
        <div class=mainImage><img src= <?= $user['image'] ?>  width=150 height=150 align=left></div>
        <div class=mainRest>
            <h2> <?= $user['name'] ?>  </h2></br>
                 <?= $user['phone'] ?>  </br>
                 <?= $user['email'] ?>  </br></br>
        </div>
    </div>
<?php
    if(!isset($user['courses'][0])) {
?>
        <h3> <?= $user['name'] ?>  Courses: </h3>
<?php
        foreach($user['courses'] as $crs) {
?>
            <div class=mainUsers> 
                <a href=index.php?page=school&course=<?= $crs['id'] ?> > 
                    <img src= <?= $crs['image'] ?>  width=30 height=30 align=left>
                    Course  <?= $crs['name'] ?> 
                </a>
            </div>
<?php
        }
    } else {
?>
        <div class=mainUsers> 
            No Courses!
        </div>
<?php
    }
?>