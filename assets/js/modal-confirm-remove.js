function confirmRemove(event) {
    const href = event.getAttribute('data-href');
    document.querySelector('[data-modal-button="confirm-link"]').setAttribute('href', href);
}
