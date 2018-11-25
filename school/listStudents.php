<header class="line">
    <div class="word">Students</div>
    <div class="plus"><a href="index.php?page=school&addS">+</a></div> 
</header>
<div class="crs">
    <?php 
    if(isset($_SESSION['users']) && !empty($_SESSION["users"])) {
        foreach($_SESSION['users'] as $user) {
    ?>
            <div>
                <a href="index.php?page=school&user=<?= $user["id"] ?>  "> 
                    <img src="<?= $user['image'] ?>" width="50" height="50" align="left">
                    Name: <?= $user["name"] ?> </br>
                    Phone: <?= $user["phone"] ?>
                </a>
            </div>
    <?php
        }
    } else { ?>
        <div>
            No Users!
        </div>   
    <?php 
    }
    ?> 
</div>