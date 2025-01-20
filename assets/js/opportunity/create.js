import "../../app.js";
import {
    trans,
    VIEW_OPPORTUNITY_ERROR_AGENT,
    VIEW_OPPORTUNITY_ERROR_ENTITY,
    VIEW_OPPORTUNITY_ERROR_OPPORTUNITY_TYPE,
    VIEW_OPPORTUNITY_ERROR_TITLE,
    TYPE_OPPORTUNITY,
} from '../../translator.js';

document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("create-opportunity-form");
    const errorElement = document.getElementById("error-message");
    const [ submitBtn, submitDraftBtn ] = document.querySelectorAll('button[name=status]');
    let errorMessage = '';

    submitBtn.disabled = true;
    submitDraftBtn.disabled = true;

    const inputFields = {
        type: form['extraFields[type]'],
        name: form.name,
        createdBy: form.createdBy,
        entity: form.entity,
    };

    Object.values(inputFields).forEach(fieldElement => {
        if (fieldElement.addEventListener) {
            ['change', 'input'].forEach(event => fieldElement.addEventListener(event, validateForm));
        } else {
            Array.from(fieldElement).forEach(radio => radio.addEventListener('change', validateForm));
        }
    });

    function validateForm() {
        errorMessage = '';
        errorElement.classList.add('d-none');
        Object.values(inputFields).forEach(element => element.classList?.remove('border-danger'));
        const entityRadios = Array.from(inputFields.entity);
        entityRadios.forEach(radio => radio.parentNode.parentNode.classList.remove('border-danger'));

        if (inputFields.type.value === trans(TYPE_OPPORTUNITY)) {
            setError(inputFields.type, VIEW_OPPORTUNITY_ERROR_OPPORTUNITY_TYPE);
        } else if (inputFields.name.value.length < 2 || inputFields.name.value.length > 100) {
            setError(inputFields.name, VIEW_OPPORTUNITY_ERROR_TITLE);
        } else if ('' === inputFields.createdBy.value) {
            setError(inputFields.createdBy, VIEW_OPPORTUNITY_ERROR_AGENT);
        } else if ('' === inputFields.entity.value) {
            for (const radio of Array.from(inputFields.entity)) {
                setError(radio.parentNode.parentNode, VIEW_OPPORTUNITY_ERROR_ENTITY);
            }
        }

        updateButtonsState();
    }

    function setError(fieldElement, errorKey) {
        errorMessage = trans(errorKey);
        fieldElement.classList?.add('border-danger');
    }

    function updateButtonsState() {
        const hasError = errorMessage.length > 0;
        submitBtn.disabled = hasError;
        submitDraftBtn.disabled = hasError;
        errorElement.textContent = errorMessage;
        hasError && errorElement.classList.remove('d-none');
    }
});
