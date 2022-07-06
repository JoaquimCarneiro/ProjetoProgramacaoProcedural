<?php
if(isset($_POST['submit'])){
    $file = $_FILES['file'];
    //print_r($file);

    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    $fileNameExploded = explode('.', $fileName);
    $fileExtention = strtolower(end($fileNameExploded));
    echo $fileExtention;

    $allowedExtentions = array ('jpg', 'jpeg', 'png', 'pdf');

    if(in_array($fileExtention, $allowedExtentions)){
        if($fileError === 0){
            if($fileSize < 500000){
                $newFileName = uniqid($fileNameExploded[0], true).".".$fileExtention;
                echo $newFileName;
                $fileDestination = "imgs/".$newFileName;
                move_uploaded_file($fileTmpName, $fileDestination);
                //header...
            }else{
                echo "file too big";
            }
        }else{
            echo "Upload failed";
        }

    }else{
        echo "invalid type";
    }
}