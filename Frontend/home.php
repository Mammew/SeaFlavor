<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SeaFlavor</title>
    <link rel="icon" type="image/x-icon" href="images/image.png">
    <link rel="stylesheet" type="text/css" href="home.css"> <!-- Da cambiare il foglio di stile prob.. -->
</head>
<body>
    <h1 id="titolo">SeaFlavour</h1><br>

    <nav class="navbar" id="navbar">
        <a href="registration.html">Sign In </a> |
        <a href="">Team </a> |
        <a href="">Case history </a> |
        <a href="">Contact us </a>
    </nav>
    <br>

    <img id="logo" src="images/favicon.png" alt="Logo della start up SeaFlavor">
    
    <?php

    ?>
    
    <!-- Mostrare solo se loggato (facciamo due home o esiste altro modo?)-->
    <form action="../Backend/logout.php", method="post">
        <input type="submit" class="logout" id="logout" name="logout" value="Esci">
    </form>
    
</body>
</html>