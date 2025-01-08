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
            <h1> SEAFLAVOUR </h1>
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
                <?php
                    }
                ?>
            </div>
        
    </header>