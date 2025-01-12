<?php
    session_start();
    include 'component/header.php';
?>

<?php
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
            $quantity = $item['quantity'];

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
    echo "Totale: " . $total . "€";
    $conn->close();

    /*try {
        $stmt = $conn->prepare("SELECT * FROM pesci where ID = ?");
    } catch (mysqli_sql_exception $e) {
        error_log("Prepared failed: (" . $e . ")");
        echo "Query error...";
        exit();
    }
    
    $stmt->bind_param('s', $valoreRicevuto);
    try {
        $stmt->execute();
    } catch (mysqli_sql_exception $e) {
        error_log("Query failed: (" . $e . ")");
        echo "Query fauled...";
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
    }*/
?>
<script>
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
</script>
<?php
    include 'component/footer.php';
?>
<link rel="stylesheet" type="text/css" href="css/prodotti.css">
