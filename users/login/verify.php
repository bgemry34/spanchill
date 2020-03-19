<?php
$server = "http://spanchill.test/";
$mysqli = new mysqli('localhost', 'root', '', 'spanchill');
$stmt = $mysqli->prepare("SELECT * FROM users WHERE vkey = ? AND email_verified_at is null LIMIT 1");
$stmt->bind_param("s", $_GET['vkey']);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows > 0){
    $stmt = $mysqli->prepare("UPDATE users set email_verified_at = CURRENT_TIMESTAMP() where vkey = ?");
    $stmt->bind_param("s", $_GET['vkey']);
    $stmt->execute();
    $stmt->close();
    ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Verified</title>
            <style>
                *{
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    text-align: center;
                }
                a{
                    text-decoration: none;
                    color:#2980b9;
                }
            </style>
        </head>
        <body>
            <div class="" style="margin:auto; display:block">
                <img style="margin:auto; display: block; width: 50%; height:50%;" src="check.png" alt="">
                <h3 style="font-size: 1.5em;">Your account has been verified you can <a href="<?=$server?>users/login/">Log-in</a> to your account now!</h3>
            </div>
        </body>
        </html>
    <?php
}else{
    header('location: '.$server);
}
