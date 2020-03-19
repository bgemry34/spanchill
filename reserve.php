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
            <div class="nav-logo pb-2">
                <a class="pb-2" href="./"><img style="height:64px; display:block; float:left" src="./images/navbrand.png" alt=""></a>
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
        <h1 class="jumbotron-heading">Reservation</h1>
        <a class="float-right" href="showReserve.php">Show Reserved Services</a>
     </div>
</section>

<div class="container mb-4">

<?php
if(isset($_POST['toReserve']))  
{
    function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}
    if($_POST['reserveDate'] == "" || $_POST['reserveDate'] == null || !validateDate($_POST['reserveDate'])){
        echo '<div class="alert alert-danger text-center" role="alert">Date is required</div>';
    }else{
        if(!($_POST['reserveDate']>=date('Y-m-d'))){
            echo '<div class="alert alert-danger text-center" role="alert">Invalid Date</div>';
        }else{
            //get total
            $transaction_id = date('ymd').rand(11111111,9999999);
            $username = $_SESSION['user'];
            $total = 0;
            $mysqli = new mysqli('localhost', 'root', '', 'spanchill');
            $stmt = $mysqli->prepare("
            SELECT services.id, username, services.name, services.image, services.price, sum(people) as people, sum((services.price)) as amount
            from reserved_list
            INNER JOIN services
            on reserved_list.service_id = services.id
            where username = ?
            GROUP BY username, services.name");
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $total = 0;
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                $total+=$row['amount'];
                }
            }

            //insert the data into trancaction :(
            $stmt = $mysqli->prepare("
            SELECT services.id, username, services.name, services.image, services.price, sum(people) as people, sum((services.price)) as amount
            from reserved_list
            INNER JOIN services
            on reserved_list.service_id = services.id
            where username = ?
            GROUP BY username, services.name");
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()) {
                    $mysqli = new mysqli('localhost', 'root', '', 'spanchill');
                    $stmt = $mysqli->prepare("insert into transactions(transactionId, username,  service_id, people, totalPrice, reserve_date) values(?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param('ssssss', $transaction_id, $username, $row['id'], $row['people'], $total, $_POST['reserveDate']);
                    $stmt->execute();
                }
            }

            //
            $stmt = $mysqli->prepare("
            delete
            from reserved_list
            where username = ?");
            $stmt->bind_param('s', $username);
            $stmt->execute();

            echo '<div class="alert alert-success text-center" role="alert">Reserved</div>';
        }
       
    }
}
?>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col"> </th>
                            <th scope="col">Service</th>
                            <th scope="col" class="text-center">No. Person</th>
                            <th scope="col" class="text-center">Price</th>
                            <th scope="col" class="text-center">Amount</th>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $username = $_SESSION['user'];
                    $total = 0;
                    $mysqli = new mysqli('localhost', 'root', '', 'spanchill');
                    $stmt = $mysqli->prepare("
                    SELECT services.id, username, services.name, services.image, services.price, sum(people) as people, sum((services.price)) as amount
                    from reserved_list
                    INNER JOIN services
                    on reserved_list.service_id = services.id
                    where username = ?
                    GROUP BY username, services.name");
                    $stmt->bind_param('s', $username);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if($result->num_rows > 0){
                    ?>
                    <?php
                        while($row = $result->fetch_assoc()) {
                        $total+=$row['amount'];
                        ?>
                        <tr>
                            <td><img style="width:50px; height:50px;" src="./images/service_image/<?=$row['image']?>" /> </td>
                            <td><?=$row['name']?></td>
                            <td><input disabled class="form-control w-25 mx-auto" style="position:relative; bottom:25px;" type="number" value="<?=$row['people']?>" /></td>
                            <td class="text-right">&#8369; <?=$row['price']?></td>
                            <td class="text-center">&#8369; <?=$row['amount']?></td>
                            <td class="text-right">
                            <form action="reserve.php" method="post">
                            <input type="hidden" name="service_id" value="<?=$row['id']?>">
                            <input type="hidden" name="todelete" value="todelete">
                            <button class="btn btn-sm btn-danger" type="submit"><i class="fa fa-trash"></i> </button> 
                            </form>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><p class="mt-4">Date <span style="color:red">*</span> :</p></td>

                            <form action="" method="post">
                            <td class="text-right"><input id="datefield" type="date" name="reserveDate" id="" class="form-control"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><strong>Total</strong></td>
                            <td class="text-right"><strong>&#8369; <?=$total?></strong></td>
                        </tr>
                    </tbody>
                   
                </table>
            </div>
        </div>
        <div class="col mb-2">
            <div class="row">
                <div class="col-sm-12  col-md-6">
                    <a href="./services.php" class="btn btn-block btn-light">Continue Resrving</a>
                </div>
                <div class="col-sm-12 col-md-6 text-right">
                    <input type="hidden" name="toReserve" value="toReserve">
                    <button type="submit" class="btn btn-lg btn-block btn-success text-uppercase">Reserve</button>
                    </form>
                </div>
            </div>
        </div>
        <?php
        }
        else{
            echo "<h1>NO SERVICES RESERVE<h1>";
        }
        ?>
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
<?php
if(isset($_POST['todelete'])){
    $id = $_POST['service_id'];
    $username = $_SESSION['user'];
    $mysqli = new mysqli('localhost', 'root', '', 'spanchill');
    $stmt = $mysqli->prepare("delete from reserved_list where service_id = ? AND username = ?");
    $stmt->bind_param('ss', $id, $username);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Deleted Successfully');window.location.replace('reserve.php')</script>";
}
