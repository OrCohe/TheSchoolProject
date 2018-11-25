<?php 
    class HeaderModel {

        private $loggedInUser;

        


        public function getLoggedInuser(){
            return $this->loggedInUser;
        }

        function __construct(){
            
            if (isset($_SESSION['loggedInUser'])) {
                $this->loggedInUser = $_SESSION['loggedInUser'];
            } else {
                header("Location: http://localhost/orcohen/theschool/login.php");
            }            
        }

        
    }

?>