<?php
    //ini_set('display_errors', false);
    //ini_set('error_log', 'php.log');

    if (isset($_POST["firstname"]) && isset($_POST["lastname"]) && isset($_POST["email"]) && isset($_POST["pass"]) && isset($_POST["submit"])) {

        // da cambiare le credenziali
        $conn = new mysqli('localhost', 'root', '', 'primoDB');
        if (!$conn) {
            echo "Impossible to connect to DB...";
        }
        else {

            $nome = $_POST["firstname"];
            $cognome = $_POST["lastname"];
            $email = $_POST["email"];
            $password = $_POST["pass"];
            
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                $conn->close();
                header("Location: registration.html");
                exit();
            }

            $passwd = password_hash($password, PASSWORD_DEFAULT);

            try {
                $stmt = $conn->prepare("INSERT INTO utenti (nome,cognome,email,passd) VALUE (?,?,?,?)");
            } catch (mysqli_sql_exception $e) {
                error_log("Prepared failed: (" . $e . ")");
                echo "Query error...";
                exit();
            }

            $stmt->bind_param('ssss', $nome, $cognome, $email, $passwd);
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
                header("Location: registration.html");
                exit();
            }
            else{
                echo "User registered correctly";
                $conn->close();
                header("Location: login.html");

            }
        }
    }
    else {
        header("Location: registration.html");
    }
?>