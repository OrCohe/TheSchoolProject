<?php 
    include "functions/checkUrl.php";
    include "functions/fileUpload.php";
    include "functions/checkRole.php";
    include "functions/moveToPage.php";
    include "functions/updateLoginUser.php";
    include "db.php";
    $connector = new AnswersDB();
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
        $connector->showUsers();
        $connector->showAdmins();
        $connector->showCourses();
    }
 
    if(isset($_POST['login'])) {
        $id = $connector->login($_POST['email'], $_POST['password']);
        if($id > 0) {
            updateLoginUser($id);
        } else {
            header("Location: http://localhost/orcohen/theschool/index.php?page=login&err=1");
            exit();
        }
    }
    
    if(!isset($_SESSION['loggedInUser'])) {
        header("Location: http://localhost/orcohen/theschool/index.php?page=login");
    } 

    if(checkPage()) { //check if is admin page
        if($_SESSION['loggedInUser']['role'] < 2) {
            header("Location: http://localhost/orcohen/theschool/index.php?page=school");
        }
    }

    if(isset($_GET['action'])) {
        if($_GET['action'] == "logout") {
            session_destroy();
            $_SESSION = array();
            setcookie(session_name(), '',  time() - 100);
            header("location: http://localhost/orcohen/theschool/index.php?page=login");
        }
    }
    
    if(isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $kind = $_GET['kind'];
        if($kind == 1 && $_SESSION['loggedInUser']['role'] > 0) { //delete student
            $connector->delStudent($id);
            unlink($_SESSION['users'][$id]['image']);
            unset($_SESSION['users'][$id]);
            header("Location: http://localhost/orcohen/theschool/index.php?page=school");
        } elseif ($kind == 2  && $_SESSION['loggedInUser']['role'] > 1) { // delete course
            $connector->delCourse($id);
            unlink($_SESSION['courses'][$id]['image']);
            unset($_SESSION['courses'][$id]);
            header("Location: http://localhost/orcohen/theschool/index.php?page=school");
        } elseif ($kind == 3  && $_SESSION['loggedInUser']['role'] > 2 && $_SESSION['admins'][$id]['role'] != 3) { // delete admin
            $connector->delAdmin($id);
            unlink($_SESSION['admins'][$id]['image']);
            unset($_SESSION['admins'][$id]);
            header("Location: http://localhost/orcohen/theschool/index.php?page=admin");
        } else {
            header("Location: http://localhost/orcohen/theschool/index.php?page=school");
        }

    }

?>