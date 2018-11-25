<header class="line">
    <div class="word">Courses</div>
    <div class="plus">
    <?php if($_SESSION['loggedInUser']['role'] > 1) { ?>    
        <a href="index.php?page=school&addC">+</a>
    <?php }?>
    </div>   
</header>

<div class="crs">
    <?php 
    if(isset($_SESSION['courses']) && !empty($_SESSION["courses"])) {
        foreach($_SESSION['courses'] as $course) {
    ?>
            <div>
                <a href="index.php?page=school&course=<?= $course["id"] ?>"> 
                    <img src="<?= $course['image'] ?>" width="50" height="50" align="left">
                    Name: <?= $course["name"] ?>
                </a>
            </div>
    <?php
        }
    } else { ?>
        <div>
            No Courses!
        </div>   
    <?php 
    }
    ?> 
</div>