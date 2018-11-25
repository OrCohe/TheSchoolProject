<?php 
    Class HeaderView {
        private $model;
        private $controller;

        function __construct ($model) {            
            $this->model = $model;
            // $this->controller = $controller;
        }

        public function renderView() {
            $data = $this->model->getLoggedInuser();
            
            include 'header.php';
        }
    }
    
?>