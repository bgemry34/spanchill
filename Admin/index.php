<?php
session_start();
$server = "http://localhost/spanchill/";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Admin login</title>
</head>
<body>
<form action="index.php" method="POST">

	<h2>Admin Login</h2>

	
  <?php
  if(isset($_POST['login'])){
    $errors = [];
    $mysqli = new mysqli('localhost', 'root', '', 'spanchill');
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $stmt = $mysqli->prepare("SELECT * FROM admins WHERE username = ? AND password = ? LIMIT 1");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows != 0){
      $_SESSION['admin'] = $username;
      header('location: '.$server.'Admin/services.php');
    }else{
        if($_POST['username'] == "" OR $_POST['username'] == null)
        array_push($errors, "Username is required");
        if($_POST['password'] == "" OR $_POST['password'] == null)
        array_push($errors, "Password is required");
        
        if($_POST['password'] !== "" AND $_POST['username'] !== "")
        array_push($errors, "invalid Username or Password");
    }
    
    if(count($errors)>0){
        foreach($errors as $error)
        echo "<p class='warning'>$error</p>";
    }
  }
  ?>
  <input type="text" name="username" class="text-field" placeholder="Username" />
  <input type="password" name="password" class="text-field" placeholder="Password" />  
  <input type="submit"  class="button" name="login" value="Log In" />


</form>

</body>
</html>