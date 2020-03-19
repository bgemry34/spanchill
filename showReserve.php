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
    <link rel="icon" href="./images/favicon.ico">
    <link rel="stylesheet" href="style.css">
    <title>Spa n Chill</title>
</head>
<body>
<div class="loading" id="loading">Loading&#8230;</div>
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
                        <li><a href="./auth/users/profile.php"><?=$_SESSION['user']?></a></li>
                        <li><a href="./logout.php">Log-out</a></li>
                        <?php else: ?>
                        <li><a href="./users/login/">Login</a></li>
                        <?php endif; ?>
                </ul>
            </div>
        </nav>


<section class="jumbotron text-center">
    <div class="container">
        <h1 class="jumbotron-heading float-left">Reserved Services</h1>
     </div>
</section>

<div class="container mb-4">
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Transaction Id</th>
                            <th scope="col">Reserved Date</th>
                            <th scope="col" class="text-center">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- <tr>
                            <td>123123123</td>
                            <td>123123123</td>
                            <td class="text-center">124,90 €</td>
                            <td class="text-right"><button class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> </button> </td>
                        </tr> -->
                        <?php
                        $username = $_SESSION['user'];
                        $mysqli = new mysqli('localhost', 'root', '', 'spanchill');
                        $stmt = $mysqli->prepare("SELECT * FROM `transactions` WHERE username = ? group by transactionId");
                        $stmt->bind_param('s', $username);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $total = 0;
                        if($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                            ?>
                            <tr>
                            <td><?=$row['transactionId']?></td>
                            <td><?=$row['reserve_date']?></td>
                            <td class="text-center"><?=$row['totalPrice']?></td>
                            </tr>
                            <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>