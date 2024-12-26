document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('agent-create-form');
    const requiredFields = document.querySelectorAll('.required');

    const isFieldValid = (field) => {
        const errorSpan = field.nextElementSibling;
        const hasNoValue = !field.value.trim();

        const minLength = field.getAttribute('data-min-length');
        const maxLength = field.getAttribute('data-max-length');
        const lengthValid = field.value.length >= minLength && field.value.length <= maxLength;
        const errorMessageTemplate = field.getAttribute('data-error-length');

        if (true === hasNoValue) {
            document.querySelector('#agent-submit').classList.add('disabled-btn');
            errorSpan.classList.remove('d-none');
            return false;
        }


        if (false === lengthValid) {
            document.querySelector('#agent-submit').classList.add('disabled-btn');
            errorSpan.innerHTML = errorMessageTemplate
                .replace('{min}', minLength)
                .replace('{max}', maxLength);
            errorSpan.classList.remove('d-none');
            return false;
        }

        errorSpan.classList.add('d-none');
        document.querySelector('#agent-submit').classList.remove('disabled-btn');
        return true;
    };

    const areRequiredFieldsValid = () => {
        return Array.from(requiredFields).every(isFieldValid);
    };

    form.addEventListener('submit', (event) => {
        if (false === areRequiredFieldsValid()) {
            event.preventDefault();
        }
    });

    requiredFields.forEach((field) => {
        field.addEventListener('blur', () => isFieldValid(field));
    });
});
