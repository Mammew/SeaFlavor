let email_error = document.getElementById("email_error");
let mail = document.getElementById("email");
let form = document.getElementById("form");
let emailUsed = false;
mail.addEventListener("change",function checkmail(){
    let usermail = mail.value;
    let url = "../Backend/checkMail.php";
    return fetch(url,{
        method: "post",
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: "email=" + usermail
    }).then(function(response){
        if(response.status != 200){
            console.log("there was a problem...");
            return;
        }
        return response;
    })
    .then((response) => response.text())
    .then(text => {
        if (text == "0") {
            email_error.innerHTML = "";
            emailUsed = false;
        }
        else if(text == "1"){
            email_error.innerHTML = "email giÃ in uso, inserirne un'altra";
            emailUsed = true;
        }
        })
    })

    form.addEventListener("submit", function(event){
        if (emailUsed) {
            event.preventDefault();
            console.log("invio bloccato");
        }
        else{
            console.log("invio permesso");
        }
    })
