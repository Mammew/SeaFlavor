<!DOCTYPE html>
<html lang="it">
<head>
    <link rel="icon" type="image/x-icon" href="images/image.png">
    <title>SeaFlavor</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<div class="background"></div>
<body>
    <div class="reg">
        <form id="form" action="../Backend/update_password.php" method="post">
            <h2>Modifica Profilo</h2><br>

            <div class="input-group">
                <input type="password" id="current_password" name="current_password">
                <label for="current_password">Password corrente</label>
            </div>

            <div class="input-group">
                <input type="password" id="pass" name="pass">
                <label for="new_password">Nuova Password</label>
            </div>

            <div class="input-group">
                <input type="password" name="confirm" id="confirm">
                <label for="confirm">Conferma password</label>
                <div class="err-message" id="email_error"></div>
            </div>

            <button type="submit" id="submit" name="submit">Modifica</button>
        </form><br>
        <a href="home.php">Torna alla home</a>
</body>
</html>