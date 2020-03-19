<?php
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $server = "http://localhost/spanchill/";
    header('Content-Type: application/json');
    $mysqli = new mysqli('localhost', 'root', '', 'spanchill');

    $data = json_decode(file_get_contents('php://input'), true);
    $errors = [];

    //first name validation
    if(isset($data["firstName"])){
        if($data["firstName"] == "" OR $data["firstName"] == null){
            array_push($errors, "First name field is required!");
        }
        else if ( !preg_match ("/^[a-zA-Z\s]+$/",$data["firstName"])) {
            array_push($errors, "First name must only contain letters!");
        } 
    }else{
        array_push($errors, "First name field is required!");
    }

    //last name validation
    if(isset($data["lastName"])){
        if($data["lastName"] == "" OR $data["lastName"] == null){
            array_push($errors, "Last name field is required!");
        }
        else if ( !preg_match ("/^[a-zA-Z\s]+$/",$data["lastName"])) {
            array_push($errors, "Last name  must only contain letters!");
        } 
    }else{
        array_push($errors, "Last name field is required!");
    }

    //last name validation
    if(isset($data["email"])){
        if($data["email"] == "" OR $data["email"] == null){
        array_push($errors, "Email field is required!");
        }else if(!filter_var($data["email"], FILTER_VALIDATE_EMAIL))
        array_push($errors, "Invalid email format");   
    }else{
        array_push($errors, "Email field is required!");
    }

    //password validation
    if(!empty($data["password"])) {
        $password = $data["password"];
        $password_confirmation = $data["password_confirmation"];
        if($data["password"] == "" OR $data["password"] == null){
            array_push($errors, "Password field is required!");
        }
        else if (strlen($data["password"]) <= '8') {
            array_push($errors, "Your Password Must Contain At Least 8 Characters!");
        }else if($data["password"] !== $data["password_confirmation"]){
            array_push($errors, "Your Password And Password Confirmation Does Not Match");
        }
    }
    elseif(!empty($data["password"])) {
        $cpasswordErr = "Please Check You've Entered Or Confirmed Your Password!";
    } else {
         $passwordErr = "Please enter password   ";
    }

    //username validation
    if(isset($data["username"])){
        $stmt = $mysqli->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $data["username"]);
        $stmt->execute();
        $result = $stmt->get_result();

        if($data["username"] == "" OR $data["username"] == null){
            array_push($errors, "Username field is required!");
        }
        else if (strlen($data["username"]) < '5'){
            array_push($errors, "Username must have at least 5 character is required!");
        }
        else if (strlen($data["username"]) > '15'){
            array_push($errors, "Username must have at not greater than 15 character is required!");
        }
        else if (preg_match('/[^A-Za-z0-9]+/', $data["username"])) {
            array_push($errors, "Username must only contain letters and numbers!");
        }else if($result->num_rows !== 0){
            array_push($errors, "Username is already taken!");
        }
        $stmt->close();
    }else{
        array_push($errors, "Username field is required!");
    }


    if(count($errors)>0){
       echo json_encode(['errors'=>$errors], JSON_PRETTY_PRINT, 402);
       header('HTTP/1.1 400 Bad Request', true, 400);
    }else{
        $message = "Registered Successfully";
        //generate verification-key
        $vkey = md5(time().$data['username']);

        //inputs
        $username = $data['username'];
        $password = md5($data['password']);
        $email = $data['email'];
        $firstName = $data['firstName'];
        $lastName = $data['lastName'];

        $stmt = $mysqli->prepare("INSERT INTO users (username, password, email, vkey, firstName, lastName) VALUES (?, ?, ?, ?, ? ,?)");
        $stmt->bind_param("ssssss", $username, $password, $email, $vkey, $firstName, $lastName);
        echo json_encode(["status"=>"success",'message'=>$message], JSON_PRETTY_PRINT, 201);
        $stmt->execute();
        $stmt->close();

        header('HTTP/1.1 201 Created', true, 201);
    }

}