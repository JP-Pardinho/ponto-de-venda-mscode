import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';

import { startStimulusApp } from '@symfony/stimulus-bundle';
const app = startStimulusApp();


import pdvController from './controllers/pdv_controller';
app.register('pdv', pdvController);

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
