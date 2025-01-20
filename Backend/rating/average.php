<?php
    header('Content-Type: application/json');
    include '../db_connection.php';

    try {
        $stmt = $conn->prepare("SELECT productId, AVG(rating) AS media FROM valutazioni GROUP BY productId");
    } catch (mysqli_sql_exception $e) {
        error_log("Prepared failed: (" . $e . ")");
        echo "Query error...";
        $stmt->close();
        $conn->close();
        exit();
    }
    try {
        $stmt->execute();
        $average_result = $stmt->get_result();
        $average_rows = $average_result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($average_rows);
    } catch (mysqli_sql_exception $e) {
        error_log("Query failed: (" . $e->getCode() . ")");
        echo json_encode(['error' => 'Query error']);
        $stmt->close();
        $conn->close();
        exit();
    }
?>
