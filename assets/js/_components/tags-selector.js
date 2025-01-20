const handleTagsFilter = (event, target) => {
    event.stopPropagation();
    if ('BUTTON' === target.tagName) {
        target = target.previousElementSibling;
    }

    const itemsElements = target.parentNode.parentNode.parentNode.querySelectorAll('&>li:not(.disabled):not(.new-tag-item)');
    const query = target.value;

    const newTagItem = target.parentNode.parentNode.parentNode.querySelector('&>li.new-tag-item > button');
    newTagItem.dataset.label = query;
    newTagItem.dataset.value = query;
    newTagItem.children[0].innerText = query;

    itemsElements.forEach(item => {
        if (item.textContent.toLowerCase().includes(query.toLowerCase())) {
            item.classList.remove('d-none');
        } else {
            item.classList.add('d-none');
        }
    });
};

const removeTag = (target, inputName, value) => {
    target.parentElement.remove();
    document.querySelector(`button[data-input-name="${inputName}"][data-value="${value}"]`)?.classList.remove('d-none', 'disabled');
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.dropdown-item[data-input-name]').forEach(item => {
        item.addEventListener('click', (event) => {
            event.preventDefault();
            const inputName = item.dataset.inputName;
            const tagLabel = item.dataset.label;
            const tagValue = item.dataset.value;

            const tagsContainer = document.getElementById(`tags-container-${inputName}`);
            const tagElement = document.createElement('div');
            tagElement.classList.add('area-tag');
            tagElement.innerHTML = `${tagLabel}<input type="hidden" name="${inputName}[]" value="${tagValue}"/>` +
                `<button type="button" class="remove-tag m-0 p-0 px-1 border-0 bg-transparent">x</button>`;
            tagsContainer.appendChild(tagElement);


            if (item.parentElement.classList.contains('new-tag-item')) {
                item.querySelector(`[id="new-tag-${inputName}"]`).innerText = '';
                item.setAttribute('data-value', '');
                item.setAttribute('data-label', '');
            } else {
                item.classList.add('d-none');
                item.classList.add('disabled');
            }

            tagElement.querySelector('.remove-tag').addEventListener('click', ({target}) => removeTag(target, inputName, tagValue));
        });
    });
});
