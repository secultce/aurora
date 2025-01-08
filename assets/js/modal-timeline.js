function openModal(from, to) {
    const modalBody = document.getElementById('modal-timeline-table-body');
    modalBody.innerHTML = '';

    Object.keys(to).forEach(field => {
        const row = createRow(field, from[field], to[field]);
        modalBody.appendChild(row);
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
    if (value == null) {
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
