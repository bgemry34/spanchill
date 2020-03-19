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

    <div class="container">
    <br>
        <div style="display:grid; grid-template-columns: 1fr 1fr;">
            <h2>Transactions</h2>
        </div>  
        <br><br>
        <div style="display:grid; grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr; text-align:center">
            <h5>Transaction Id</h5>
            <h5>Username</h5>
            <h5>Total Amount</h5>
            <h5>Status</h5>
            <h5>Reserved Date</h5>
            <h5>Action</h5>
        </div>
        <br>
        <div style="display:grid; grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr; text-align:center">
        
            <!-- <p style="margin-top:5px">Name</p>
            <p style="margin-top:5px">Price</p>
            <div>
                <a href="https://facebook.com   "><button style="background-color: #27ae60; color:#f4f4f4; border:none; padding: 10px 20px 10px 20px; margin-bottom: 5px;">Edit</button></a>
                <button style="background-color: #e74c3c; color:#f4f4f4; border:none; padding: 10px 20px 10px 20px;">Delete</button>
            </div>
             -->
          <?php
                        $mysqli = new mysqli('localhost', 'root', '', 'spanchill');
                        $stmt = $mysqli->prepare("SELECT * FROM `transactions` group by transactionId order by transactionId desc");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $total = 0;
                        if($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                            ?>
                            <p style="margin-top:10px"><?=$row['transactionId']?></p>
                            <p style="margin-top:10px"><?=$row['username']?></p>
                            <p style="margin-top:10px"><?=$row['totalPrice']?></p>
                            <p style="margin-top:10px"><?=strtoupper($row['status'])?></p>
                            <p style="margin-top:10px"><?=$row['reserve_date']?></p>
                            <a href="./transaction.php?id=<?=$row['transactionId']?>" class="btn btn-link w-25 mx-auto"><i class="fas fa-eye fa-2x" style=""></i></a>
                            <?php
                            }
                        }
                        ?>
        </div>
    </div>

</body>
</html>