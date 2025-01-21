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
            document.getElementById('total').innerHTML = "";

            document.querySelectorAll('.remove-from-cart').forEach(function(button){ //seleziono tutti i bottoni con classe 'remove-from-cart'
                button.addEventListener('click', function() {
                    let productId = this.getAttribute('data-product-id');
                    removeFromCart(productId);
                })
            })

            document.querySelectorAll('.add-from-cart').forEach(function(button){ //seleziono tutti i bottoni con classe 'add-from-cart'
                button.addEventListener('click', function() {
                    let productId = this.getAttribute('data-product-id');
                    addFromCart(productId);
                })
            })

            const total = document.getElementById('cart-total');
            document.getElementById('total').appendChild(total);

            // Aggiungi event listener per il bottone "Svuota carrello"
            const removeAllButton = document.querySelector('.remove-all');
            removeAllButton.addEventListener('click', function() {
                sessionStorage.removeItem('cart');
                document.getElementById('cart-content').innerHTML = "";
                document.getElementById('cart-total').innerHTML = "Totale: 0€";
            });
        })

       .catch(error => console.error('Errore:', error));
    }
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

function addFromCart (productId) {

    let cart = sessionStorage.getItem('cart');
    if (cart) {
        cart = JSON.parse(cart);
    } else {
        cart = [];
    }

    cart.forEach(product => {
        if(product.productId == productId && product.quantity >= 1){
            product.quantity = parseInt(product.quantity) + 1;
            sessionStorage.setItem('cart', JSON.stringify(cart));
            loadCart();
        }
    });
}

document.addEventListener('DOMContentLoaded', loadCart);