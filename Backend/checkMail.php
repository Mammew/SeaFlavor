<?php
    if (isset($_POST["email"])) {
        $conn = new mysqli('localhost', 'root', '', 'primoDB');
        
        include 'db_connection.php';
        
        $email = $_POST["email"];
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $conn->close();
            exit();
        }

        try {
            $stmt = $conn->prepare("SELECT email FROM utenti WHERE email = ?");
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
        if (mysqli_stmt_errno($stmt) != 0) {
            echo "Something went wrong...";
            $stmt->close();
            $conn->close();
        }
        else{
            $row = $result->num_rows;
            echo "$row";
            $stmt->close();
            $conn->close();
        }
    }
?>