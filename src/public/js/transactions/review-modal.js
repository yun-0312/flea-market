document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("review-modal");
    const overlay = document.getElementById("modal-overlay");

    if (modal && overlay) {
        overlay.classList.add("is-active");
        modal.classList.add("is-active");
    }
});

document.addEventListener("DOMContentLoaded", () => {
    const stars = document.querySelectorAll(".star");
    const ratingInput = document.getElementById("rating-value");

    stars.forEach((star) => {
        star.addEventListener("click", () => {
            const value = Number(star.dataset.value);
            ratingInput.value = value;

            stars.forEach((s) => {
                const starValue = Number(s.dataset.value);
                s.classList.toggle("is-active", starValue <= value);
            });
        });
    });
});