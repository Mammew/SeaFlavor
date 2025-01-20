<?php
    session_start();
    if (isset($_SESSION["email"])) {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            include 'db_connection.php';

            $productId = intval($_POST['productId']);
            $rating = $_POST['rating'];
            $email = $_SESSION["email"];

            $stmt = $conn->prepare("INSERT INTO valutazioni (email, productId, rating) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE rating= ? ");

            $stmt->bind_param('siii', $email, $productId, $rating, $rating);
            try {
                $stmt->execute();
            } catch (mysqli_sql_exception $e) {
                error_log("Query failed: (" . $e . ")");
                echo "Query fauled...";
                $stmt->close();
                $conn->close();
            }
        }
    }
?>