<?php 
    function moveToPage($page, $link = "") {
        if($page == 1) {
            ?>
            <script type="text/javascript">
                window.location.href = 'http://localhost/orcohen/theschool/index.php?page=login';
            </script>
            <?php 
        } elseif($page == 2) {
            ?>
            <script type="text/javascript">
                window.location.href = 'http://localhost/orcohen/theschool/index.php?page=school<?=$link?>';
            </script>
            <?php 
        } elseif($page == 3) {
            ?>
            <script type="text/javascript">
                window.location.href = 'http://localhost/orcohen/theschool/index.php?page=admin<?=$link?>';
            </script>
            <?php 
        }
    }
?>