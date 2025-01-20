<?php
    session_start();
    if (isset($_SESSION["email"]) && isset($_POST["submit"])) {
        $old_password = $_POST['current_password'];
        $new_password = $_POST['confirm'];
        $email = $_SESSION["email"];
        
        include 'db_connection.php';

        try {
            $stmt = $conn->prepare("SELECT passd FROM utenti WHERE email = ?");
        } catch (mysqli_sql_exception $e) {
            error_log("Prepared failed: (" . $e . ")");
            echo "Query error...";
            $conn->close();
            exit();
        }
        $stmt->bind_param('s', $email);
        try {
            $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            error_log("Query failed: (" . $e . ")");
            echo "Query fauled...";
            $stmt->close();
            $conn->close();
            exit();
        }
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $passwd_control = password_verify($old_password,$row["passd"]);
        if (!$passwd_control) {
            $stmt->close();
            $conn->close();
            header("Location: ../Frontend/home.php");
            exit();
        }
        else{
            $password = password_hash($new_password, PASSWORD_DEFAULT);
            try {
                $stmt = $conn->prepare("UPDATE utenti SET passd = ? WHERE email = ?");
            } catch (mysqli_sql_exception $e) {
                error_log("Prepared failed: (" . $e . ")");
                echo "Query error...";
                $stmt->close();
                $conn->close();
                exit();
            }
            $stmt->bind_param('ss', $password,$email);
            try {
                $stmt->execute();
            } catch (mysqli_sql_exception $e) {
                error_log("Query failed: (" . $e . ")");
                echo "Query fauled...";
                $stmt->close();
                $conn->close();
                return false;
            }
            $stmt->close();
            $conn->close();
            header("Location: ../Frontend/home.php");
        }
    }
    else
        header("Location: ../Frontend/home.php");
?>