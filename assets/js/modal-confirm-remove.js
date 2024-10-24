function confirmRemove(event) {
    document.querySelector('[data-modal-button="confirm-link"]').setAttribute(
        'href',
        event.getAttribute('data-href')
    );
}
