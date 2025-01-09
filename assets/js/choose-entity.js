function searchEntity(target) {
    const value = target.value.toLowerCase();
    for (const el of target.parentNode.parentNode.parentNode.querySelectorAll(".list-group li")) {
        if (el.textContent.toLowerCase().includes(value)) {
            el.classList.remove('d-none');
            el.classList.add('list-group-item');
        } else {
            el.classList.remove('list-group-item');
            el.classList.add('d-none');
        }
    }
}

function selectEntity(target) {
    const entityId = target.getAttribute('data-entity-id');
    const entityType = target.getAttribute('data-entity-type');
    const fieldName = target.getAttribute('data-field-name');

    document.querySelectorAll(`input[name="${fieldName}"]`)
        .forEach(el => el.nextElementSibling.textContent = '');

    const entityInput = document.querySelector(`input[name="${fieldName}"][data-type="${entityType}"]`);
    entityInput.value = entityType + '_' + entityId;
    entityInput.dispatchEvent(new Event('change'));
    entityInput.nextElementSibling.textContent = ': ' + target.textContent;

    const otherEntities = document.querySelectorAll(`input[name="${fieldName}"]:not(:checked)`);
    for (const el of otherEntities) {
        el.nextElementSibling.textContent = '';
        el.value = '';
    }
}
