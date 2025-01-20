<?php
    include '../db_connection.php';

    try {
        $stmt = $conn->prepare("SELECT productId, AVG(rating) FROM valutazioni GROUP BY productId");
    } catch (mysqli_sql_exception $e) {
        error_log("Prepared failed: (" . $e . ")");
        echo "Query error...";
        $stmt->close();
        $conn->close();
        exit();
    }

    $average_result = $stmt->get_result();
    $average_rows = $average_result->fetch_assoc();
?>