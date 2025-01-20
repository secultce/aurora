const previewImage = target => {
    const [file] = target.files;
    if (file) {
        const previewImg = target.parentElement.querySelector('.image-preview') ?? document.createElement('img');
        previewImg.src = URL.createObjectURL(file);
        previewImg.className = "image-preview " + target.dataset.previewClasses;

        const removeButton = target.parentElement.querySelector('.remove-button') ?? document.createElement('button');
        removeButton.className = "remove-button btn text-danger position-absolute fs-6 z-3 py-0 px-1";
        removeButton.style.lineHeight = '1';
        removeButton.innerHTML = '<i class="material-icons">delete_forever</i>';
        removeButton.addEventListener('click', function (evt) {
            evt.preventDefault();
            removeImage(removeButton.parentElement);
        });

        target.parentElement.appendChild(previewImg);
        target.parentElement.appendChild(removeButton);
    }
}

const removeImage = (label) => {
    label.querySelector('input[type=file]').value = '';
    label.querySelector('.image-preview').remove();
    label.querySelector('.remove-button').remove();
}
