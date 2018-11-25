<?php
    $admin = $_SESSION['admins'][$_GET['editA']];

    if($_SESSION['loggedInUser']['role'] > 2) {
        if(isset($_POST['save'])) {
            $err = false;
            $id = $_GET['editA'];
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $pass = $_POST['pass'];
            $repass = $_POST['repass'];
            $email = $_POST['email'];
            $role = $_POST['role'];
            if($_FILES['image']['tmp_name'] != null) {
                $upLoad = fileUpload($_FILES["image"] ,"uploads/AdminImages/" ,$id);
                if(strpos($upLoad, 'Sorry') !== false) {
                    $err = 1;
                } else {
                    $image = $upLoad;
                }
            } else {
                $image = $admin['image'];
            }
            $_SESSION['loggedInUser']['editAdmin']['name'] = $name;
            $_SESSION['loggedInUser']['editAdmin']['id'] = $id;
            $_SESSION['loggedInUser']['editAdmin']['email'] = $email;
            $_SESSION['loggedInUser']['editAdmin']['phone'] = $phone;
            $_SESSION['loggedInUser']['editAdmin']['pass'] = $pass;
            $_SESSION['loggedInUser']['editAdmin']['repass'] = $repass;
            $_SESSION['loggedInUser']['editAdmin']['role'] = $role;
            if(strlen($name) < 2 || strlen($name) > 20) {
                $err = 2;
            } elseif (strlen($pass) < 3 || strlen($pass) > 20) {
                $err = 3;
            } elseif(strlen($repass) < 2 || strlen($repass) > 20) {
                $err = 4;
            } elseif($pass !== $repass) {
                $err = 5;
            } elseif($admin['role'] == 3 && $role != 3) {
                $err = 7;
                $_SESSION['loggedInUser']['editAdmin']['role'] = 3;
            }
            if(!$err) {
                if($connector->updateAdmin($id, $name, $pass, $email, $phone, $image, $role)) {
                    $connector->showAdmins();
                    updateLoginUser($_SESSION['loggedInUser']['id']);
                    moveToPage(3,"&admin=$id");
                } else {
                    moveToPage(3,"&editA=$id&err=6");
                }
            } else {
                moveToPage(3,"&editA=$id&err=$err");
            }
            
            
        } else {
            ?>
            <header>Edit Admin</header>
            <div style="margin: 20px">
                <input id="saveB" type="submit" value="Save" name="save" form="addF"> 
                <?php
                if($_SESSION['loggedInUser']['id'] != $_GET['editA']) { ?>
                    <button id="delB" onclick="delAlert(<?= $admin['id'] ?>,3);">Delete</button>
                    <?php
                }
                ?>
                
            </div>
            <form id="addF" action="index.php?page=admin&editA=<?= $_GET['editA'] ?>" method="post" enctype="multipart/form-data">
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
                            echo "Owner role cannot be changed!";
                        }
                    } ?>
                </span>
                <div>
                    <div>
                        Admin full name <input type="text" name="name" autocomplete='name' minlength="2" maxlength="20" value="<?= $admin['name'] ?>" required> </br>
                        Admin ID <input type="text" name="id" autocomplete='id' value="<?= (isset($_GET['err']) ? $_SESSION['loggedInUser']['editAdmin']['id'] : $admin['id'])  ?>" disabled> </br>
                        Admin phone number <input type="text" name="phone" autocomplete='phone' value="<?= (isset($_GET['err']) ? $_SESSION['loggedInUser']['editAdmin']['phone'] : $admin['phone'])  ?>" required> </br>
                        Admin password <input type="text" name="pass" autocomplete='pass' minlength="3" maxlength="20" value="<?= (isset($_GET['err']) ? $_SESSION['loggedInUser']['editAdmin']['pass'] : "*****" ) ?>" required> </br>
                        Admin re password <input type="text" name="repass" autocomplete='repass' minlength="3" maxlength="20" value="<?= (isset($_GET['err']) ? $_SESSION['loggedInUser']['editAdmin']['repass'] : "*****" ) ?>" required> </br>
                        Admin Email <input type="email" name="email" autocomplete='email' value="<?= (isset($_GET['err']) ? $_SESSION['loggedInUser']['editAdmin']['email'] : $admin['email'])  ?>" required> </br>
                        Admin role </br>
                        <input type="radio" name="role" value="1" <?= ($admin['role'] == 1 ? "checked" : "") ?>> Sales<br>
                        <input type="radio" name="role" value="2" <?= ($admin['role'] == 2 ? "checked" : "") ?>> Manager<br>
                        <?php 
                        if($admin['role'] == 3) {
                        ?>
                        <input type="radio" name="role" value="3" <?= ($admin['role'] == 3 ? "checked" : "") ?>> Owner<br>
                        <?php
                        }
                        ?>
                    </div>
                    <div>
                        Choose photo below: </br>
                        <img id="tempImg" src="<?= $admin['image'] ?>" width="150px" height="150"> </br>
                        <input type="file" name="image" id="image" autocomplete='image' onchange="changeImg(this);"> </br>
                    </div>
                </div>
            </form>
        <?php
        }
} else {
    moveToPage(3);
}
?>