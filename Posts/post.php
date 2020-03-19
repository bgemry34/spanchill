

<?php
session_start();
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
                        <li><a href="./../auth/users/profile.php"><?=$_SESSION['user']?></a></li>
                        <li><a href="./../logout.php">Log-out</a></li>
                        <?php else: ?>
                        <li><a href="./../users/login/">Login</a></li>
                        <?php endif; ?>
                </ul>
            </div>
        </nav>

    

    <?php
            if(isset($_GET['id'])){
                $id = $_GET['id'];
            }
            $mysqli = new mysqli('localhost', 'root', '', 'spanchill');
            $stmt = $mysqli->prepare("SELECT * from posts where id = ?");
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows > 0){
            ?>
            <?php
                while($row = $result->fetch_assoc()) {
                // $_SESSION['user'] = $row['username'];
                // $_SESSION['userId'] = $row['id'];
                ?>
                <div class="container">
                <div>
                    <h1 style="text-align: center"><?=$row['title']?></h1>
                </div>
                <?php if($row['image']!='noimage.jpg'):?>
                    <div>
                    <img style="width: 512px; height:512px; display:block; margin:auto;" src="./../images/post_image/<?=$row['image']?>" alt="">
                    </div>
                <?php endif;?>
                <div>
                    <p>Created at <?=$row['created_at']?></p>
                </div>
                <div>
                     <?=$row['content']?>
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
<!-- 
          end -->
    <br>    
    <br><br>
    <?php if(isset($_SESSION['user'])):?>
        <div class="container">
          <textarea style="width:95%; margin:auto; display:block;" name="" id="" cols="15" rows="3" placeholder="Comment here"></textarea>
          <input style="float:right; margin-right:20px" type="submit" value="Comment" name="toComment">
        </div>
    <?php endif;?>
</body>
</html>