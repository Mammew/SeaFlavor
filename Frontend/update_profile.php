<?php
    session_start();
    if (isset($_SESSION["email"]) && isset($_POST["submit"])) {
        $new_firstname = $_POST['firstname'];
        $new_lastname = $_POST['lastname'];
        $new_email = $_POST['email'];

        $conn = new mysqli('localhost', 'root', '', 'primoDB');
        if (!$conn) {
            echo "Impossible to connect to DB...";
        }

        try {
            $stmt = $conn->prepare("UPDATE utenti SET nome = ?,cognome = ?,email = ? WHERE email = ?");
        } catch (mysqli_sql_exception $e) {
            error_log("Prepared failed: (" . $e . ")");
            echo "Query error...";
            exit();
        }

        $stmt->bind_param('ssss', $new_firstname,$new_lastname,$new_email,$_SESSION["email"]);
        try {
            $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            error_log("Query failed: (" . $e . ")");
            echo "Query fauled...";
            return false;
        }
        header("Location: home.php");
    }
    else
        header("Location: home.php");
?>