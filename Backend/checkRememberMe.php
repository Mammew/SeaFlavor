<?php
    session_start();
    if (!isset($_SESSION["email_field"])) {
        if(isset($_COOKIE["rememberMe"])){
            $conn = new mysqli('localhost', 'root', '', 'prova_DB');
            if (!$conn) {
                echo "Impossible to connect to DB...";
            }
            try {
                $stmt = $conn->prepare("SELECT * FROM user WHERE id_cookie = ?");
            } catch (mysqli_sql_exception $e) {
                error_log("Prepared failed: (" . $e . ")");
                echo "Query error...";
                exit();
            }

            $stmt->bind_param('s', $_COOKIE["rememberMe"]);
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
                header("Location: ../Frontend/login.html");
                exit();
            }

            //numero di righe che ritornando dalla query
            $row = $result->num_rows;
            //recupero i vari campi della query
            $array_result = $result->fetch_assoc();

            //se non ritornano righe oppure il cookie che è stato memorizzato nel database è scaduto allora salta tutto
            if ($row == 0 || strtotime($array_result["cookie_expire"]) < time()) {
                $conn->close();
                session_destroy();
                header("Location: ../Frontend/login.html");
                exit();
            }

            $_SESSION["email_field"] = $array_result["email"];
        }
        else{
            session_destroy();
            header("Location: ../Frontend/login.html");
        }
    }
?>