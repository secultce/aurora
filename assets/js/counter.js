const descricao = document.getElementById('inputProfileDescription');
const contador = document.getElementById('counter');

descricao.addEventListener('input', () => {
    const length = descricao.value.length;
    contador.textContent = `${length}/400`;
});
