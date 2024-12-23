<?php
    if (isset($_POST["email_field"])) {
        $conn = new mysqli('localhost', 'root', '', 'prova_DB');
        if (!$conn) {
            echo "Impossible to connect to DB...";
        }
        else {
            $email = $_POST["email_field"];
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                $conn->close();
                exit();
            }

            try {
                $stmt = $conn->prepare("SELECT email FROM user WHERE email = ?");
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
            if (mysqli_stmt_errno($stmt) != 0) {
                echo "Something went wrong...";
                $stmt->close();
            }
            else{
                $row = $result->num_rows;
                echo "$row";
                $conn->close();
            }
        }
    }
?>