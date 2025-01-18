<!DOCTYPE html>
<html lang="it">
<head>
    <title>SeaFlavor</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<div class="background"></div>
<body>
    <form class="reg" id="form" action="../Backend/iscritti.php" method="post">
        <h2>Newsletter</h2><br>

        <div class="input-group">
            <input type="text" id="firstname" name="firstname" required>
            <label for="firstname">Nome</label>
        </div>

        <div class="input-group">
            <input type="email" name="email" id="email" required>
            <label for="email">Email</label>
        </div>
        
        <button type="submit" id="submit" name="submit">Iscriviti</button><br><br>
    </form>
</body>
</html>