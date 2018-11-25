<header class="line">
    <div class="word">Admins</div>
    <div class="plus">
    <?php if($_SESSION['loggedInUser']['role'] > 2) { ?>    
        <a href="index.php?page=admin&addA">+</a>
    <?php }?>
    </div>   
</header>
<div class="crs">
    <?php 
    if(isset($_SESSION['admins']) && !empty($_SESSION["admins"])) {
        foreach($_SESSION['admins'] as $admin) {
            if($admin['role'] != 3 ) {
    ?>
        <div>
            <a href="index.php?page=admin&admin=<?= $admin["id"] ?>"> 
                <img src="<?= $admin['image'] ?>" width="50" height="50" align="left">
                Name: <?= $admin["name"] ?> </br>
                Role: <?php if($admin['role'] == 1) echo "Sales";
                            if($admin['role'] == 2) echo "Manager";
                            if($admin['role'] == 3) echo "Owner";?>
            </a>
        </div>
    <?php
            } elseif($admin['role'] == 3 && $_SESSION['loggedInUser']['role'] == 3) {
            ?>
                <div>
                    <a href="index.php?page=admin&admin=<?= $admin["id"] ?>"> 
                        <img src="<?= $admin['image'] ?>" width="50" height="50" align="left">
                        Name: <?= $admin["name"] ?> </br>
                        Role: Owner
                    </a>
                </div>
            <?php
            }
        }
    } else { ?>
        <div>
            No Admins!
        </div>   
    <?php 
    }
    ?> 
</div>