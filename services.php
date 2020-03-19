<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./Admin/bstp.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="./images/favicon.ico">
    <title>Spa n Chill</title>
</head>
<body>
<nav style="height:80px">
            <div class="container-fluid">
            <div class="nav-logo">
            <a href="./"><img style="height:64px; display:block; float:left" src="./images/navbrand.png" alt=""></a>
                </div>
                <ul class="nav-left">
                        <li><a href="./">Home</a></li>
                        <li><a href="./services.php">Services</a></li>
                       
                        <li><a href="./Posts">Posts</a></li>
                        <?php if(isset($_SESSION['user'])):?>
                        <li><a href="./reserve.php">Reservation</a></li>
                        <li><a href="#"><?=$_SESSION['user']?></a></li>
                        <li><a href="./logout.php">Log-out</a></li>
                        <?php else: ?>
                        <li><a href="./users/login/">Login</a></li>
                        <?php endif; ?>
                </ul>
            </div>
        </nav>

    <section class="skills about" style="margin-bottom:10vh">
        <div class="container">
            <br>
                <div class="header">
                        <h3>Services</h3>
                        <hr>
                </div>
            <br>
            <div class="grid-4">
            <?php
            $mysqli = new mysqli('localhost', 'root', '', 'spanchill');
            $stmt = $mysqli->prepare("SELECT * FROM services ORDER BY id DESC");
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows > 0){
            ?>
            <?php
                while($row = $result->fetch_assoc()) {
                ?>
               <div>
                    <img class="mx-auto d-block" src="images/service_image/<?=$row['image']?>" alt="">
                    <p class="mt-1"><?=$row['name']?></p>
                    <p>&#8369; <?=$row['price']?></p>
                    <?php if(isset($_SESSION['user'])):?>
                        <form action="services.php" method="post">
                        <input type="hidden" name="service_id" value="<?=$row['id']?>">
                        <input type="submit" name="toReserve" value="Reserve" class="btn btn-success w-50 mx-auto d-block">
                    </form>
                    <?php endif; ?>
                </div>
                <?php
                }
            }
            else{
                echo "<h1 style='margin-bottom:100vh'>NO SERVICES<h1>";
            }
            ?> 
            </div>
        </div>
    </section>
</body>
</html>
<?php
if(isset($_POST['toReserve'])){
    $username = $_SESSION['user'];
    $id = $_POST['service_id'];
    $mysqli = new mysqli('localhost', 'root', '', 'spanchill');
    $stmt = $mysqli->prepare("insert into reserved_list(username, service_id) values(?, ?)");
    $stmt->bind_param("ss", $username, $id);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Added Successfully');window.location.replace('reserve.php')</script>";
}