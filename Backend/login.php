<?php
    include "../Backend/createCookie.php";
    
    if (isset($_POST["email"]) && isset($_POST["pass"]) && isset($_POST["remember_me"])) {

        include 'db_connection.php';

        // crea cookie
        function genToken(){
            return bin2hex(random_bytes(16));
        }
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $cookieValue = genToken();
        $timestamp = time()+60;

        if (!createCookie($email,$cookieValue,$timestamp,$conn)) {
            $stmt->close();
            $conn->close();
            header("Location: ../Frontend/login.html");
        }

        $stmt->close();
        $conn->close();
        header("Location: ../Frontend/home.php");
    }
    elseif (isset($_POST["email"]) && isset($_POST["pass"]) && !isset($_POST["remember_me"])) {
        
        include 'db_connection.php';
            
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
            //error_log("Prepared failed: (" . $e . ")");
            echo "Query error...";
            $conn->close();
            exit();
        }

        $stmt->bind_param('s', $email);
        try {
            $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            //error_log("Query failed: (" . $e . ")");
            echo "Query fauled...";
            $stmt->close();
            $conn->close();
            exit();
        }
        
        $result = $stmt->get_result();
        
        $row = $result->fetch_assoc();
        if ($row == null) {
            echo "Email not present...";
            $stmt->close();
            $conn->close();
            header("Location: ../Frontend/login.html");
        }
        else{
            $passwd_control = password_verify($password,$row["passd"]);
            if (!$passwd_control) {
                $stmt->close();
                $conn->close();
                header("Location: login.php");
                exit();
            }
            session_start();
            $_SESSION["email"] = $_POST["email"];
            $stmt->close();
            $conn->close();
            header("Location: ../Frontend/home.php");
        }
    }
    else {
        header("Location: ../Frontend/login.html");
    }
?>