<?php
    ini_set('display_errors', false);
    ini_set('error_log', 'file.log');
    include "createCookie.php";
    
    if (isset($_POST["email_field"]) && isset($_POST["password_field"]) && isset($_POST["remember_field"])) {
        $conn = new mysqli('localhost', 'root', '', 'prova_DB');
        if (!$conn) {
            echo "Impossible to connect to DB...";
        }
        else {
            // crea cookie
            function genToken(){
                return bin2hex(random_bytes(16));
            }
            $email = mysqli_real_escape_string($conn, $_POST["email_field"]);
            $cookieValue = genToken();
            $timestamp = time()+60;
            if (!createCookie($email,$cookieValue,$timestamp,$conn)) {
                // se cè qualche errore ritorna all'html
                header("Location: ../Frontend/login.html");
            }
            header("Location: home.php");
        }
    }
    elseif (isset($_POST["email_field"]) && isset($_POST["password_field"]) && !isset($_POST["remember_field"])) {
        $conn = new mysqli('localhost', 'root', '', 'prova_DB');
        if (!$conn) {
            echo "Impossible to connect to DB...";
        }
        else {
            
            $email = $_POST["email_field"];
            $password = $_POST["password_field"];
            
            //controllo la validita della mail
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                $conn->close();
                header("Location: ../Frontend/login.html");
                exit();
            }

            try {
                $stmt = $conn->prepare("SELECT password FROM user WHERE email = ?");
            } catch (mysqli_sql_exception $e) {
                error_log("Prepared failed: (" . $e . ")");
                echo "Query error...";
                exit();
            }
            $stmt->bind_param('s', $email);

            try {
                $stmt->execute();
            } catch (mysqli_sql_exception $e) {
                error_log("Query failed: (" . $e . ")");
                echo "Query fauled...";
                exit();
            }

            $result = $stmt->get_result();
            
            $row = $result->fetch_assoc();
            if ($row == null) {
                echo "Email not present...";
                header("Location: ../Frontend/login.html");
            }
            else{
                $passwd_control = password_verify($password,$row["password"]);
                if (!$passwd_control) {
                    $conn->close();
                    echo "password mismatch...";
                    exit();
                }
                session_start();
                $_SESSION["email_field"] = $_POST["email_field"];
                $conn->close();
                header("Location: home.php");
            }
        }
    }
    else {
        header("Location: ../Frontend/login.html");
    }
?>