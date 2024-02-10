document.addEventListener('DOMContentLoaded', function() {
    let stars = document.querySelectorAll('.rating-stars .fa');
    let ratingInput = document.getElementById('inputRating');
    let currentRating = 1;

    updateStars(currentRating);
    ratingInput.value = currentRating;

    stars.forEach(function(star) {
        star.addEventListener('mouseover', function() {
            updateStars(this.getAttribute('data-value'));
        });

        star.addEventListener('mouseout', function() {
            updateStars(currentRating);
        });

        star.addEventListener('click', function() {
            currentRating = this.getAttribute('data-value');
            ratingInput.value = currentRating;
        });
    });

    function updateStars(rating) {
        stars.forEach(function(star) {
            if (parseInt(star.getAttribute('data-value')) <= rating) {
                star.classList.add('fa-solid');
                star.classList.remove('fa-regular');
            } else {
                star.classList.remove('fa-solid');
                star.classList.add('fa-regular');
            }
        });
    }
});
