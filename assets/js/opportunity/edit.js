document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('label[for=attachments]').addEventListener('keydown', function(evt) {
        if (evt.key === 'Enter' || evt.key === ' ') {
            evt.preventDefault();
            evt.target.click();
        }
    });
});

const addAttachmentElement = target => {
    const clonedElement = target.previousElementSibling.cloneNode(true);
    clonedElement.querySelectorAll('input').forEach(element => {
        element.name = element.name.replace(
            /\[links]\[(\d+)]/,
            (_, index) => `[links][${parseInt(index, 10) + 1}]`
        );
        element.name = element.name.replace(
            /\[videos]\[(\d+)]/,
            (_, index) => `[videos][${parseInt(index, 10) + 1}]`
        );
    });
    target.parentElement.insertBefore(clonedElement, target);
}

const removeAttachmentElement = target => {
    if (target.parentElement.children.length > 2) {
        target.remove();
    } else {
        target.querySelectorAll('input').forEach(input => input.value = '');
    }
}
