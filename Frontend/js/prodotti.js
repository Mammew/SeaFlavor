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