document.getElementById('toRegister').addEventListener('click', async () =>{
    let username = document.getElementById('createdUsername').value,
    password = document.getElementById('createdPassword').value,
    password_confirmation =  document.getElementById('confirmPassword').value,
    email = document.getElementById('createdEmail').value,
    firstName = document.getElementById('firstName').value,
    lastName = document.getElementById('lastName').value


    
    document.getElementById('loading').style.display = "block"
    let response = await fetch('register.php', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            "username": username,
            "password": password,
            "password_confirmation": password_confirmation,
            "email": email,
            "firstName":firstName,
            "lastName":lastName,
        }),
        }).catch((error) => {
            console.log("error : " +error);
            document.getElementById('loading').style.display = "none"
            return false
        });
    let responseJson = await response.json();
    document.getElementById('loading').style.display = "none"
    if(response.status == 400){
        let output = '';
        responseJson.errors.forEach(error=>{
            output+="<p class='warning'>"+error+"</p>"
        })

        document.getElementById('validation_error').innerHTML = output
    }else if(response.status == 201){
        document.getElementById('registerContainer'). innerHTML = "<div class='modal-body'><p style='color:#f4f4f4; text-align:center; background-color:rgba(44, 62, 80)'>"+responseJson.message+"</p></div>"
        console.log(responseJson)
    }
    
})