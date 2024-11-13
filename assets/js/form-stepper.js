const prevBtns = document.querySelectorAll('.btn-prev');
const nextBtns = document.querySelectorAll('.btn-next');
const progress = document.getElementById('progress');
const formSteps = document.querySelectorAll('.form-step');
const progressSteps = document.querySelectorAll('.progress-step');

let formStepsNum = 0;

nextBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
        formStepsNum++;
        updateFormSteps();
        updateProgressbar();
    });
});

prevBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
        formStepsNum--;
        updateFormSteps();
        updateProgressbar();
    });
});

function updateFormSteps() {
    formSteps.forEach((formStep) => {
        formStep.classList.remove('form-step-active');
    });

    formSteps[formStepsNum].classList.add('form-step-active');
}

function updateProgressbar() {
    const totalSteps = progressSteps.length - 1;
    const activeSteps = formStepsNum + 1;

    progressSteps.forEach((progressStep, index) => {
        progressStep.classList.toggle("progress-step-active", index < activeSteps);
    });

    const progressPercentage = (activeSteps - 1) / totalSteps * 100;
    progress.style.width = `${progressPercentage}%`;
}

progressSteps.forEach((progressStep, index) => {
    progressStep.addEventListener('click', () => {
        formStepsNum = index;
        updateFormSteps();
        updateProgressbar();
    });
});
