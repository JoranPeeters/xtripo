/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import '.././styles/app.css';

import './mode/themeSwitcher.js';

//import './js/vehicle/vehicle-models.js';

/* Google Maps */
import './googleMaps/demo';
import './googleMaps/roadtripConfigurator';

console.log('app.js loaded! 🎉');

