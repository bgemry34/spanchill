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
        <h3 style="text-align:center">Add Admin</h3>
<?php
if(isset($_POST['addAdmin'])){
  
  $errors = [];
  //first name validation
    if(isset($_POST["firstName"])){
        if($_POST["firstName"] == "" OR $_POST["firstName"] == null){
            array_push($errors, "First name field is required!");
        }
        else if ( !preg_match ("/^[a-zA-Z\s]+$/",$_POST["firstName"])) {
            array_push($errors, "First name must only contain letters!");
        } 
    }else{
        array_push($errors, "First name field is required!");
    }

    //last name validation
    if(isset($_POST["lastName"])){
        if($_POST["lastName"] == "" OR $_POST["lastName"] == null){
            array_push($errors, "Last name field is required!");
        }
        else if ( !preg_match ("/^[a-zA-Z\s]+$/",$_POST["lastName"])) {
            array_push($errors, "Last name must only contain letters!");
        } 
    }else{
        array_push($errors, "Last name field is required!");
    }

    //last name validation
    if(isset($_POST["email"])){
        if($_POST["email"] == "" OR $_POST["email"] == null){
        array_push($errors, "Email field is required!");
        }else if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
        array_push($errors, "Invalid email format");   
    }else{
        array_push($errors, "Email field is required!");
    }

    //password validation
    if(isset($_POST["password"])) {
        $password = $_POST["password"];
        $password_confirmation = $_POST["password_confirmation"];
        if($_POST["password"] == "" OR $_POST["password"] == null){
            array_push($errors, "Password field is required!");
        }
        else if(strlen($_POST["password"]) <= '8') {
            array_push($errors, "Your Password Must Contain At Least 8 Characters!");
        }else if($_POST["password"] !== $_POST["password_confirmation"]){
            array_push($errors, "Your Password And Password Confirmation Does Not Match");
        }
    }
    else {
         $passwordErr = "Please enter your password   ";
    }   
    //username validation
    if(isset($_POST["username"])){
        $mysqli = new mysqli('localhost', 'root', '', 'spanchill');
        $stmt = $mysqli->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->bind_param("s", $_POST["username"]);
        $stmt->execute();
        $result = $stmt->get_result();

        if($_POST["username"] == "" OR $_POST["username"] == null){
            array_push($errors, "Username field is required!");
        }
        else if (strlen($_POST["username"]) < '5'){
            array_push($errors, "Username must have at least 5 character is required!");
        }
        else if (strlen($_POST["username"]) > '15'){
            array_push($errors, "Username must have at not greater than 15 character is required!");
        }
        else if (preg_match('/[^A-Za-z0-9]+/', $_POST["username"])) {
            array_push($errors, "Username must only contain letters and numbers!");
        }else if($result->num_rows !== 0){
            array_push($errors, "Username is already taken!");
        }
        $stmt->close();
    }else{
        array_push($errors, "Username field is required!");
    }


    if(count($errors)>0){
        foreach($errors as $error)
        echo "<p class='warning'>$error</p>";
    }else{
        //inputs
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        $email = $_POST['email'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $mysqli = new mysqli('localhost', 'root', '', 'spanchill');
        $stmt = $mysqli->prepare("INSERT INTO admins (username, password, email, firstName, lastName) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $password, $email, $firstName, $lastName);
        $stmt->execute();
        $stmt->close();

        header('Location:'.$server.'Admin/admins.php');
    }
}
?>
        <form action="addAdmin.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="">First Name:</label>
            <input type="text" class="form-control" name="firstName" placeholder="">
        </div>
        <div class="form-group">
            <label for="">Last Name:</label>
            <input type="text" class="form-control" name="lastName" placeholder="">
        </div>
        <div class="form-group">
            <label for="">Email</label>
            <input type="text" class="form-control" name="email" placeholder="">
        </div>
        <div class="form-group">
            <label for=""> Username:</label>
            <input type="text" class="form-control" name="username" placeholder="">
        </div>
        <div class="form-group">
            <label for="">Password:</label>
            <input type="password" class="form-control" name="password" placeholder="">
        </div>
        <div class="form-group">
            <label for="">Confirm Password:</label>
            <input type="password" class="form-control" name="password_confirmation" placeholder="">
        </div>

        <div class="form-group">
            <input type="submit" value="Submit" class="form-control btn btn-success" name="addAdmin" id="">
        </div>
        </form>
        </div>
    </div>
</body>
</html>
