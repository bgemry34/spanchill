<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="./images/favicon.ico">
    <link rel="stylesheet" href="style.css">
    <title>Spa n Chill</title>
</head>
<body>
    <Header>
        <nav>
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

        <div class="bg-content">
            <h2>Enjoy the good life. Enjoy a massage.</h2>
            <hr>
        </div>

        
        
    </Header>
        
    <section class="skills about">
        <div class="container">
            <br>
                <div class="header">
                        <h3>Popular Services</h3>
                        <hr>
                </div>
            <br>
            <div class="grid-4">
                <div>
                    <img src="images/hotstone.jpg" alt="">
                    <p>Hot stone massage</p>
                </div>

                <div>
                    <img src="images/thaimassage.jpg" alt="">
                    <p>Thai Massage</p>
                </div>

                <div>
                    <img src="images/ashiatsu.jpg" alt="">
                    <p>Ashiatsu</p>
                </div>

                <div>
                    <img src="images/swedishmassage.jpg" alt="">
                    <p>Swedish Massage</p>
                </div>
                
            </div>
        </div>
    </section>

    <footer>
		<div class="container">
			<p>Copyright &copy; 2020 - Spa n Chill</p>
		</div>
	</footer>
</body>
</html>
<?PHP
// $sender = 'bgemry2@gmail.com';
// $recipient = 'bgemry@yahoo.com';

// $subject = "php mail test";
// $message = "php test message";
// $headers = 'From:' . $sender;

// if (mail($recipient, $subject, $message, $headers))
// {
//     echo "Message accepted";
// }
// else
// {
//     echo "Error: Message not accepted";
// }