<?php
session_start()
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="./../images/favicon.ico">
    <link rel="stylesheet" href="./../style.css">
    <title>Spa n Chill</title>
</head>
<body>
    <nav>
            <div class="container-fluid">
            <div class="nav-logo">
            <a href="./"><img style="height:64px; display:block; float:left" src="./../images/navbrand.png" alt=""></a>
                </div>
                <ul class="nav-left">
                        <li><a href="./../">Home</a></li>
                        <li><a href="./../services.php">Services</a></li>
                       
                        <li><a href="./../Posts">Posts</a></li>
                        <?php if(isset($_SESSION['user'])):?>
                        <li><a href="./../reserve.php">Reservation</a></li>
                        <li><a href="#"><?=$_SESSION['user']?></a></li>
                        <li><a href="./../logout.php">Log-out</a></li>
                        <?php else: ?>
                        <li><a href="./../users/login/">Login</a></li>
                        <?php endif; ?>
                </ul>
            </div>
        </nav>

    <div class="header">
            <h3 style="text-align:left; margin-left:50px; border-bottom: 4px solid black;">Forum</h3>
    </div>

    <div class="postContainer">
            <?php
            $mysqli = new mysqli('localhost', 'root', '', 'spanchill');
            $stmt = $mysqli->prepare("SELECT * from posts order by id DESC");
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows > 0){
            ?>
            <?php
                while($row = $result->fetch_assoc()) {
                // $_SESSION['user'] = $row['username'];
                // $_SESSION['userId'] = $row['id'];
                ?>
                <div class="posts">
                <div class="container-fluid">
                    <div class="picAndPost">
                        <div>
                            <img 
                            style="width:250px; height: 115px; margin-top:5px;" 
                            src="./../images/post_image/<?=$row['image']?>"
                            alt="">
                        </div>
                        <div>
                            <h2 style="margin:0; padding:0; color:#3498db" ><a style="text-decoration:none; color:#3498db" href="./post.php?id=<?=$row['id']?>"><?=$row['title']?></a></h2>
                            <p style="margin:0; padding:0;">Created date: <?=$row['created_at']?></p>
                        </div>
                    </div>
                </div>
                </div>
                <?php
                }
            }
            else{
                echo "<h1>NO POST<h1>";
          }
          ?>
          <!-- //end -->
    </div>
</body>
</html>