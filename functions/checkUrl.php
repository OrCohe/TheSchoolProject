<?php
    function checkPage() {
        $url = $_SERVER['REQUEST_URI'];
        if (strpos($url, 'admin') !== false) {
            return 1;
        }
        return 0;
    }
?>