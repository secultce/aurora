import "../../../app.js";

import {
    trans,
    VIEW_AUTHENTICATION_ERROR_FIRST_NAME_LENGTH,
} from "../../../translator.js";

document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const btnSubmit = form.querySelector('button[type="submit"]');

    const inputs = {
        name: document.getElementById('name'),
    };

    const errorElements = {};

    Object.keys(inputs).forEach(key => {
        const errorElement = document.createElement('p');
        errorElement.classList.add('text-danger', 'mt-2', 'd-none');
        inputs[key].parentElement.appendChild(errorElement);
        errorElements[key] = errorElement;
    });

    btnSubmit.disabled = true;

    async function validateFields() {
        let isValid = true;

        Object.values(inputs).forEach(input => input.classList.remove('border-danger'));
        Object.values(errorElements).forEach(error => error.classList.add('d-none'));

        const name = inputs.name.value.trim();
        if (!name || name.length < 2 || name.length > 100) {
            errorElements.name.textContent = trans(VIEW_AUTHENTICATION_ERROR_FIRST_NAME_LENGTH);
            errorElements.name.classList.remove('d-none');
            inputs.name.classList.add('border-danger');
            isValid = false;
        }

        btnSubmit.disabled = !isValid;
    }

    Object.values(inputs).forEach(input => {
        input.addEventListener('input', validateFields);
    });

    form.addEventListener('submit', async function (event) {
        await validateFields();
        if (btnSubmit.disabled) {
            event.preventDefault();
        }
    });
});
