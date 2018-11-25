<?php 
    class HeaderController {
        private $model;

        function __construct($model) {
            $this->model = $model;
        }

        function logout() {
            session_destroy();
            $_SESSION = array();
            setcookie(session_name(), '',  time() - 100);
            header("location:login.php");
        }

        
    }

?>