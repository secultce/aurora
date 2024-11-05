document.addEventListener('DOMContentLoaded', () => {
    function toggleDropdown() {
        const dropdownMenu = document.getElementById("customDropdown");
        dropdownMenu.classList.toggle("show");

        setTimeout(() => {
            document.getElementById("dropdownMenuButton").blur();
        }, 100);
    }

    const dropdownButton = document.getElementById("dropdownMenuButton");
    if (dropdownButton) {
        dropdownButton.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleDropdown();
        });
    }

    document.addEventListener('click', (event) => {
        const dropdownMenu = document.getElementById("customDropdown");

        if (dropdownMenu && dropdownMenu.classList.contains('show')) {
            if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.remove('show');
            }
        }
    });

    const dropdownItems = document.querySelectorAll('#customDropdown .dropdown-item');
    dropdownItems.forEach(item => {
        item.addEventListener('click', () => {
            const dropdownMenu = document.getElementById("customDropdown");
            dropdownMenu?.classList.remove('show');

            setTimeout(() => {
                dropdownButton.blur();
            }, 100);
        });
    });
});
