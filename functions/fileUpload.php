<?php
    function fileUpload($file, $tar ,$who){
        $target_dir = $tar;
        $target_file = $target_dir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $name = $target_dir . $who . "IMG." . $imageFileType;
        // Check if file already exists
        // if (file_exists($name)) {
        //     return "Sorry, file already exists.";
        // }
        // Check file size
        if ($file["size"] > 5000000) {
            return "Sorry, your file is too large.";
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            return "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }
        // if everything is ok, try to upload file
        else {
            
            if (move_uploaded_file($file["tmp_name"], $name)) {
                return $name;
            } else {
                return "Sorry, there was an error uploading your file.";
            }
        }
    }
?>