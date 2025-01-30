const BTN_OPEN_FILTER = document.getElementById('open-filter');
const BTN_CLOSE_FILER = document.getElementById('close-filter');
const BTN_CLEAR_FILTER = document.getElementById('clear-filters');
const SIDEBAR = document.getElementById('filter-sidebar');
const MAIN_CONTENT = document.querySelector('.entity-container');
const ENTITY_WRAPPER = document.querySelector('.entity-wrapper');
const FORM_FILTER_SIDEBAR = document.getElementById('filter-sidebar');

BTN_OPEN_FILTER.addEventListener('click', toggleSidebar);
BTN_CLOSE_FILER.addEventListener('click', toggleSidebar);

function toggleSidebar() {
    SIDEBAR.classList.toggle('open');
    MAIN_CONTENT.classList.toggle('shifted');
    ENTITY_WRAPPER.classList.toggle('open');

    if (SIDEBAR.classList.contains('open')) {
        BTN_OPEN_FILTER.style.visibility = 'hidden';
        BTN_OPEN_FILTER.style.opacity = 0;
        return;
    }

    setTimeout(() => {
        BTN_OPEN_FILTER.style.visibility = 'visible';
        BTN_OPEN_FILTER.style.opacity = 1;
    }, 300);
}


FORM_FILTER_SIDEBAR.addEventListener('submit', function (event) {
    event.preventDefault();

    const formData = new FormData(FORM_FILTER_SIDEBAR);
    const params = new URLSearchParams();

    formData.forEach((value, key) => {
        if (value.trim() !== "") {
            params.append(key, value.trim());
        }
    });

    window.location.href = `${window.location.pathname}?${params.toString()}`;
});
