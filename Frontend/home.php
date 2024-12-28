<?php
    session_start();
    include 'header.php';
?>
    <br><br><br>
    <link rel="stylesheet" type="text/css" href="css/home.css">
    <nav class="navbar" id="navbar">
        <a href="">rrr </a> |
        <a href="">fff </a> |
        <a href="pesca-ligure.php">Pescatori Liguri </a> |
        
        <?php
        if (!isset($_SESSION['email'])) {
        ?>
            <a href="login.html">Accedi</a> |
            <a href="registration.html">Registrati</a>
        <?php
        } else{
        ?>
            <a class="logout" href="../Backend/logout.php">Esci</a>
        <?php
        }
        ?>
    </nav>

    <section class="services">
        <div class="service">
            <h1>Noi</h1>
            <p>
                In SeaFlavour, la nostra passione è il Mar Ligure e la sua ricchezza.<br>
                Ci impegniamo a promuovere una pesca sostenibile, che preservi l'ecosistema marino e offra al contempo pesce fresco e di alta qualità. 
                Portiamo il meglio del pescato ligure direttamente nelle vostre case, condividendo la storia e la tradizione di un territorio unico.
            </p>
            <a href="">Scopri di piu </a>
        </div>

        <div class="service">
            <h1>Prodotti</h1>
            <p>
                Ogni giorno, i pescatori liguri solcano il mare per portare a casa un tesoro di freschezza.<br>
                Da noi trovi il loro pescato migliore, frutto di una pesca sostenibile che rispetta i ritmi della natura. 
                E per chi ama il mare, offriamo prodotti per una pesca più responsabile.
            </p>
            <a href="prodotti.php">Scopri di piu </a>
        </div>

        <div class="service">
            <h1>Cucina</h1>
            <p>
                Esplora un viaggio culinario tra le ricette di pesce della Liguria, 
                dalle preparazioni più semplici e gustose come il pesce al forno alla ligure a creazioni più elaborate che sapranno stupire i tuoi ospiti.
            </p>
            <a href="cucina.php">Scopri di piu </a>
        </div>
    </section>

<?php
    include 'footer.php';
?>