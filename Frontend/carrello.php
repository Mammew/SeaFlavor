<?php
    session_start();
    include 'component/header.php';
?>
    <link rel="stylesheet" type="text/css" href="css/prodotti.css">

    <div id="cart-content">
        <!-- Il contenuto del carrello sarà qui -->
    </div>

    <script>
        function loadCart() {
            let cart = sessionStorage.getItem('cart');
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
        }

        document.addEventListener('DOMContentLoaded', loadCart);
    </script>
<?php
    include 'component/footer.php';
?>