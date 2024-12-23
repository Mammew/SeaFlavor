<?php
    ini_set('display_errors', false);
    ini_set('error_log', 'php.log');

    if (isset($_POST["email_field"]) && isset($_POST["password_field"]) && isset($_POST["submit"])) {

        // da cambiare le credenziali
        $conn = new mysqli('localhost', 'root', '', 'prova_DB');
        if (!$conn) {
            echo "Impossible to connect to DB...";
        }
        else {

            $nome = $_POST["firstname_field"];
            $cognome = $_POST["lastname_field"];
            $email = $_POST["email_field"];
            $password = $_POST["password_field"];
            
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                $conn->close();
                header("Location: ../Frontend/registration.html");
                exit();
            }

            $passwd = password_hash($password, PASSWORD_DEFAULT);

            try {
                $stmt = $conn->prepare("INSERT INTO user (nome,cognome,email,password) VALUE (?,?,?,?)");
            } catch (mysqli_sql_exception $e) {
                error_log("Prepared failed: (" . $e . ")");
                echo "Query error...";
                exit();
            }

            $stmt->bind_param('sss', $nome, $cognome, $email, $passwd);
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
                header("Location: ../Frontend/registration.html");
                exit();
            }
            else{
                echo "User registered correctly";
                $conn->close();
                header("Location: ../Frontend/login.html");

            }
        }
    }
    else {
        header("Location: ../Frontend/registration.html");
    }
?>