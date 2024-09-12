/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './vendor/aurora-user-interface/dist/css/bootstrap.min.css';
import './vendor/aurora-user-interface/dist/css/colors.css';
import './vendor/aurora-user-interface/dist/css/layout.css';

import './vendor/aurora-user-interface/dist/css/accordion.css';
import './vendor/aurora-user-interface/dist/css/card.css';
import './vendor/aurora-user-interface/dist/css/editor.css';
import './vendor/aurora-user-interface/dist/css/faq.css';
import './vendor/aurora-user-interface/dist/css/forms.css';
import './vendor/aurora-user-interface/dist/css/navigation.css';
import './vendor/aurora-user-interface/dist/css/side-filter.css';
import './vendor/aurora-user-interface/dist/css/timeline.css';

import './vendor/aurora-user-interface/dist/css/custom.css';
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

const BTN_OPEN_FILTER = document.getElementById('open-filter');
const BTN_CLOSE_FILER = document.getElementById('close-filter');
const BTN_CLEAR_FILTER = document.getElementById('clear-filters');
const SIDEBAR = document.getElementById('filter-sidebar');
// const MAIN_CONTENT = document.getElementById('main-content');
const FILTER_BTN = document.getElementById('open-filter');
const TESTE = document.querySelector('.agent-list');

BTN_OPEN_FILTER.addEventListener('click', toggleSidebar);
BTN_CLOSE_FILER.addEventListener('click', toggleSidebar);
BTN_CLEAR_FILTER.addEventListener('click', clearFilters);

function toggleSidebar() {
    SIDEBAR.classList.toggle('open');
    // MAIN_CONTENT.classList.toggle('shifted');

    if (SIDEBAR.classList.contains('open')) {
        FILTER_BTN.style.visibility = 'hidden';
        FILTER_BTN.style.opacity = 0;
        return;
    }

    setTimeout(() => {
        FILTER_BTN.style.visibility = 'visible';
        FILTER_BTN.style.opacity = 1;
    }, 300);
}

function clearFilters() {
    document.getElementById('agent-name').value = '';

    ['agent-name', 'agent-type', 'areas-of-activity', 'seals', 'state', 'city'].map(item => {
        document.getElementById(item).selectedIndex = 0;
    });
}
