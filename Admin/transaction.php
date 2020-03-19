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
    <style>
        a{
            text-decoration:none;
            color:#f4f4f4;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
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

        <section class="jumbotron text-center">
    <div class="container">
        <h1 class="jumbotron-heading text-left">Transaction Id: <?=$_GET['id']?></h1>
        <a class="float-right" href="#">Show Reserved Services</a>
     </div>
</section>

<div class="container mb-4">
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col"> </th>
                            <th scope="col" class="text-center">Service</th>
                            <th scope="col" class="text-center">No. Person</th>
                            <th scope="col" class="text-center">Price</th>
                            <th scope="col" class="text-center">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                            $transactionId = $_GET['id'];
                            $mysqli = new mysqli('localhost', 'root', '', 'spanchill');
                            $stmt = $mysqli->prepare("
                            SELECT transactionId, services.name, services.image, services.price, people, totalPrice, reserve_date
                            from transactions
                            INNER JOIN services
                            ON transactions.service_id = services.id
                            where transactionId = ?");
                            $stmt->bind_param('s', $transactionId);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $total = 0;
                            if($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                ?>
                                <tr>
                                <td><img style="width:50px; height:50px;" src="./../images/service_image/<?=$row['image']?>" /> </td>
                                <td class="text-center"><?=$row['name']?></td>
                                <td class="text-center"><?=$row['people']?></td>
                                <td class="text-center"><?=$row['price']?></td>
                                <td class="text-center"><?=$row['price']*$row['people']?></td>
                                </tr>
                                <?php
                                }
                            }
                            ?>
                    
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <?php
                            $transactionId = $_GET['id'];
                            $mysqli = new mysqli('localhost', 'root', '', 'spanchill');
                            $stmt = $mysqli->prepare("
                            SELECT transactionId, services.name, services.image, services.price, people, totalPrice, reserve_date
                            from transactions
                            INNER JOIN services
                            ON transactions.service_id = services.id
                            where transactionId = ?
                            limit 1");
                            $stmt->bind_param('s', $transactionId);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $total = 0;
                            $row = $result->fetch_assoc()
                            ?>
                            <td><p class="text-center">Date:</p></td>
                            <td class="text-center"><?=$row['reserve_date']?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><strong>Total</strong></td>
                            <td class="text-right"><strong>&#8369; <?=$row['totalPrice']?></strong></td>
                        </tr>
                    </tbody>
                   
                </table>
            </div>
        </div>
    </div>
</div>
<script>
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();
 if(dd<10){
        dd='0'+dd
    } 
    if(mm<10){
        mm='0'+mm
    } 

today = yyyy+'-'+mm+'-'+dd;
document.getElementById("datefield").setAttribute("min", today);
</script>
</body>
</html>
