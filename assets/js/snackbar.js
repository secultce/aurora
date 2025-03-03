const toastElList = document.querySelectorAll('.toast')
const toastList = [...toastElList].forEach(toastEl => new bootstrap.Toast(toastEl).show())
