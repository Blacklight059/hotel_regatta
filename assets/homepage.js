import './bootstrap.js';
import './star-rating.js';
import './star-rating.min.js';

require('bootstrap-datepicker/js/bootstrap-datepicker');
require('bootstrap-datepicker/js/locales/bootstrap-datepicker.fr');
require('bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css');

import './styles/app.css';
import './styles/star-rating.css';

// Sélectionner l'élément parent des avis
var reviewsContainer = document.getElementById('reviews');

// Durée de l'animation (en millisecondes)
var animationDuration = 1000;

// Fonction pour déplacer les avis
function scrollReviews() {
    // Sélectionner le premier avis
    var firstReview = reviewsContainer.children[0];

    // Calculer la largeur d'un seul avis
    var reviewWidth = firstReview.offsetWidth;

    // Animer le défilement
    reviewsContainer.style.transition = 'transform ' + animationDuration + 'ms ease-in-out';
    reviewsContainer.style.transform = 'translateX(-' + reviewWidth + 'px)'; // Déplacer vers la gauche

    // Remettre le premier avis à la fin de la liste après l'animation
    setTimeout(function() {
        reviewsContainer.appendChild(firstReview);
        reviewsContainer.style.transition = 'none'; // Réinitialiser la transition
        reviewsContainer.style.transform = 'translateX(0)'; // Réinitialiser la position
    }, animationDuration);
}

// Appeler la fonction scrollReviews toutes les quelques secondes (par exemple, toutes les 5 secondes)
setInterval(scrollReviews, 5000); // Définir l'intervalle de temps en millisecondes

document.addEventListener("DOMContentLoaded", function(event) {
    var reviews = document.querySelectorAll('.fade-in');
    reviews.forEach(function(review) {
        review.classList.add('show');
    });
});
  
document.addEventListener("DOMContentLoaded", function(event) {
    var reviews = document.querySelectorAll('.fade-in');
    reviews.forEach(function(review) {
        review.classList.add('show');
    });
});