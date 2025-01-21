document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll(".card");
    cards.forEach((card) => {
        const stars = card.querySelectorAll(".stars i");
        stars.forEach((star, index1) => {
            star.addEventListener("click", () => {
                console.log(star);
                const rating = index1 + 1; // Numero di stelline selezionate
                const productId = card.getAttribute('data-product-id'); // Assumi che ogni card abbia un attributo data-product-id
                console.log(productId);
                // Invia il numero di stelline al server
                fetch('../Backend/rating/rating.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `productId=${productId}&rating=${rating}`
                })
                .then(response => response.text())
                .then(data => {
                    console.log(data);
                })
                .catch(error => console.error('Errore:', error));

                stars.forEach((star, index2) => {
                    if (index1 >= index2) {
                        // quando clicco su una stella, tutte le stelle con indice
                        // minore o uguale a quella cliccata diventano attive e quindi diventano colorate
                        star.classList.add("active");
                    }
                    else {
                        star.classList.remove("active");
                    }
                });
            });
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    // calcolo della media della valutazioni
    fetch('../Backend/rating/average.php', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.text())
    .then(data => {
        data = JSON.parse(data); // cosi data diventa un array di oggetti
        data.forEach(item => {
            // prendo la card avente productId uguale ad item
            const card = document.querySelector(`.card[data-product-id="${item.productId}"]`);
            if (card) {
                const mediaElement = card.querySelector('.media');
                if (mediaElement) {
                    mediaElement.textContent = `Valutazione: ${item.media}`;
                }
                const stars = card.querySelectorAll('.stars i');
                const mediaValutazioni = Math.round(item.media); // arrotondamento della media
                stars.forEach((star, index) => {
                    if (index < mediaValutazioni) {
                        star.classList.add('active');
                    } else {
                        star.classList.remove('active');
                    }
                });
            }         
        });
    })
    .catch(error => console.error('Errore:', error));
});

