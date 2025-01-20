<?php
    session_start();
    include 'component/header.php';

    include '../Backend/db_connection.php';

    try {
        $stmt = $conn->prepare("SELECT * FROM pesci");
    } catch (mysqli_sql_exception $e) {
        error_log("Prepared failed: (" . $e . ")");
        echo "Query error...";
        $conn->close();
        exit();
    }
    
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

    if (mysqli_stmt_errno($stmt) != 0) {
        echo "Something went wrong...";
        $stmt->close();
        $conn->close();
        exit();
    }

    $stmt->close();
    $conn->close();
?>
    <link rel="stylesheet" type="text/css" href="css/prodotti.css">
    <br><br>
    <div id="search-container">
        <input type="search" id="search" placeholder="Cerca un pesce...">
    </div>
    
    <div class="cards-container">
        <?php
            while ($row = $result->fetch_assoc()) {
        ?>
            <div class="card">
                <div class="card-body">
                <?php echo '<img src="data:image/png;base64,' . base64_encode($row['immagine']) . '" class="card-img-top" alt="Foto del pesce illustrativa del pesce: ' . $row['nome'] . '" />'; ?>
                <div class="card-title">
                    <?php echo $row['nome']; ?>
                </div>
                    <?php echo $row['descrizione']; ?>
                    <p id="price"> <?php echo $row['prezzo']; ?>€/kg</p>
                </div>
                <?php
                    if (isset($_SESSION['email'])) {
                ?>
                <div class="quantity-container">
                    <p id="text">Quantità(kg):</p>
                    <input type="number" id="quantity_<?php echo $row['ID']; ?>" name="quantity" min="1" value="1"><br>
                    <button class="btn btn-primary add-to-cart" data-product-id="<?php echo $row['ID']; ?>">Aggiungi al carrello</button>
                </div>
                <?php
                    }
                ?>
            </div>
        <?php
            }
        ?>
    </div>
    <div id="quantity-popup" class="popup">
        <div class="popup-content">
            <span class="close">&times;</span>
            <h3>Prodotto aggiunto al carrello correttamente</h3>
        </div>
    </div>
    
    <br><br>
    
    <script src="js/product.js"></script>
    <script src="js/add_item_cart.js"></script>

<?php
    include 'component/footer.php';
?>

