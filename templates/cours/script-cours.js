const fields = document.querySelectorAll('.ajouter-cours-form-group input, .ajouter-cours-form-group select, .ajouter-cours-form-group textarea');
const progressBar = document.getElementById('ajouter-cours-progress-bar');

fields.forEach(field => {
    field.addEventListener('input', updateProgress);
});

function updateProgress() {
    const filledFields = Array.from(fields).filter(field => field.value.trim() !== '');
    const progress = (filledFields.length / fields.length) * 100;
    progressBar.style.width = `${progress}%`;
}