<?php
    $conn = new mysqli('localhost', 'root', '', 'primoDB');
    if (!$conn) {
        echo "Impossible to connect to DB...";
    }
?>