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
            fetch('../Backend/rating.php', {
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

