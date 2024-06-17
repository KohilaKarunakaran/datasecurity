<?php

if(isset($_POST['submit'])) {

    $newFileName = $_POST['filename'];
    if (empty($newFileName)) {
        $newFileName = "gallery";
    } else {
        $newFileName = strtolower(str_replace(" ", "-", $newFileName));
    }
    $imageTitle =  $_POST['filetitle'];
    $imageDesc =  $_POST['filedesc'];


  $file = $_FILES['file'];

  $fileName = $file["name"];
  $fileType = $file["type"];
  $fileTempName = $file["tmp_name"];
  $fileError = $file["error"];
  $fileSize = $file["size"];

  $fileExt = explode(".", $fileName);
  $fileActualExt = strtolower(end($fileExt));

  $allowed = array("jpg", "jpeg", "png");

  if(in_array($fileActualExt, $allowed)) {
    if($fileError === 0) {
        if($fileSize < 20000000) {
            $imageFullName = $newFileName . "." . uniqid("", true). "." . $fileActualExt;
            $fileDestination = "gallery/" . $imageFullName;

            include_once "db_config.php";
            
            if (empty($imageTitle)) {
                header("Location:/kuvagalleria.php?upload=empty");
                exit();
            } else {
                $sql = "SELECT * FROM kuvat";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo "SQL statement failed!";
                } else {
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $rowCount = mysqli_num_rows($result);
                    $setImageOrder = $rowCount + 1;

                    $sql = "INSERT INTO kuvat (kuvatiedosto,kuvatyyppi,kayttaja) VALUES (?, ?,1)";
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                        echo "SQL statement failed!";
                } else {
                    mysqli_stmt_bind_param($stmt, "ss",$imageFullName,$fileActualExt);
                    mysqli_stmt_execute($stmt);

                    move_uploaded_file($fileTempName, $fileDestination);
                    echo "Files " . $fileTempName . " " . $fileDestination;
                    //header("Location: ../kuvagalleria.php?upload=success");

                }
                }
                }

        }else {
            echo "File size is too big" . $fileSize;
            exit();
        }

    }else {
        echo "You had an error";
        exit();
    }

  }else {
    echo "You need to upload a proper file type!" . $fileActualExt;
    exit();
  }
}