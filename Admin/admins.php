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
    <link rel="stylesheet" href="admin.css">
    <title>Admin</title>
    <style>
        a{
            text-decoration:none;
            color:#f4f4f4;
        }
    </style>
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
    <br>
        <div style="display:grid; grid-template-columns: 1fr 1fr;">
            <h2>Admins</h2>
            <button style="width: 300px; margin-left:auto; background-color: #27ae60; color:#f4f4f4; border:none"><a style="padding: 20px;"href="./addAdmin.php">Add Admin</a></button>
        </div>
        <br><br>
        <div style="display:grid; grid-template-columns: 1fr 1fr 1fr 1fr 1fr; text-align:center">
            <h5>First Name</h5>
            <h5>Last Name</h5>
            <h5>Username</h5>
            <h5>Email</h5>
            <h5>Action</h5>
        </div>
        <br>
        <div style="display:grid; grid-template-columns: 1fr 1fr 1fr 1fr 1fr; text-align:center">
             <?php
            $mysqli = new mysqli('localhost', 'root', '', 'spanchill');
            $stmt = $mysqli->prepare("SELECT * FROM admins ORDER BY id DESC");
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows > 0){
            ?>
            <?php
                while($row = $result->fetch_assoc()) {
                // $_SESSION['user'] = $row['username'];
                // $_SESSION['userId'] = $row['id'];
                ?>
                <p style="margin-top:10px"><?=$row['firstName']?></p>
                <p style="margin-top:10px"><?=$row['lastName']?></p>
                <p style="margin-top:10px"><?=$row['username']?></p>
                <p style="margin-top:10px"><?=$row['email']?></p>
                <div style="">
                   <form action="./admins.php" method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?=$row['id']?>">
                        <input style="background-color: #e74c3c; color:#f4f4f4; border:none; padding: 10px 20px 10px 20px; margin-bottom: 5px;" class="btn btn-danger" type="submit" value="Delete" name="toDelete">
                    </form>
                </div>
                <?php
                }
            }
            else{
                echo "<h1>No Accounts<h1>";
          }
          ?>
        </div>
    </div>

</body>
</html>
<?php
if(isset($_POST['toDelete'])){
    $id = $_POST['id'];
    $mysqli = new mysqli('localhost', 'root', '', 'spanchill');
    $stmt = $mysqli->prepare("DELETE from admins where id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Deleted Successfully');window.location.replace('admins.php')</script>";
}