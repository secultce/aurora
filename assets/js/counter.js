const description = document.getElementById('description');
const counter = document.getElementById('counter');

description.addEventListener('input', () => {
    const length = description.value.length;
    counter.textContent = `${length}/400`;
});
