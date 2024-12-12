const FAQ_MODAL_BODY = document.getElementById('faqModalBody');
const FAQ_MODAL_LABEL = document.getElementById('faqModalLabel');

document.querySelectorAll('[data-bs-target="#faqModalAnswer"]').forEach(element => {
    element.addEventListener('click', () => {
        FAQ_MODAL_LABEL.innerHTML = element.getAttribute('data-faq-question');
        FAQ_MODAL_BODY.innerHTML = element.getAttribute('data-faq-answer');
    });
});
