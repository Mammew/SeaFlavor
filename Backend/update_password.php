<?php
    session_start();
    if (isset($_SESSION["email"]) && isset($_POST["submit"])) {
        $old_password = $_POST['current_password'];
        $new_password = $_POST['confirm'];
        $email = $_SESSION["email"];
        
        $conn = new mysqli('localhost', 'root', '', 'primoDB');
        if (!$conn) {
            echo "Impossible to connect to DB...";
        }
        else {
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
            $passwd_control = password_verify($old_password,$row["passd"]);
            if (!$passwd_control) {
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
                    exit();
                }

                $stmt->bind_param('ss', $password,$email);
                try {
                    $stmt->execute();
                } catch (mysqli_sql_exception $e) {
                    error_log("Query failed: (" . $e . ")");
                    echo "Query fauled...";
                    return false;
                }
                header("Location: ../Frontend/home.php");
            }
        }
    }
    else
        header("Location: ../Frontend/home.php");
?>