<?php
    if($_SESSION['loggedInUser']['role'] > 2) {
        if(isset($_POST['addA'])) {
            $err = false;
            $id = $_POST['id'];
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $pass = $_POST['pass'];
            $repass = $_POST['repass'];
            $email = $_POST['email'];
            $role = $_POST['role'];
            $upLoad = fileUpload($_FILES["image"] ,"uploads/AdminImages/" ,$id);
            if(strpos($upLoad, 'Sorry') !== false) {
                $err = 1;
            } else {
                $image = $upLoad;
            }
            $_SESSION['loggedInUser']['addAdmin']['name'] = $name;
            $_SESSION['loggedInUser']['addAdmin']['id'] = $id;
            $_SESSION['loggedInUser']['addAdmin']['email'] = $email;
            $_SESSION['loggedInUser']['addAdmin']['phone'] = $phone;
            $_SESSION['loggedInUser']['addAdmin']['pass'] = $pass;
            $_SESSION['loggedInUser']['addAdmin']['repass'] = $repass;
            $_SESSION['loggedInUser']['addAdmin']['role'] = $role;
            if(strlen($name) < 2 || strlen($name) > 20) {
                $err = 2;
            } elseif (strlen($pass) < 3 || strlen($pass) > 20) {
                $err = 3;
            } elseif(strlen($repass) < 2 || strlen($repass) > 20) {
                $err = 4;
            } elseif($pass !== $repass) {
                $err = 5;
            }
            if(!$err) {
                $try = $connector->createAdmin($id, $name, $pass, $email, $phone, $image, $role);
                if(strpos($try, 'user_email') !== false) {
                    $err = 6;
                } elseif(strpos($try, 'PRIMARY') !== false) {
                    $err = 7;
                }
            }
            if($try === 1) {
                moveToPage(3,"&admin=$id");
            } else {
                moveToPage(3,"&addA=$id&err=$err");
            }
        } else {

            ?>
            <header>Add Admin</header>
            <form id="addF" action="index.php?page=admin&addA" method="post" enctype="multipart/form-data">
                <span><?php 
                    if(isset($_GET['err'])) {
                        if($_GET['err'] == 1) {
                            echo "Image must be only JPG, JPEG, PNG & GIF and below 50MB!";
                        } elseif($_GET['err'] == 2) {
                            echo "Name must be between 2-20 chars";
                        } elseif($_GET['err'] == 3) {
                            echo "Password must be between 3-20 chars";
                        } elseif($_GET['err'] == 4) {
                            echo "Password must be between 3-20 chars";
                        } elseif($_GET['err'] == 5) {
                            echo "Passwords are not much";
                        } elseif($_GET['err'] == 6) {
                            echo "The email you enterd is already in use!";
                        } elseif($_GET['err'] == 7) {
                            echo "The ID you enterd is already in use!";
                        }
                    } ?>
                </span>
                <div>
                    <div>
                        Admin ID <input type="text" name="id" autocomplete='id' value="<?= (isset($_GET['err']) ? $_SESSION['loggedInUser']['addAdmin']['id'] : "")  ?>" required> </br>
                        Admin full name <input type="text" name="name" autocomplete='name' value="<?= (isset($_GET['err']) ? $_SESSION['loggedInUser']['addAdmin']['name'] : "")  ?>" required> </br>
                        Admin phone number <input type="text" name="phone" autocomplete='phone' value="<?= (isset($_GET['err']) ? $_SESSION['loggedInUser']['addAdmin']['phone'] : "")  ?>" required> </br>
                        Admin password <input type="text" name="pass" autocomplete='pass' value="<?= (isset($_GET['err']) ? $_SESSION['loggedInUser']['addAdmin']['pass'] : "")  ?>" required> </br>
                        Admin re password <input type="text" name="repass" autocomplete='repass' value="<?= (isset($_GET['err']) ? $_SESSION['loggedInUser']['addAdmin']['repass'] : "")  ?>" required> </br>
                        Admin Email <input type="email" name="email" autocomplete='email' value="<?= (isset($_GET['err']) ? $_SESSION['loggedInUser']['addAdmin']['email'] : "")  ?>" required> </br>
                        Admin role </br>
                        <input type="radio" name="role" value="1" <?= ((isset($_GET['err']) && ($_SESSION['loggedInUser']['addAdmin']['role'] == 1)) ? "checked" : "")  ?>> Sales<br>
                        <input type="radio" name="role" value="2" <?= ((isset($_GET['err']) && ($_SESSION['loggedInUser']['addAdmin']['role'] == 2)) ? "checked" : "")  ?>> Manager<br>
                    </div>
                    <div>
                        Choose photo below: </br>
                        <img id="tempImg" src="uploads/images/noImageSelected.jpg" width="150px" height="150"> </br>
                        <input type="file" name="image" id="image" autocomplete='image' onchange="changeImg(this);" required> </br>
                    </div>
                </div>
                <input id="addB" type="submit" value="Add Admin" name="addA">
            </form>
        <?php
        }
} else {
    moveToPage(3);
}
?>