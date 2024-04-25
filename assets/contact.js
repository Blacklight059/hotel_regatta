import './bootstrap.js';

require('bootstrap-datepicker/js/bootstrap-datepicker');
require('bootstrap-datepicker/js/locales/bootstrap-datepicker.fr');
require('bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css');

import './styles/app.css';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 */

$(document).ready(function (){
    $('.input-daterange input').each(function () {
        $(this).datepicker({
            format: 'dd/mm/YYYY'
        });
    });
});
