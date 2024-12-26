<?php
    //ini_set('display_errors', false);
    //ini_set('error_log', 'file.log');
    include "checkRememberMe.php";
    include "createCookie.php";
    
    if (isset($_POST["email"]) && isset($_POST["pass"]) && isset($_POST["remember_me"])) {
        $conn = new mysqli('localhost', 'root', '', 'primoDB');
        if (!$conn) {
            echo "Impossible to connect to DB...";
        }
        else {
            // crea cookie
            function genToken(){
                return bin2hex(random_bytes(16));
            }
            $email = mysqli_real_escape_string($conn, $_POST["email"]);
            $cookieValue = genToken();
            $timestamp = time()+60;
            if (!createCookie($email,$cookieValue,$timestamp,$conn)) {
                // se cè qualche errore ritorna all'html
                header("Location: ../Frontend/login.html");
            }
            
            session_start();
            $_SESSION["email"] = $_POST["email"];
            $conn->close();
            header("Location: ../Frontend/home.php");
        }
    }
    elseif (isset($_POST["email"]) && isset($_POST["pass"]) && !isset($_POST["remember_me"])) {
        $conn = new mysqli('localhost', 'root', '', 'primoDB');
        if (!$conn) {
            echo "Impossible to connect to DB...";
        }
        else {
            
            $email = $_POST["email"];
            $password = $_POST["pass"];
            
            //controllo la validita della mail
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                $conn->close();
                header("Location: ../Frontend/login.html");
                exit();
            }

            try {
                $stmt = $conn->prepare("SELECT passd FROM utenti WHERE email = ?");
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
                $passwd_control = password_verify($password,$row["passd"]);
                if (!$passwd_control) {
                    $conn->close();
                    echo "password mismatch...";
                    exit();
                }
                session_start();
                $_SESSION["email"] = $_POST["email"];
                $conn->close();
                header("Location: ../Frontend/home.php");
            }
        }
    }
    else {
        header("Location: ../Frontend/login.html");
    }
?>