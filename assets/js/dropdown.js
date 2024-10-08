document.querySelectorAll('.dropdown-item').forEach(item => {
    item.addEventListener('click', (event) => {
        event.preventDefault();
        const areaText = item.textContent;
        const areaValue = item.getAttribute('data-value');

        const areaContainer = document.getElementById('areas-container');
        const areaTag = document.createElement('div');
        areaTag.classList.add('area-tag');
        areaTag.innerHTML = `${areaText} <span class="remove-tag">x</span>`;
        areaContainer.appendChild(areaTag);

        areaTag.querySelector('.remove-tag').addEventListener('click', () => {
            areaTag.remove();
        });
    });
});
