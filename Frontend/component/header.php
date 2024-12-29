<?php
    include "../Backend/checkRememberMe.php";
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SeaFlavor</title>
    <link rel="icon" type="image/x-icon" href="images/image.png">
    <!--<link rel="stylesheet" type="text/css" href="css/home.css">  Da cambiare il foglio di stile prob.. -->
    <link rel="stylesheet" type="text/css" href="css/sticky_header.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
</head>
<body>
    <header>
        <div class="sticky-header" >
            <img id="logo" src="images/favicon.png" alt="Logo della start up SeaFlavor">
            <h1> SEAFLAVOUR </h1>
            <div class="container-bottoni">
                <?php
                    if (!isset($_SESSION['email'])) {
                ?>
                    <button class="bottone" id="loginButton">Login</button>
                    <button class="bottone" id="registratiButton">Registrati</button>
                    <script>
                        document.getElementById("loginButton").addEventListener("click", function() {
                            window.location.href = "login.html";
                        });

                        document.getElementById("registratiButton").addEventListener("click", function() {
                            window.location.href = "registration.html";
                        });
                    </script>
                <?php
                    } else{
                ?>
                    <button class="bottone" id="logoutButton">Registrati</button>
                    <script>
                        document.getElementById("logoutButton").addEventListener("click", function() {
                            window.location.href = "../Backrnd/logout.php";
                        });
                    </script>
                <?php
                    }
                ?>
            </div>
        
    </header>