function applyMask(input, maskFunction) {
    input.addEventListener("input", () => {
        input.value = maskFunction(input.value);
    });
}

function cpfMask(value) {
    return value
        .replace(/\D/g, '')
        .replace(/(\d{3})(\d)/, '$1.$2')
        .replace(/(\d{3})(\d)/, '$1.$2')
        .replace(/(\d{3})(\d{1,2})$/, '$1-$2');
}

function phoneMask(value) {
    return value
        .replace(/\D/g, '')
        .replace(/^(\d{2})(\d)/, '($1) $2')
        .replace(/(\d{1})?(\d{4})(\d{4})$/, '$1 $2-$3');
}

const cpfInput = document.querySelector('[data-mask="cpf"]');
const phoneInput = document.querySelector('[data-mask="phone"]');

if (cpfInput) {
    applyMask(cpfInput, cpfMask);
}

if (phoneInput) {
    applyMask(phoneInput, phoneMask);
}
