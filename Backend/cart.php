<?php
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart'])) {
        $_SESSION['cart'] = json_decode($_POST['cart'], true);
    }

    $conn = new mysqli('localhost', 'root', '', 'primoDB');
    if (!$conn) {
        echo "Impossible to connect to DB...";
    }

    if (isset($_SESSION["cart"])) {
        $total = 0;
        foreach ($_SESSION["cart"] as $item) {
            $productId = $item['productId'];
            $quantity = intval($item['quantity']);

            try {
                $stmt = $conn->prepare("SELECT * FROM pesci WHERE ID = ?");
                $stmt->bind_param('s', $productId);
                $stmt->execute();
                $result = $stmt->get_result();
                
                while ($row = $result->fetch_assoc()) {
                    $price_for_fish = 0;
                    $price_for_fish = $row['prezzo'] * $quantity;
                    ?>
                    <div class="card">
                        <div class="card-body">
                            <?php echo '<img src="data:image/png;base64,' . base64_encode($row['immagine']) . '" class="card-img-top" alt="Foto del pesce illustrativa del pesce: ' . $row['nome'] . '" />'; ?>
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
            } catch (mysqli_sql_exception $e) {
                error_log("Query failed: (" . $e->getMessage() . ")");
                echo "Query error...";
                exit();
            }
        }
    } else {
        echo "Il carrello è vuoto.";
    }
?>
    <div id="cart-total">
        <?php
            echo "Totale: " . $total . "€";
        ?>
    </div>
    
<?php
    $conn->close();
?>

<!--<script>
    function loadCart() {
        var cart = sessionStorage.getItem('cart');
        if (cart) {
            fetch('cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'cart=' + encodeURIComponent(cart)
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('cart-content').innerHTML = data;
            })
            .catch(error => console.error('Errore:', error));
        } else {
            document.getElementById('cart-content').innerHTML = 'Il carrello è vuoto.';
        }
    };
</script>-->
