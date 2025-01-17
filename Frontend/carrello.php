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
                fetch('../Backend/cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'cart=' + encodeURIComponent(cart)
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('cart-content').innerHTML = data;
                    
                    document.querySelectorAll('.remove-from-cart').forEach(function(button){ //seleziono tutti i bottoni con classe 'remove-from-cart'
                        button.addEventListener('click', function() {
                            let productId = this.getAttribute('data-product-id');
                            removeFromCart(productId);
                        })
                    })
                })
                .catch(error => console.error('Errore:', error));
            } else {
                document.getElementById('cart-content').innerHTML = 'Il carrello è vuoto.';
            }
            //console.log(cart);
        }

        function removeFromCart (productId) {
            let cart = sessionStorage.getItem('cart');
            if (cart) {
                cart = JSON.parse(cart);
            } else {
                cart = [];
            }

            cart.forEach(product => {
                if(product.productId == productId && product.quantity > 1){
                    product.quantity -= 1;
                    sessionStorage.setItem('cart', JSON.stringify(cart));
                    loadCart();
                }
                else if(product.productId === productId && product.quantity == 1){
                    // filtro gli item di cart e tengo item se item.productId !== productId
                    // la funz => .. ritorna true o false
                    cart = cart.filter(item => item.productId !== productId);
                    sessionStorage.setItem('cart', JSON.stringify(cart));
                    loadCart();
                }
            });
        }

        document.addEventListener('DOMContentLoaded', loadCart);
    </script>
<?php
    include 'component/footer.php';
?>