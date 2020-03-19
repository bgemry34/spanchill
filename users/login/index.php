<?php
session_start();
$server = "http://localhost/spanchill/";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="./../../images/favicon.ico">
    <link rel="stylesheet" href="./../../style.css">
    <style>
        .registerContainer{
        }
        input::placeholder, textarea::placeholder{
            padding:0;
            color:#f4f4f4;
        }
        input{
            font-size:20px;
        }
        input:focus{
            outline:none;
        }

        input[type=password], input[type=email]{
            padding-left: 10px;
        }
        textarea{
            width:100%; 
            background-color: #f4f4f4; 
            border:none; border-radius: 0 ;
            border-bottom: 2px #f4f4f4 solid;
            caret-color:#000000;
            color:#000000;
            font-family: Poppins, Helvetica, sans-serif;
            font-size:20;
            padding: 5px;
        }
        input[type=text], input[type=password], input[type=email]{
            width:100%; background-color: 
            transparent; border:none; border-radius: 0 ;
            border-bottom: 2px #f4f4f4 solid;
            caret-color:#f4f4f4;
            color:#f4f4f4;
            padding: 5px;
        }
        a{
            text-decoration:none;
            color:#f4f4f4;
        }   

    </style>
    <title>Spa n Chill</title>
</head>
<body>
<div class="loading" id="loading">Loading&#8230;</div>
    <nav>
        <div class="container-fluid">
        <div class="nav-logo">
            <a href="./"><img style="height:64px; display:block; float:left" src="./../../images/navbrand.png" alt=""></a>
        </div>
        <ul class="nav-left">
                <li><a href="./../../">Home</a></li>
                <li><a href="./../../services.php">Services</a></li>
                <li><a href="./../../Posts">Posts</a></li>
                <li><a href="./">Login</a></li>
        </ul>
        </div>
    </nav>

    <div class="loginContainer">
        <div class="coantiner">
        <div class="formContainer">
            <div class="container">
            <br>
                <h1 style="letter-spacing:3px; font-size: 3rem;">Login</h1>
                <form action="./index.php" method="post" >
                <?php
                if(isset($_POST['login'])){
                    $errors = [];
                    $mysqli = new mysqli('localhost', 'root', '', 'spanchill');
                    $username = $_POST['username'];
                    $password = md5($_POST['password']);

                    $stmt = $mysqli->prepare("SELECT * FROM users WHERE username = ? AND password = ? LIMIT 1");
                    $stmt->bind_param("ss", $username, $password);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if($result->num_rows != 0){
                        $_SESSION['user'] = $username;
                        header('location: '.$server);
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
                <input class="forms-input" style="" type="text" 
                name="username" id="" placeholder="Username...">
                <input style="width:100%; margin-top: 2-px;" type="password" name="password" id="" placeholder="Password..." >
                <input style="width:100%; background-color:#ecf0f1; color:#2c3e50;"
                 type="submit" name="login" value="Login">
                </form>
                <p><a id="modal-btn" href="#">Register</a></p>
            </div> 
        </div>
        </div>
    </div>

    <footer>
		<div class="container">
			<p>Copyright &copy; 2020 - Spa n Chill</p>
		</div>
	</footer>

    <!-- modal-->
    <div id="my-modal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <span class="close">&times;</span>
        <h2>Register</h2>
      </div>
      
      <form id="create_form" action="./../../phpscripts/AuthUser.php" method="POST"> 
      <div id="registerContainer">
            <div class="modal-body">
                <div class="container-fluid">
                    <div style="color:#f4f4f4   " id="validation_error">
                    <!-- <p class="warning">Warning Test</p> -->
                    </div>
                    <input type="text" id="createdUsername" name="createdUsername" placeholder="Username...">
                    <input type="password" name="createdPassword" id="createdPassword" placeholder="Password...">
                    <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password...">
                    <input type="email" id="createdEmail" name="createdEmail" placeholder="Email...">
                    <input type="text" name="firstName" id="firstName" placeholder="First Name...">
                    <input  style="margin-bottom:10px" type="text" name="lastName" id="lastName" placeholder="Last Name...">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="toRegister" class="btn-register">Register</button>
            </div>
      </div>
      </form>
    </div>
  </div>

<script src="./../../js/script.js"></script>
<script src="./../../js/login.js"></script>
</body>
</html>