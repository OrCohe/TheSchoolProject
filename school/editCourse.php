<?php
    if($_SESSION['loggedInUser']['role'] > 1) {
        $course = $_SESSION['courses'][$_GET['editC']];
        if(isset($_POST['save'])) {
            $errMsg = 0;
            $name = $_POST['name'];
            $id = $_GET['editC'];
            $des = $_POST['des'];
            if($_FILES['image']['tmp_name'] != null) {
                $upLoad = fileUpload($_FILES["image"] ,"uploads/CourseImages/" ,$id);
                if(strpos($upLoad, 'Sorry') !== false) {
                    $errMsg = 2;
                } else {
                    $image = $upLoad;
                }
            } else {
                $image = $user['image'];
            }
            if(strlen($name) < 3 || strlen($name) > 15) {
                $errMsg = 1; 
            }
            if($errMsg > 0) { 
                $_SESSION['loggedInUser']['editCourse']['name'] = $name;
                $_SESSION['loggedInUser']['editCourse']['des'] = $des;
                $_SESSION['loggedInUser']['editCourse']['image'] = $image;
                moveToPage(2,"&editC=$id&err=$errMsg");
            } else {
                if(!$connector->updateCourse($id, $name, $des, $image)) {
                    $_SESSION['loggedInUser']['editCourse']['name'] = $name;
                    $_SESSION['loggedInUser']['editCourse']['des'] = $des;
                    $_SESSION['loggedInUser']['editCourse']['image'] = $image;
                    moveToPage(2,"&editC=$id&err=3");
                    exit;
                }
                moveToPage(2,"&course=$id");
            }
        } else {?>
        <header>Edit Course</header>
        <div style="margin: 20px">
            <input id="saveB" type="submit" value="Save" name="save" form="addF"> 
            <button id="delB" onclick="delAlert(<?= $course['id'] ?>,2);">Delete</button>
        </div>
        <form id="addF" action="index.php?page=school&editC=<?= $course['id'] ?>" method="post" enctype="multipart/form-data">
            <span><?php 
                if(isset($_GET['err'])) {
                    if($_GET['err'] == 1) {
                        echo "The name must be between 3 - 15 chars!";
                    } elseif($_GET['err'] == 2) {
                        echo "Image must be only JPG, JPEG, PNG & GIF!";
                    } elseif($_GET['err'] == 3) {
                        echo "Name is already in use!";
                    }
                } ?>
            </span>
            <div>
                <div>
                    Course name <input type="text" name="name" autocomplete='name' minlength="3" maxlength="15" value=<?= (isset($_GET['err']) ? $_SESSION['loggedInUser']['editCourse']['name'] : $course['name'])  ?> required> </br>
                    Course description </br>
                    <textarea rows="10" cols="70" name="des" autocomplete='des' placeholder="Enter Course description here!"><?= (isset($_GET['err']) ? $_SESSION['loggedInUser']['editCourse']['des'] : $course['des']) ?></textarea> </br>
                </div>
                <div>
                    Choose photo below: </br>
                    <img id="tempImg" src="<?= (isset($_GET['err']) ? $_SESSION['loggedInUser']['editCourse']['image'] : $course['image']) ?>" height="150"> </br>
                    <input type="file" name="image" id="image" autocomplete='image' onchange="changeImg(this);">
                </div>
            </div>
        </form>
        <?php
        }
    } else  {
        moveToPage(2);
    }
?>