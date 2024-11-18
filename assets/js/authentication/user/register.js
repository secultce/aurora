import "../../../app.js";

import {
    trans,
    VIEW_AUTHENTICATION_ERROR_FIRST_NAME_LENGTH,
    VIEW_AUTHENTICATION_ERROR_INVALID_EMAIL,
    VIEW_AUTHENTICATION_ERROR_INVALID_PASSWORD,
    VIEW_AUTHENTICATION_ERROR_LAST_NAME_LENGTH,
    VIEW_AUTHENTICATION_ERROR_PASSWORD_MISMATCH,
} from "../../../translator.js";

document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const btnNext = document.querySelector('.btn-next');
    const errorMessageElement = document.getElementById('error-message');

    const inputs = {
        firstName: document.querySelector('input[name="first_name"]'),
        lastName: document.querySelector('input[name="last_name"]'),
        email: document.querySelector('input[name="email"]'),
        password: document.querySelector('input[name="password"]'),
        confirmPassword: document.querySelector('input[name="confirm_password"]')
    };

    const progressBar = document.querySelector('#passwordStrength .progress-bar');

    btnNext.disabled = true;

    async function validateFields() {
        const firstName = inputs.firstName.value.trim();
        const lastName = inputs.lastName.value.trim();
        const email = inputs.email.value.trim();
        const password = inputs.password.value.trim();
        const confirmPassword = inputs.confirmPassword.value.trim();
        let errorMessage = '';

        Object.values(inputs).forEach(input => {
            input.classList.remove('border-danger');
        });

        if (!validateName(firstName)) {
            errorMessage = trans(VIEW_AUTHENTICATION_ERROR_FIRST_NAME_LENGTH);
            inputs.firstName.classList.add('border-danger');
        } else if (!validateName(lastName)) {
            errorMessage = trans(VIEW_AUTHENTICATION_ERROR_LAST_NAME_LENGTH);
            inputs.lastName.classList.add('border-danger');
        } else if (!validateEmail(email)) {
            errorMessage = trans(VIEW_AUTHENTICATION_ERROR_INVALID_EMAIL);
            inputs.email.classList.add('border-danger');
        } else if (!validatePassword(password)) {
            errorMessage = trans(VIEW_AUTHENTICATION_ERROR_INVALID_PASSWORD);
            inputs.password.classList.add('border-danger');
        } else if (!validateConfirmPassword(password, confirmPassword)) {
            errorMessage = trans(VIEW_AUTHENTICATION_ERROR_PASSWORD_MISMATCH);
            inputs.confirmPassword.classList.add('border-danger');
        }

        if (errorMessage) {
            errorMessageElement.textContent = errorMessage;
            errorMessageElement.classList.remove('d-none');
            btnNext.disabled = true;
        } else {
            errorMessageElement.classList.add('d-none');
            btnNext.disabled = false;
        }
    }

    Object.values(inputs).forEach(input => {
        input.addEventListener('input', validateFields);
    });

    inputs.password.addEventListener('input', function() {
        updatePasswordStrength(inputs.password.value);
    });

    form.addEventListener('submit', async function (event) {
        await validateFields();
        if (btnNext.disabled) {
            event.preventDefault();
        }
    });

    function updatePasswordStrength(password) {
        let strength = 0;

        // Criteria for scoring the password
        if (password.length >= 8) strength += 1;
        if (/[a-z]/.test(password)) strength += 1;
        if (/[A-Z]/.test(password)) strength += 1;
        if (/\d/.test(password)) strength += 1;
        if (/[\W_]/.test(password)) strength += 1;

        const strengthPercentage = (strength / 5) * 100;
        progressBar.style.width = strengthPercentage + '%';

        if (strengthPercentage <= 40) {
            progressBar.classList.add('bg-danger');
            progressBar.classList.remove('bg-warning', 'bg-success');
        } else if (strengthPercentage <= 80) {
            progressBar.classList.add('bg-warning');
            progressBar.classList.remove('bg-danger', 'bg-success');
        } else {
            progressBar.classList.add('bg-success');
            progressBar.classList.remove('bg-danger', 'bg-warning');
        }
    }
});

function validateName(name) {
    return name.length >= 2 && name.length <= 50;
}

function validateEmail(email) {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email) && email.length <= 100;
}

function validatePassword(password) {
    const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
    return passwordPattern.test(password) && password.length <= 255;
}

function validateConfirmPassword(password, confirmPassword) {
    return password === confirmPassword;
}
