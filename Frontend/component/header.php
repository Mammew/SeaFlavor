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
            <a href="home.php">
                <img id="logo" src="images/favicon.png" alt="Logo della start up SeaFlavor">
            </a>
            <h1 id="title"> SEAFLAVOUR </h1>
            <div class="auth-buttons">
                <?php
                    if (!isset($_SESSION['email'])) {
                ?>
                    <a href="login.html">Login</a>
                    <a href="registration.html">Registrati</a>
                <?php
                    } else{
                ?>
                    <a href="../Frontend/logout.php">Esci</a>
                    <a href="../Frontend/show_profile.php">Profilo</a>
                    <a href="../Frontend/carrello.php">
                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 15a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0h8m-8 0-1-4m9 4a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-9-4h10l2-7H3m2 7L3 4m0 0-.792-3H1"/>
                        </svg>
                        <!--<span>0</span>-->
                    </a>
                <?php
                    }
                ?>
            </div>
        
    </header>