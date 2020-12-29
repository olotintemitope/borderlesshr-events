<?php

namespace Laztopaz\Controller\Traits;

trait ImageUpload
{
    /**
     * @param $files
     * @return array
     */
    public function upload($files): array
    {
        $errors = [];
        $fileName = null;
        $uploadOk = 1;
        
        $targetDirectory = dirname(__DIR__) . "/../../public/uploads/";

        $targetFile = $targetDirectory . basename($files["img_cover"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
        
            $check = getimagesize($files["img_cover"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                $errors[] = "File is not an image.";
                $uploadOk = 0;
            }
            
        if (file_exists($targetFile)) {
            $errors[] = "Sorry, file already exists.";
            $uploadOk = 0;
        }
        
        if ($files["img_cover"]["size"] > 600000) {
            $errors[] = "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            $errors[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        
        if ($uploadOk == 0) {
            $errors[] = "Sorry, your file was not uploaded.";
        } else {
            $temp = explode(".", $files["img_cover"]["name"]);
            $newFilename = round(microtime(true)) . '.' . end($temp);

            if (move_uploaded_file($files["img_cover"]["tmp_name"], $targetDirectory.basename($newFilename))) {
                $fileName = htmlspecialchars(basename($newFilename));
            } else {
                $errors[] = "Sorry, there was an error uploading your file.";
            }
        }
        
        return [
            $errors,
            $fileName
        ];
    }
}
