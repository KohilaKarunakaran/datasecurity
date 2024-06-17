<?php

$_SESSION['username'] = "root";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <style>
        .gallery-links h1 {
            font-size: 28px;
            color: blue;
            text-transform: uppercase;
        
        }
        .gallery-container {
            width: 100%;
            height: 500px;
            background: white;
            display: flex;
            flex-flow: row wrap;
            justify-content: space-between; 
            align-items: flex-start;
            align-content: space-between;
            

        }
    .gallery-container a div{
    width: 450px;
    height: 450px;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    margin-top: 20px;
     margin-bottom: 30px;
  }
  
  .gallery-container a:hover {
    opacity: 0.8;
  }

  .gallery-upload {
padding-top: 500px;


  }
  </style>
</head>
<body>
    <section class="gallery-links">
        <div class="wrapper">
    <h1>Kuvagalleria</h1>
 <div class="gallery-container">
  <?php
  include_once 'includes/db_config.php';

  $sql = "SELECT * FROM kuvat ORDER BY kuvaid DESC";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo "SQL statement failed!";
  } else {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
      echo '<a href="#">
    <div style="background-image: url(gallery/'.$row["kuvatiedosto"].');"></div>
  </a>';
    }
  }
  
  ?>
</div>
</section>
<?php
if (isset($_SESSION['username'])) {

echo '<div class="gallery-upload">
<form action="includes/gallery-upload.php" method="post" enctype="multipart/form-data">
    <input type="text" name="filename" placeholder="File name...">
    <input type="text" name="filetitle" placeholder="Image title...">
    <input type="text" name="filedesc" placeholder="image description...">
    <input type="file" name="file"><br>
    <button type="submit" name="submit">UPLOAD</button>
</form>
</div>';

}

?>

</body>
</html>