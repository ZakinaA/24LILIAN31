//COURS-MATHEO

document.querySelectorAll('.cours-nom').forEach(course => {
    course.addEventListener('click', function(event) {
        event.preventDefault();

        const modal = document.getElementById('coursModal');
        document.getElementById('cours-modal-libelle').textContent = event.target.getAttribute('data-libelle');
        document.getElementById('cours-modal-jour').textContent = event.target.getAttribute('data-jour');
        document.getElementById('cours-modal-heureDebut').textContent = event.target.getAttribute('data-heureDebut');
        document.getElementById('cours-modal-heureFin').textContent = event.target.getAttribute('data-heureFin');
        document.getElementById('cours-modal-typeCours').textContent = event.target.getAttribute('data-typeCours');
        document.getElementById('cours-modal-typeInstrument').textContent = event.target.getAttribute('data-typeInstrument');

        modal.style.display = 'block';
    });
});

document.querySelector('.cours-close-btn').addEventListener('click', function() {
    document.getElementById('coursModal').style.display = 'none';
});

window.addEventListener('click', function(event) {
    const modal = document.getElementById('coursModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});

function confirmDelete(courseId) {
    const confirmDelete = confirm("Êtes-vous sûr de vouloir supprimer ce cours ?");
    if (confirmDelete) {
        window.location.href = `http://172.20.177.77/lilian31/public/cours/supprimer/${courseId}`;
    }
}

document.querySelector('.cours-btn-filtre-toggle').addEventListener('click', function() {
    var dropdown = document.querySelector('.cours-dropdown-filtre');
    dropdown.classList.toggle('show');
});

document.getElementById('cours-recherche').addEventListener('input', function() {
    const query = this.value.toLowerCase();
    const rows = document.querySelectorAll('.cours-tableau tbody tr');

    rows.forEach(row => {
        const courseName = row.querySelector('.cours-nom').textContent.toLowerCase();
        if (courseName.includes(query)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

let currentPage = 1;
const rowsPerPage = 6;

const rowsToDisplay = document.querySelectorAll('.cours-tableau tbody tr');
const totalPages = Math.ceil(rowsToDisplay.length / rowsPerPage);

function showPage(page) {
    const startIndex = (page - 1) * rowsPerPage;
    const endIndex = startIndex + rowsPerPage;

    rowsToDisplay.forEach((row, index) => {
        if (index >= startIndex && index < endIndex) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

document.querySelector('.cours-btn-next').addEventListener('click', function() {
    if (currentPage < totalPages) {
        currentPage++;
        showPage(currentPage);
    }
});

document.querySelector('.cours-btn-prev').addEventListener('click', function() {
    if (currentPage > 1) {
        currentPage--;
        showPage(currentPage);
    }
});

showPage(currentPage);