// Aperçu de l'image de profil
document.getElementById('inputImage').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const reader = new FileReader();
    
    reader.onload = function(e) {
        const img = document.querySelector('.profile-header img');
        img.src = e.target.result; // Prévisualisation de l'image sélectionnée
    };

    if (file) {
        reader.readAsDataURL(file);
    }
});

// Validation du formulaire lors de la soumission
document.querySelector('form').addEventListener('submit', function(event) {
    let isValid = true;

    // Validation des champs du formulaire de profil
    const name = document.getElementById('inputNomPrenom');
    const email = document.getElementById('inputEmail');
    const phone = document.getElementById('inputTelephone');
    
    if (name.value.trim() === '') {
        alert('Veuillez entrer votre nom et prénom.');
        isValid = false;
    }
    if (email.value.trim() === '') {
        alert('Veuillez entrer votre email.');
        isValid = false;
    } else if (!validateEmail(email.value.trim())) {
        alert('Veuillez entrer un email valide.');
        isValid = false;
    }
    if (phone.value.trim() === '') {
        alert('Veuillez entrer votre numéro de téléphone.');
        isValid = false;
    }

    // Empêcher la soumission du formulaire si ce n'est pas valide
    if (!isValid) {
        event.preventDefault();
    }
});

// Fonction de validation d'email
function validateEmail(email) {
    const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    return regex.test(email);
}

// Basculer le menu mobile (icône hamburger)
document.querySelector('.menu-toggle').addEventListener('click', function() {
    const navLinks = document.querySelector('.nav-links');
    navLinks.classList.toggle('active'); // Bascule la visibilité du menu
});

// Gérer le collapsible Bootstrap pour le menu en vue mobile
document.querySelector('.menu-toggle').addEventListener('click', function() {
    const menu = document.querySelector('.nav-links');
    menu.classList.toggle('show');
});

// Optionnel : Désactiver le bouton de soumission si aucun fichier n'est sélectionné pour le CV ou la lettre de motivation
const cvInput = document.getElementById('inputCV');
const motivationInput = document.getElementById('inputMotivation');
const submitButton = document.querySelector('form button');

function checkFileInputs() {
    if (!cvInput.files.length && !motivationInput.files.length) {
        submitButton.disabled = true;
    } else {
        submitButton.disabled = false;
    }
}

// Écouter les changements dans les entrées de fichiers
cvInput.addEventListener('change', checkFileInputs);
motivationInput.addEventListener('change', checkFileInputs);
