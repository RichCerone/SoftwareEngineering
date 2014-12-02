<?php
    //Author: Richard Cerone
    $targetDir = "map_images/"; //Directory where file will be uploaded.
    $targetFile = $targetDir . uniqid() . "_" . basename($_FILES["file"]["name"]); //File to be uploaded with unique id.

	$message = ""; //Message associated with error / success
    $success = 1; //Upload status: 1 means OK, 0 means error.
	
	
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));//Grabs file type.
    //Check if image file is a actual image or fake image
    if(isset($_POST["submit"]))
    {
        echo "tmp_name: ".$_FILES["file"]["tmp_name"];
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if($check !== false)
        {
            $message .= " File is an image - " . $check["mime"] . ".";
            $success = 1;
        }
        else
        {
            $message .= " File is not an image.";
            $success = 0;
        }
    }
    //Check if file already exists.
    if(file_exists($targetFile))
    {
        $message .= " Sorry, file already exists.";
        $success = 0;
    }
    //Check file size.
    if($_FILES["file"]["size"] > 65465456000)
    {
        $message .= " Sorry, your file was not uploaded too big.";
        $success = 0;
    }
    //Check file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "bmp")
    {
        $message .= "Sorry, only JPG, JPEG, PNG files are allowed. Filetype '" . $imageFileType . "' not allowed.";
        $success = 0;
    }
    //Check if $success is set to 0.
    if($success == 0)
    {
       $message .= "Sorry, your file was not uploaded.success = 0";
    }
    //If everything is OK, try to upload file.
    else
    {
        if(move_uploaded_file($_FILES["file"]["tmp_name"],$targetFile))
        {
          $message .= "File uploaded successfully!";
        }
        else
        {
            $message .= "Sorry, there was an error uploading your file. did not move file";
        }
    }
	
	
	$arr = array( "message" => $message,
				  "success" => $success,
				  "filePath" => $targetFile
						);

	echo json_encode($arr);
?>