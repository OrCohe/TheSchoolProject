
<?php
    $user = $_SESSION['users'][$_GET['editS']];
    if(isset($_POST['save'])) {
        $errMsg = 0;
        $name = $_POST['name'];
        $id = $_GET['editS'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $_SESSION['loggedInUser']['editStudent']['name'] = $name;
        $_SESSION['loggedInUser']['editStudent']['phone'] = $phone;
        $_SESSION['loggedInUser']['editStudent']['email'] = $email;
        if($_FILES['image']['tmp_name'] != null) {
            $upLoad = fileUpload($_FILES["image"] ,"uploads/StudentImages/" ,$id);
            if(strpos($upLoad, 'Sorry') !== false) {
                $errMsg = 2;
            } else {
                $image = $upLoad;
            }
        } else {
            $image = $user['image'];
        }
        if(strlen($name) < 2 || strlen($name) > 20) {
            $errMsg = 1; 
        }
        if($errMsg > 0) { 
            moveToPage(2,"&editS=$id&err=$errMsg");
            } else {
            if(!$connector->updateStudent($id, $name, $email, $phone, $image)) {
                moveToPage(2,"&editS=$id&err=3");
                exit;
            }
            $connector->clearUserCourses($id);
            $courses = $_POST['course'];
            if (isset($_POST['course'])) {
                foreach ($courses as $course){
                    $connector->addToCourse($id, $course)  ;
                }
            }
            moveToPage(2,"&user=$id");
        }
    } else { 
        ?>
        <header>Edit Student</header>
        <div style="margin: 20px">
            <input id="saveB" type="submit" value="Save" name="save" form="addF"> 
            <button id="delB" onclick="delAlert(<?= $user['id'] ?>,1);">Delete</button>
        </div>
        <form id="addF" action="index.php?page=school&editS=<?= $user['id'] ?>" method="post" enctype="multipart/form-data">
            <span><?php 
            if(isset($_GET['err'])) {
                if($_GET['err'] == 1) {
                    echo "The name must be between 2 - 20 chars!";
                } elseif($_GET['err'] == 2) {
                    echo "Image must be only JPG, JPEG, PNG & GIF!";
                } elseif($_GET['err'] == 3) {
                    echo "The email you enterd is already in use!";
                }
            } ?>
            </span>
            <div>
                <div>
                    Student full name <input type="text" name="name" autocomplete='name' minlength="2" maxlength="20" value=<?= (isset($_GET['err']) ? $_SESSION['loggedInUser']['editStudent']['name'] : $user['name'])  ?> required>  </br>
                    Student ID <input type="text" name="id" autocomplete='id' value=<?= $user['id']  ?> disabled > </br>
                    Student phone number <input type="text" name="phone" autocomplete='phone' value=<?= (isset($_GET['err']) ? $_SESSION['loggedInUser']['editStudent']['phone'] : $user['phone']) ?> required> </br>
                    Student Email <input type="email" name="email" autocomplete='email' value=<?= (isset($_GET['err']) ? $_SESSION['loggedInUser']['editStudent']['email'] : $user['email']) ?> required> </br>
                    </br> 
                </div>
                <div>
                    Choose photo below: </br>
                    <img id="tempImg" src=<?= $user['image'] ?> width="150px" height="150"> </br>
                    <input type="file" name="image" id="image" autocomplete='image' onchange="changeImg(this);"> </br></br>
                </div>
            </div>
            <p>
                <b>Select student Course/s:</b> </br>
                <?php 
                if(isset($_SESSION["courses"]) && !empty($_SESSION["courses"])) { 
                    foreach($_SESSION['courses'] as $course) { 
                    ?>
                        <input type="checkbox" name="course[]" id="course" value="<?= $course['id']?>" <?= (isset($user['courses'][$course['id']]) ? "checked" : "") ?>><?= $course['name'] ?></br>
                    <?php 
                    }
                } else { ?>
                    <p>No Courses!</p>
                <?php }
                ?>
            </p>    
        </form>
    <?php 
    }
?>

   
