<?php
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart'])) {
        $_SESSION['cart'] = json_decode($_POST['cart'], true);
    }

    include 'db_connection.php';
    
    if (isset($_SESSION["cart"])) {
        $total = 0;
        foreach ($_SESSION["cart"] as $item) {
            $productId = $item['productId'];
            $quantity = intval($item['quantity']);

            try {
                $stmt = $conn->prepare("SELECT * FROM pesci WHERE ID = ?");
            } catch (mysqli_sql_exception $e) {
                error_log("Prepared failed: (" . $e . ")");
                echo "Query error...";
                $conn->close();
                exit();
            }
            $stmt->bind_param('s', $productId);
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
            
            while ($row = $result->fetch_assoc()) {
                $price_for_fish = 0;
                $price_for_fish = $row['prezzo'] * $quantity;
                ?>
                <div class="card">
                    <div class="card-body">
                        <?php echo '<img src="data:image/png;base64,' . base64_encode($row['immagine']) . '" class="card-img-top" alt="Foto illustrativa del pesce: ' . $row['nome'] . '" />'; ?>
                        <div class="card-title">
                                <?php echo $row['nome'] .": " .$quantity."kg"?> <br>
                                <?php echo "Prezzo: " . $price_for_fish . "€"; ?>
                                <div id="cart-button-container">
                                    <button class="btn btn-primary add-from-cart" data-product-id="<?php echo $row['ID']; ?>">Aggiungi 1 Kg</button>
                                    <button class="btn btn-primary remove-from-cart" data-product-id="<?php echo $row['ID']; ?>">Rimuovi 1 Kg</button>
                                </div>
                        </div>
                    </div>
                </div>
<?php
                $total += $price_for_fish;
            }
        }
    }
?>
    <div id="cart-total">
        <div id="total-container">
            <?php
                echo "Totale: " . $total . "€";
            ?>
        </div>
        <div id="cart-button-container">
            <button class="btn btn-primary remove-all" >Svuota carello</button>
        </div>
    </div>
    
<?php
    $stmt->close();
    $conn->close();
?>
