function confirmDelete(numSerie, instrumentId) {
    const confirmMessage = `Êtes-vous sûr de vouloir supprimer l'instrument avec le numéro de série: ${numSerie} ?`;
    if (confirm(confirmMessage)) {
        window.location.href = `/lilian31/public/instrument/supprimer/${instrumentId}`;
    }
}

document.querySelector('input[type="file"]').addEventListener('change', event => {
    const preview = document.getElementById('image-preview');
    const file = event.target.files[0];
    const reader = new FileReader();

    reader.onload = () => {
        preview.src = reader.result;
    };

    if (file) {
        reader.readAsDataURL(file);
    }
});

const fields = document.querySelectorAll('.ajouter-form-group input, .ajouter-form-group select, .ajouter-form-group textarea');
const progressBar = document.querySelector('.ajouter-progress-bar');

fields.forEach(field => {
    field.addEventListener('input', updateProgress);
});

function updateProgress() {
    const filledFields = Array.from(fields).filter(field => field.value.trim() !== '');
    const progress = (filledFields.length / fields.length) * 100;
    progressBar.style.width = `${progress}%`;
}

