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
        <h3 style="text-align:center">Edit Post</h3>
        <?php
if(isset($_POST['editPost'])){
    $id=$_POST['id'];
    $errors = [];
    if($_POST['title'] == "")
    array_push($errors, "Title field is required!");
    if($_POST['content']=="")
    array_push($errors, "Content field is required!");
    if(count($errors)>0){
      foreach($errors as $error)
      echo "<p class='warning'>$error</p>";
    }else{

    $title = addslashes($_POST['title']);
    $content =addslashes($_POST['content']);
    
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
                $fileDestination = './../images/post_image/'.$fileNameNew;
                $mysqli = new mysqli('localhost', 'root', '', 'spanchill');
                $id=$_POST['id'];   
                $stmt = $mysqli->prepare("update posts set title=?, content=?, image=? where id = ?");
                $stmt->bind_param("ssss", $title, $content, $fileNameNew, $id);
                if ($stmt->execute()) {
                    $stmt->close();
                    echo "<script>alert('Edited Successfully');window.location.replace('posts.php')</script>";
                } else {
                    echo "Error updating record: " . $mysqli->error;
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
      $id = $_POST['id'];
      $mysqli = new mysqli('localhost', 'root', '', 'spanchill');
      $stmt = $mysqli->prepare("update posts set title=?, content=? where id = ?");
      $stmt->bind_param("sss", $title, $content, $id);
      if ($stmt->execute()) {
          $stmt->close();
          echo "<script>alert('Edited Successfully');window.location.replace('posts.php')</script>";
      } else {
          echo "Error updating record: " . mysqli_error($conn);
      }
    }}
  }
?>
        <form action="editPost.php" method="POST" enctype="multipart/form-data">
        <?php
        if(isset($_GET['id']))
        {$id = $_GET['id'];
        $mysqli = new mysqli('localhost', 'root', '', 'spanchill');
        $stmt = $mysqli->prepare("SELECT * FROM posts WHERE id = ? LIMIT 1");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();}
        ?>
        <div class="form-group">
            <label for="">Title:</label>
            <input type="text" class="form-control" name="title" placeholder="" value="<?=$row['title']?>">
        </div>
        <div class="form-group">
            <label for="">Content:</label>
            <textarea name="content" id="" cols="30" rows="10" class="form-control"><?=$row['content']?></textarea>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Image:</label>
            <input type="file" class="form-control" name="image">
        </div>
        <input type="hidden" name="id" value="<?=$row['id']?>">
        <div class="form-group">
            <input type="submit" value="Submit" class="form-control btn btn-success" name="editPost" id="">
        </div>
        </form>
        </div>
    </div>
</body>
</html>
