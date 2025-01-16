import {
    trans,
    THE_RESOURCE_WAS_CREATED,
    THE_RESOURCE_WAS_UPDATED,
    THE_RESOURCE_WAS_DELETED,
} from "../translator.js";

const MODAL_BODY = document.getElementById('modal-timeline-table-body');
const EXTRA_INFO = document.getElementById('modal-timeline-extra-info');
const FIELDS = {
    authorName: document.getElementById('author-name'),
    authorEmail: document.getElementById('author-email'),
    device: document.getElementById('device'),
    platform: document.getElementById('platform'),
    datetime: document.getElementById('datetime'),
    title: document.getElementById('title'),
    alertAuthorName: document.getElementById('alert-author-name')
};

function openModal(item) {
    const {from, to, author } = item;

    MODAL_BODY.innerHTML = '';

    if (null === author) {
        EXTRA_INFO.style.display = 'none';
    }

    if (author) {
        populateExtraInfo(item);
        EXTRA_INFO.style.display = 'block';
    }

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

function formatDateTime(dateTimeObj) {
    const dateStr = dateTimeObj.date;
    const date = new Date(dateStr);
    return date.toLocaleString();
}

function populateExtraInfo(item) {
    clearFields();

    const { author, datetime, device, platform, title } = item;

    const name = author.socialName ?? `${author.firstname} ${author.lastname}`;

    const translations = {
        "The resource was created": trans(THE_RESOURCE_WAS_CREATED),
        "The resource was updated": trans(THE_RESOURCE_WAS_UPDATED),
        "The resource was deleted": trans(THE_RESOURCE_WAS_DELETED),
    };

    FIELDS.authorName.textContent = name;
    FIELDS.authorEmail.textContent = author.email;
    FIELDS.device.textContent = device;
    FIELDS.platform.textContent = platform;
    FIELDS.datetime.textContent = formatDateTime(datetime);
    FIELDS.title.textContent = translations[title];
    FIELDS.alertAuthorName.textContent = name;
}

function clearFields() {
    Object.values(FIELDS).forEach(field => {
        field.textContent = '';
    });
}

window.openModal = openModal;
