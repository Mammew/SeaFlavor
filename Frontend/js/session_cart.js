let cart = [];

document.querySelectorAll('.add-to-cart').forEach(function(button){ //seleziono tutti i bottoni con classe 'add-to-cart'
        button.addEventListener('click', function() {
        let productId = this.getAttribute('data-product-id');
        addToCart(productId);
    })
})
const addToCart = (productId) => {
    let cart = sessionStorage.getItem('cart');
    if (cart) {
        cart = JSON.parse(cart);
    } else {
        cart = [];
    }

    let positionThisProductInCart = cart.findIndex((value) => value.productId == productId);
    if(positionThisProductInCart < 0){
        cart.push({
            productId: productId,
            quantity: 1
        });
    }else{
        cart[positionThisProductInCart].quantity = cart[positionThisProductInCart].quantity + 1;
    }
    sessionStorage.setItem('cart', JSON.stringify(cart));
    console.log('Carrello aggiornato:', cart);

}
