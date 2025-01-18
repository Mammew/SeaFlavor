const cards = document.querySelectorAll(".card");
cards.forEach((card) => {
    const stars = card.querySelectorAll(".stars i");
    stars.forEach((star, index1) => {
        star.addEventListener("click", () => {
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

