<?php
    session_start();
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
        $stmt->close();
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
    <link rel="stylesheet" type="text/css" href="css/valutazione.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <br><br>
    <!--<div id="search-container">
        <input type="search" id="search" placeholder="Cerca una ricetta...">
    </div>-->
    
    <div class="cards-container">
        <?php
            while ($row = $result->fetch_assoc()) {
        ?>
        <!--<div class="col-md-4">-->
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <?php echo '<img src="data:image/png;base64,' . base64_encode($row['immagine']) . '" class="card-img-top" alt="Foto illustrativa della ricetta: ' . $row['nome'] . '" />'; ?>
                        <?php echo $row['nome']; ?>
                        <?php if (isset($_SESSION['email'])) { ?>
                            <div class="rating-box">
                                <div class="stars">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <!--</div>-->
        <?php
            }
        ?>
    </div>
    <script src="js/valutazione.js"></script>
    <br><br>
    
<?php
    include 'component/footer.php';
?>

