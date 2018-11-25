<?php
    function updateLoginUser($id) {
        $loggedInUser = array();
        $loggedInUser['id'] = $id;
        $loggedInUser['name'] = $_SESSION['admins'][$id]['name'];
        $loggedInUser['email'] = $_SESSION['admins'][$id]['email'];
        $loggedInUser['phone'] = $_SESSION['admins'][$id]['phone'];
        $loggedInUser['image'] = $_SESSION['admins'][$id]['image'];
        $loggedInUser['role'] = $_SESSION['admins'][$id]['role'];
        $_SESSION['loggedInUser'] = $loggedInUser;
    }
?>