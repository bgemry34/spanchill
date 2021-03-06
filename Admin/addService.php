<?php
session_start();
$server = "http://localhost/spanchill/";
if(!isset($_SESSION['admin'])){
    header('location: '.$server);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bstp.css">
    <link rel="stylesheet" href="admin.css">
    <title>Admin</title>
</head>
<body>
    <header>
        <div class="container">
            <div id="branding">
            <h1><span class="highlight">Admin</span> panel</h1>
            </div>
            <nav>
            <ul>
                <li><a href="services.php">Services</a></li>
                <li><a href="posts.php">Posts</a></li>
                <li><a href="transactions.php">Transactions</a></li>
                <li><a href="admins.php">Admin</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
            </nav>
        </div>
    </header>
    <div class="container">
        <div class="col-md-5 offset-4 mt-5">
        <h3 style="text-align:center">Add Services</h3>
        <?php
if(isset($_POST['addService'])){
  $isOK = false;
  $errors = [];
  if($_POST['name'] == "")
  array_push($errors, "Name field is required!");
  if($_POST['price']=="" ||  $_POST['price']<=0 || !is_numeric($_POST['price']))
  array_push($errors, "Price field is required!");
  if(count($errors)>0){
    foreach($errors as $error)
    echo "<p class='warning'>$error</p>";
  }else{
  $name = addslashes($_POST['name']);
  $price =$_POST['price'];
  if(file_exists($_FILES['image']['tmp_name']) || is_uploaded_file($_FILES['image']['tmp_name'])){
    $file = $_FILES['image'];
    $fileName =  $_FILES['image']['name'];
    $fileTmpName  = $_FILES['image']['tmp_name'];
    $fileSize = $_FILES['image']['size'];
    $fileError = $_FILES['image']['error'];
    $fileType = $_FILES['image']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png');

    if(in_array($fileActualExt, $allowed)){
        if($fileError===0){
            if($fileSize<2*1048576){
              $fileNameNew = uniqid('', true).".".$fileActualExt;
              $fileDestination = './../images/service_image/'.$fileNameNew;
              $conn=mysqli_connect("localhost","root","","spanchill");
              $mysqli = new mysqli('localhost', 'root', '', 'spanchill');
              $stmt = $mysqli->prepare("INSERT INTO services(name, price, image) Values(?, ?, ?)");
              $stmt->bind_param("sss", $name, $price, $fileNameNew);
              if ($stmt->execute()) {
                  $stmt->close();
                  echo "<script>alert('Added Successfully');window.location.replace('services.php')</script>";
              } else {
                  echo "Error updating record: " . mysqli_error($conn);
              }
              move_uploaded_file($fileTmpName, $fileDestination);
            }else{
              echo "<script>alert('file size is too big')</script>";  
            }
        }else{
          echo "<script>alert('there was an error uploading your file')</script>";
        }
    }else{
      echo "<script>alert('error file type')</script>";
    }
  }else{
    $mysqli = new mysqli('localhost', 'root', '', 'spanchill');
    $stmt = $mysqli->prepare("INSERT INTO services(name, price, image) Values(?, ?, ?)");
    $noimg = "noimage.jpg";
    $stmt->bind_param("sss", $name, $price, $noimg);
    if ($stmt->execute()) {
        $stmt->close();
        echo "<script>alert('Added Successfully');window.location.replace('services.php')</script>";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
  }}
}
?>
        <form action="addService.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="">Name:</label>
            <input type="text" class="form-control" name="name" placeholder="">
        </div>
        <div class="form-group">
            <label for="">Price:</label>
            <input type="number" class="form-control" name="price" placeholder="">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Image:</label>
            <input type="file" class="form-control" name="image">
        </div>
        <div class="form-group">
            <input type="submit" value="Submit" class="form-control btn btn-success" name="addService" id="">
        </div>
        </form>
        </div>
    </div>
</body>
</html>
