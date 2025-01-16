let form = document.getElementById("form");
let password = document.getElementById("pass");
let confirmPassword = document.getElementById("confirm");
let password_error = document.getElementById("password_error");
let passwordMismatch = false;

confirmPassword.addEventListener("change",()=>{
    if (password.value != confirmPassword.value) {
        passwordMismatch = true;
        password_error.innerHTML="Le due password non coincidono";
    }    
    else{
        passwordMismatch = false;
        password_error.innerHTML = "";
    }
})

form.addEventListener("submit", function(event){
    if (passwordMismatch) {
        event.preventDefault();
        console.log("invio bloccato");
    }
    else{
        console.log("invio permesso");
    }
})