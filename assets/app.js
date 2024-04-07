import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

const toggler = document.querySelector(".hamburger");
const navLinksContainer = document.querySelector(".navlinks-container");

const toggleNav = e => {
  // Animation du bouton
  toggler.classList.toggle("open");

  const ariaToggle =
    toggler.getAttribute("aria-expanded") === "true" ? "false" : "true";
  toggler.setAttribute("aria-expanded", ariaToggle);

  // Slide de la navigation
  navLinksContainer.classList.toggle("open");
};

toggler.addEventListener("click", toggleNav);


new ResizeObserver(entries => {
  if (entries[0].contentRect.width <= 900){
    navLinksContainer.style.transition = "transform 0.4s ease-out";
  } else {
    navLinksContainer.style.transition = "none";
  }
}).observe(document.body)

require('bootstrap-datepicker/js/bootstrap-datepicker')
require('bootstrap-datepicker/js/locales/bootstrap-datepicker.fr')
require('bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')
$(document).ready(function (){
    $('.input-daterange input').each(function () {
        $(this).datepicker({
            format: 'dd/mm/YYYY'
        });
    });
});

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
