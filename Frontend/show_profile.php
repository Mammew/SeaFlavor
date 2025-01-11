<?php
    session_start();
    if (isset($_SESSION["email"])) {
        $conn = new mysqli('localhost', 'root', '', 'primoDB');
        if (!$conn) {
            echo "Impossible to connect to DB...";
        }
        try {
            $stmt = $conn->prepare("SELECT nome,cognome,email FROM utenti WHERE email = ?");
        } catch (mysqli_sql_exception $e) {
            error_log("Prepared failed: (" . $e . ")");
            echo "Query error...";
            exit();
        }

        $stmt->bind_param('s', $_SESSION["email"]);
        try {
            $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            error_log("Query failed: (" . $e . ")");
            echo "Query fauled...";
            exit();
        }
        $result = $stmt->get_result();
        if (mysqli_stmt_errno($stmt) != 0) {
            echo "Something went wrong...";
            $stmt->close();
            session_destroy();
            header("Location: home.php");
            exit();
        }
        //recupero i vari campi della query
        $array_result = $result->fetch_assoc();
    }
    else
        header("Location: home.php");
?>

<!DOCTYPE html>
<html lang="it"> 
<head>
    <title>SeaFlavor</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<div class="background"></div>
<body>
    <form class="reg" id="form" action="update_profile.php" method="post">
        <h2>Modifica</h2><br>

        <div class="input-group">
            <input type="text" id="firstname" name="firstname" value="<?php echo $array_result['nome']?>">
            <label for="firstname">Nome</label>
        </div>

        <div class="input-group">
            <input type="text" id="lastname" name="lastname" value="<?php echo $array_result['cognome']?>">
            <label for="lastname">Cognome</label>
        </div>

        <div class="input-group">
            <input type="email" name="email" id="email" value="<?php echo $array_result['email']?>">
            <label for="email">Email</label>
            <div class="err-message" id="email_error"></div>
        </div>

        <button type="submit" id="submit" name="submit">Modifica</button>
    </form>
    <script src="js/registration.js"></script>
</body>
</html>