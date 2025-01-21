function showPhoto(event) {
    const src = event.getAttribute('data-src');
    document.querySelector('#photo-modal').setAttribute('src', src);

    const alt = event.getAttribute('data-alt');
    document.querySelector('#photo-modal').setAttribute('alt', alt);
}
