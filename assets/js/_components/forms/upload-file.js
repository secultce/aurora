document.addEventListener('DOMContentLoaded', () => {
    const uploadInputs = document.getElementsByClassName('upload-file');
    Array.from(uploadInputs).forEach(dataTransferInput => dataTransferInput.addEventListener('change', evt => {
        const { inputName } = evt.target.dataset;

        const uploadedFiles = document.getElementsByName(inputName)[0];
        const dataTransfer = new DataTransfer();
        for (const file of [...uploadedFiles.files, ...evt.target.files]) {
            dataTransfer.items.add(file);
        }

        uploadedFiles.files = dataTransfer.files;
        const uploadedContainer = document.querySelector(`#${inputName}-component > .uploaded-files`);
        uploadedContainer.innerHTML = '';

        Array.from(dataTransfer.files).forEach((file, index) => {
            const fileElement = document.createElement('span');
            fileElement.textContent = file.name;

            const removeButton = document.createElement('button');
            removeButton.className = 'btn btn-close btn-sm';
            removeButton.addEventListener('click', () => {
                dataTransfer.items.remove(index);
                uploadedFiles.files = dataTransfer.files;
                fileElement.remove();
            });

            fileElement.appendChild(removeButton);
            uploadedContainer.appendChild(fileElement);
        });
    }));
});
