const cardsContainer = document.getElementById('cards-container');
const search = document.getElementById('search');

search.addEventListener('input', (e) => {
    const { value } = e.target;
    const cards = document.getElementsByClassName('card'); // prendo tutte le card della pagina prodotti

    Array.from(cards).forEach(card => { // creo un array di card
        // per pgni carta prendo il titolo
        const title = card.querySelector('.card-title').innerText; 
        if (title.toLowerCase().includes(value.toLowerCase())) { // controllo se il valore cercato vi è nel titolo della carta
            card.style.display = 'block';   // rendo visibile la carta
        } else {
            card.style.display = 'none';    // nascono la carta
        }
    });
});

var back_popup = document.getElementById('quantity-popup');
var closeBtn = document.querySelector('.popup .close'); // prendo il bottone per chiudere il popup

document.querySelectorAll('.add-to-cart').forEach(function(button) { //seleziono tutti i bottoni con classe 'add-to-cart'
    button.addEventListener('click', function() {
        var productId = this.getAttribute('data-product-id'); // prendo l'ID del pesce che si vuola acquistare
        //productIdInput.value = productId;
        //var quantity = quantityIn.value;
        // TODO: verifica validità ID prodotto

        back_popup.style.display = 'block';
        //console.log('valore ID::', productId);
    });
});

/* Aggiungo l'evento click al bottone per chiudere il popup */
closeBtn.addEventListener('click', function() {
    back_popup.style.display = 'none';
});

/* Chiudo il popup se l'utente clicca fuori da esso */
window.addEventListener('click', function(event) { // event listener su tutta la pagina
    // se l'utente clicca fuori dal pupup (la var back_pupup è grande quanto la finestra è lo 'sofondo' del popup)
    if (event.target == back_popup) {
        back_popup.style.display = 'none';
    }
});

document.addEventListener('keyup', (e) => {
    if (e.key === 'Escape') {
        back_popup.style.display = 'none';
    }
});

