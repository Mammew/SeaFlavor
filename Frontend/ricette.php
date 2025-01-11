<?php
    include 'component/header.php';
    $conn = new mysqli('localhost', 'root', '', 'primoDB');
    if (!$conn) {
        echo "Impossible to connect to DB...";
    }

    try {
        $stmt = $conn->prepare("SELECT * FROM ricette");
    } catch (mysqli_sql_exception $e) {
        error_log("Prepared failed: (" . $e . ")");
        echo "Query error...";
        exit();
    }
    
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
        exit();
    }
?>
    <link rel="stylesheet" type="text/css" href="css/prodotti.css">
    <br><br>
    <div id="search-container">
        <input type="search" id="search" placeholder="Cerca una ricetta...">
    </div>
    
    <div class="cards-container">
        <?php
            while ($row = $result->fetch_assoc()) {
        ?>
        <!--<div class="col-md-4">-->
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <?php echo $row['nome']; ?>
                    </div>
                    <?php echo $row['descrizione']; ?>
                </div>
            </div>
        <!--</div>-->
        <?php
            }
        ?>
    </div>
    
    <br><br>
    
<?php
    include 'component/footer.php';
?>

