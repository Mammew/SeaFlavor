<?php
    session_start();
    include 'header.php';
?>
    <nav class="navbar" id="navbar">
        <a href="">Team </a> |
        <a href="">Case history </a> |
        <a href="">Contact us </a> |
        
        <?php
        if (!isset($_SESSION['email'])) {
        ?>
            <a href="login.html">Sign In </a> |
            <a href="registration.html">Sign Up </a>
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
            <h1>ciaooo</h1>
            <p>
                fdavdfjvhgagvjhadfvjhbfjhv
                vfdjvhjdvjhdfvhjbdjbvjdfav
                afvjdfjvbjhbvjhfafv
                vajbvjhfbhvbdfkvbdf
                fvhjdfhvlfdffvj
            </p>
        </div>

        <div class="service">
            <h1>mondo</h1>
            <p>
                fdavdfjvhgagvjhadfvjhbfjhv
                vfdjvhjdvjhdfvhjbdjbvjdfav
                afvjdfjvbjhbvjhfafv
                vajbvjhfbhvbdfkvbdf
                fvhjdfhvlfdffvj
            </p>
        </div>

        <div class="service">
            <h1>gay</h1>
            <p>
                fdavdfjvhgagvjhadfvjhbfjhv
                vfdjvhjdvjhdfvhjbdjbvjdfav
                afvjdfjvbjhbvjhfafv
                vajbvjhfbhvbdfkvbdf
                fvhjdfhvlfdffvj
            </p>
        </div>
    </section>

</body>
</html>