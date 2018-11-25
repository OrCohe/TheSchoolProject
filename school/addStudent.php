<?php
    if(isset($_POST['addS'])) {
        $_SESSION['loggedInUser']['addStudent']['name'] = $_POST['name'];
        $_SESSION['loggedInUser']['addStudent']['id'] = $_POST['id'];
        $_SESSION['loggedInUser']['addStudent']['phone'] = $_POST['phone'];
        $_SESSION['loggedInUser']['addStudent']['email'] = $_POST['email'];
        $upLoad = fileUpload($_FILES["image"] ,"uploads/StudentImages/" ,$_POST['id']);
        if(strpos($upLoad, 'Sorry') === false) {
            $try = $connector->createStudent($_POST['id'], $_POST['name'], $_POST['email'], $_POST['phone'], $upLoad);
            if(strpos($try, 'user_email') !== false) {
                $err = 1;
            } elseif(strpos($try, 'PRIMARY') !== false) {
                $err = 2;
            }
            if($try === 1) {
                $courses = $_POST['course'];
                if (isset($_POST['course'])) {
                    foreach ($courses as $course){
                        $connector->addToCourse($_POST['id'], $course);
                    }
                }
                moveToPage(2,"&user=$_POST[id]");
            } else {
                moveToPage(2,"&addS&err=$err");
            }
        } else {
            moveToPage(2,"&addS&err=3");
        }
    } else {?>  
    <header>Add new Student</header>
    <form id="addF" action="index.php?page=school&addS" method="post" enctype="multipart/form-data">
        <span>
            <?php
                if(isset($_GET['err'])) {
                    if($_GET['err'] == 1) {
                        echo "Email is already in use";
                    } elseif($_GET['err'] == 2) {
                        echo "ID is already in use";
                    } elseif($_GET['err'] == 3) {
                        echo "Please user valid Image";
                    }
                }
            ?>
        </span> </br>
        <div>
            <div>
                Student full name <input type="text" name="name" autocomplete='name' minlength="2" maxlength="20" value="<?= (isset($_GET['err']) ? $_SESSION['loggedInUser']['addStudent']['name'] : "")  ?>" required> </br>
                Student ID <input type="text" name="id" autocomplete='id' value="<?= (isset($_GET['err']) ? $_SESSION['loggedInUser']['addStudent']['id'] : "")  ?>" required> </br>
                Student phone number <input type="text" name="phone" autocomplete='phone' value="<?= (isset($_GET['err']) ? $_SESSION['loggedInUser']['addStudent']['phone'] : "")  ?>" required> </br>
                Student Email <input type="email" name="email" autocomplete='email' value="<?= (isset($_GET['err']) ? $_SESSION['loggedInUser']['addStudent']['email'] : "")  ?>" required> </br>
                </br> 
            </div>
            <div>
                Choose photo below: </br>
                <img id="tempImg" src="uploads/images/noImageSelected.jpg" width="150px" height="150"> </br>
                <input type="file" name="image" id="image" autocomplete='image' onchange="changeImg(this);" required> </br></br>
            </div>
        </div>
        <p>
            <b>Select student Course/s:</b> </br>
            <?php 
                $i = 1;
                if(isset($_SESSION["courses"]) && !empty($_SESSION["courses"])) { 
                    foreach($_SESSION['courses'] as $course) { 
                    ?>
                        <input type="checkbox" name="course[]" id="course" value=<?= $course['id'] ?>><?= $course['name'] ?></br>
                    <?php 
                    }
                } else { ?>
                    <p>No courses!</p>
                <?php }
            ?>
        </p>    
        <input id="addB" type="submit" value="Save" name="addS">
    </form>
    <?php
    }
?>