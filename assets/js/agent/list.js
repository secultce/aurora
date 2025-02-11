const BTN_CLEAR_FILTER = document.getElementById('clear-filters');

BTN_CLEAR_FILTER.addEventListener('click', clearFilters);

function clearFilters() {
    document.getElementById('agent-name').value = '';

    ['agent-name', 'agent-type', 'areas-of-activity', 'seals', 'state', 'city'].map(item => {
        document.getElementById(item).selectedIndex = 0;
    });

    const filters = {
        name: '',
        agentType: '',
        areasOfActivity: '',
        seals: '',
        state: '',
        city: ''
    };

    updateURLWithFilters(filters);
}


const filters = {
    name: document.getElementById('agent-name'),
    agentType: document.getElementById('agent-type'),
    areasOfActivity: document.getElementById('areas-of-activity'),
    seals: document.getElementById('seals'),
    state: document.getElementById('state'),
    city: document.getElementById('city'),
};

Object.keys(filters).forEach(key => {
    const field = filters[key];

    const eventType = field.tagName === 'INPUT' ? 'input' : 'change';

    field.addEventListener(eventType, function () {
        const value = field.value.trim();
        updateURLWithFilters({ [key]: value });
    });
});

function updateURLWithFilters(filters) {
    const url = new URL(window.location.href);

    Object.keys(filters).forEach(key => {
        const value = filters[key];
        if (value) {
            url.searchParams.set(key, value);
            return;
        }
        url.searchParams.delete(key);
    });

    history.pushState(null, '', url);
}

document.getElementById('apply-filters')
    .addEventListener('click', function () {
    window.location.reload();
});
