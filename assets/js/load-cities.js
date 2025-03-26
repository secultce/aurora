document.addEventListener("DOMContentLoaded", function () {
    const stateSelect = document.getElementById("state");
    const citySelect = document.getElementById("address");
    const token = document.getElementById("filter-sidebar").getAttribute("token");

    stateSelect.addEventListener("change", function () {
        const stateId = this.value;
        citySelect.innerHTML = `<option value="">${citySelect.getAttribute("data-placeholder") || "Selecione"}</option>`;

        if (!stateId) return;

        fetch(`/api/states/${stateId}/cities`, {
            headers: {
                Authorization: `Bearer ${token}`
            }
        })
            .then(res => res.json())
            .then(cities => {
                cities.forEach(city => {
                    citySelect.innerHTML += `<option value="${city.id}">${city.name}</option>`;
                });
            })
            .catch(error => console.error('Error fetching cities:', error));
    });
});
