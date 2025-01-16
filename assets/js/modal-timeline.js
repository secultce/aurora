const MODAL_BODY = document.getElementById('modal-timeline-table-body');

function openModal(from, to, extraInfo) {
    console.log(extraInfo);

    MODAL_BODY.innerHTML = '';
    populateExtraInfo(extraInfo);

    Object.keys(to).forEach(field => {
        const row = createRow(field, from[field], to[field]);
        MODAL_BODY.appendChild(row);
    });
}

function createRow(field, fromValue, toValue) {
    const row = document.createElement('tr');
    row.innerHTML = `
        <td>${field}</td>
        <td>${formatValue(fromValue)}</td>
        <td>${formatValue(toValue)}</td>
    `;
    return row;
}

function formatValue(value) {
    if (value == null || (Array.isArray(value) && value.length === 0)) {
        return 'N/A';
    }

    if (typeof value === 'object' && value.id && value.name) {
        return `${value.name} <br> ID: ${value.id}`;
    }

    if (typeof value === 'object') {
        return formatExtraFields(value);
    }

    return String(value);
}

function formatExtraFields(obj) {
    return Object.entries(obj)
        .map(([key, value]) => `<strong>${key}:</strong> ${formatValue(value)}`)
        .join('<br>');
}

function populateExtraInfo(extraInfo) {
    const { author, datetime, device, platform, title } = extraInfo;
    const name = author.socialName ? author.socialName : `${author.firstname} ${author.lastname}`;

    document.getElementById('author-image').src = author.image;
    document.getElementById('author-name').textContent = name;
    document.getElementById('author-email').textContent = author.email;
    document.getElementById('device').textContent = device;
    document.getElementById('platform').textContent = platform;
    document.getElementById('datetime').textContent = new Date(datetime * 1000).toLocaleString();
    document.getElementById('title').textContent = title;
    document.getElementById('alert-author-name').textContent = name;
}
