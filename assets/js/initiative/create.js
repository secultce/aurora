const textareaShortDescriptionInitiative = document.getElementById('shortDescriptionInitiative');
const textareaLongDescriptionInitiative = document.getElementById('longDescriptionInitiative');
const counterShortDescriptionInitiative = document.querySelector('#counterShortDescriptionInitiative');
const counterLongDescriptionInitiative = document.querySelector('#counterLongDescriptionInitiative');

document.querySelector('#coverImageInitiative').addEventListener('change', readFile);

function readFile() {
    if (!this.files || !this.files[0]) return;

    const fileReader = new FileReader();

    fileReader.addEventListener('load', function (event) {
        document.querySelector("#base64CoverImageInitiative").value = event.target.result;
    });

    fileReader.readAsDataURL(this.files[0]);
}

textareaShortDescriptionInitiative.oninput = function () {
    counterShortDescriptionInitiative.innerText = textareaShortDescriptionInitiative.value.length;
}

textareaLongDescriptionInitiative.oninput = function () {
    counterLongDescriptionInitiative.innerText = textareaLongDescriptionInitiative.value.length;
}
