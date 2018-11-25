<?php
    if($_SESSION['loggedInUser']['role'] > 1) {
        if(isset($_POST['addC'])) {
            $_SESSION['loggedInUser']['addCourse']['name'] = $_POST['name'];
            $_SESSION['loggedInUser']['addCourse']['des'] = $_POST['des'];
            $upLoad = fileUpload($_FILES["image"] ,"uploads/CourseImages/" ,$_POST['name']);
            if(strpos($upLoad, 'Sorry') === false) {
                if($connector->createCourse($_POST['name'], $_POST['des'], $upLoad)) {
                    $cID = $connector->findCourse($_POST['name']);
                    moveToPage(2,"&course=$cID");
                } else {
                    moveToPage(2,"&addC&err=1");                 
                }
            } else {
                moveToPage(2,"&addC&err=2");
            }
        } else {?>
        <header>Add new Course</header>
        <form id="addF" action="index.php?page=school&addC" method="post" enctype="multipart/form-data">
            <span>
                <?php
                    if(isset($_GET['err'])) {
                        if($_GET['err'] == 1) {
                            echo "Name is already in use!";
                        } elseif($_GET['err'] == 2) {
                            echo "Please user valid Image";
                        }
                    }
                ?>
            </span> </br>
            <div>
                <div>

                    Course name <input type="text" name="name" autocomplete='name' minlength="3" maxlength="15" value="<?= (isset($_GET['err']) ? $_SESSION['loggedInUser']['addCourse']['name'] : "")  ?>" required> </br>
                    Course description </br>
                    <textarea rows="10" cols="70" name="des" autocomplete='des' placeholder="Enter Course description here!"><?= (isset($_GET['err']) ? $_SESSION['loggedInUser']['addCourse']['des'] : "")  ?></textarea> </br>
                </div>
                <div>
                    Choose photo below: </br>
                    <img id="tempImg" src="uploads/images/noImageSelected.jpg" width="150px" height="150"> </br>
                    <input type="file" name="image" id="image" autocomplete='image' onchange="changeImg(this);" required>
                </div>
            </div>
            <input id="addB" type="submit" value="Add Course" name="addC">
        </form>
        <?php
        }
    } else {
        moveToPage(2);
    }
?>