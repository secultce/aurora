import {getLocale} from "@symfony/ux-translator";
import AirDatepicker from 'air-datepicker';
const datepickerLocale = await import('air-datepicker/locale/'+getLocale()+'.js');

const BTN_OPEN_FILTER = document.getElementById('open-filter');
const BTN_CLOSE_FILER = document.getElementById('close-filter');
const SIDEBAR = document.getElementById('filter-sidebar');
const MAIN_CONTENT = document.querySelector('.entity-container');
const ENTITY_WRAPPER = document.querySelector('.entity-wrapper');
const FORM_FILTER_SIDEBAR = document.getElementById('filter-sidebar');
const ORDER_SELECT = document.getElementById('order-select');
const PERIOD_SELECT = document.getElementById('period');
const BTN_APPLY_PERIOD_FILTER = document.getElementById('apply-period-filter');

BTN_OPEN_FILTER.addEventListener('click', toggleSidebar);
BTN_CLOSE_FILER.addEventListener('click', toggleSidebar);

function toggleSidebar() {
    SIDEBAR.classList.toggle('open');
    MAIN_CONTENT.classList.toggle('shifted');
    ENTITY_WRAPPER.classList.toggle('open');

    if (SIDEBAR.classList.contains('open')) {
        BTN_OPEN_FILTER.style.visibility = 'hidden';
        BTN_OPEN_FILTER.style.opacity = '0';
        return;
    }

    setTimeout(() => {
        BTN_OPEN_FILTER.style.visibility = 'visible';
        BTN_OPEN_FILTER.style.opacity = '1';
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

ORDER_SELECT.addEventListener('change', () => {
    const orderValue = ORDER_SELECT.value;

    const url = new URL(window.location.href);
    const params = url.searchParams;

    params.set('order', orderValue);

    window.location.href = `${window.location.pathname}?${params.toString()}`;
});

const datepicker = new AirDatepicker(document.getElementById('datepicker'), {
    range: true,
    multipleDates: true,
    locale: await datepickerLocale.default.default,
    onSelect: function ({ date, formattedDate }) {
        const customPeriod = document.querySelector('#period option[data-name=custom]');
        customPeriod.classList.remove('d-none');
        customPeriod.innerText = formattedDate.join(' - ');

        customPeriod.value = date.map(d => `${d.getFullYear()}-${(d.getMonth()+1).toString().padStart(2, '0')}-${d.getDate()}`).join(',');
        customPeriod.selected = 'selected';
    },
});

PERIOD_SELECT.addEventListener('change', function () {
    datepicker.clear({silent: true});
    const customPeriod = document.querySelector('#period option[data-name=custom]');
    customPeriod.classList.add('d-none');
    customPeriod.innerText = '';
});

BTN_APPLY_PERIOD_FILTER.addEventListener('click', function () {
    const period = PERIOD_SELECT.value;
    const url = new URL(window.location.href);

    url.searchParams.set('period', period);

    window.location.href = url.toString();
});

(function () {
    const searchParams = new URLSearchParams(window.location.search);

    new FormData(FORM_FILTER_SIDEBAR).forEach(function (value, key) {
        const element = FORM_FILTER_SIDEBAR.querySelector(`[name=${key}]`);
        if (element) {
            element.value = searchParams.get(key);
        }
    });

    if ('' === PERIOD_SELECT.value) {
        const period = searchParams.get('period');
        if (period) {
            const customPeriod = document.querySelector('#period option[data-name=custom]');
            customPeriod.value = period;
            customPeriod.selected = 'selected';
            customPeriod.innerText = period.split(',').join(' - ');
        }
    }
})();
