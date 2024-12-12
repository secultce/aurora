import { Toast } from '../app.js'

const toastElList = document.querySelectorAll('.toast')
const toastList = [...toastElList].forEach(toastEl => new Toast(toastEl).show())
