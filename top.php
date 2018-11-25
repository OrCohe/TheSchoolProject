<div class="top">
    <header>
        <div style="float:left;"> <img src="uploads/images/logo2.svg" width="100px" height="100%"> </div>
        <div>
            <?php
                if($_SESSION['loggedInUser']['role'] > 1) { ?>
                    <a href="index.php?page=school"><h3>  |  School</a> | <a href=index.php?page=admin>Administation</h3></a>
                    <?php
                } else { ?>
                    <a href="index.php?page=school"><h3> | School </h3></a>
                    <?php
                }
            ?>
        </div>
        <div class="prop">
            
            <div id="topProp"> <img src=<?= $_SESSION['loggedInUser']['image'] ?> width="50" height="50"> </div>
            <?= $_SESSION['loggedInUser']['name'] ?> - <?= checkRole($_SESSION['loggedInUser']['role']) ?> <br/>
            <a id="linkT" href="index.php?page=<?= $page ?>&action=logout">Logout</a>
        </div>
    </header>
</div>