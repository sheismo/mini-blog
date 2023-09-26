<?php
    function uploadImage(array $upload) {

        $imageName = $upload["name"];
        $imageTempPath = $upload["tmp_name"];

        $imageExtension = pathinfo($imageName)["extension"];
        $allowedExtensions = ['png', 'jpg', 'jpeg', 'bmp'];

        if($upload["error"] > 0) {
            $_SESSION["error_message"] = "Something went wrong, could not upload image.";
            return false;

        } else if ($upload["size"] > 5242880) {
            $_SESSION["error_message"]  = "File size should not be larger than 5MB!";
            return false;

        } else if (!in_array($imageExtension, $allowedExtensions)) {
            $_SESSION["error_message"]  = "The extension ($imageExtension) is not allowed. Only "
            .implode(',', $allowedExtensions)." are allowed";
            return false;

        } else {
            if(!is_dir(UPLOAD_DIR)) {
               mkdir(UPLOAD_DIR);
            }
            
            $fileName = date("YmdHis").".png";
            $imageFinalPath = UPLOAD_DIR.$fileName;
            $_SESSION['post_image_name'] = $fileName;
            $uploadSuccess = move_uploaded_file($imageTempPath, $imageFinalPath);  

            return $uploadSuccess;
        }
    }

    function deletePostImage($imageName) {
        return unlink(UPLOAD_DIR.$imageName);
    }
?>