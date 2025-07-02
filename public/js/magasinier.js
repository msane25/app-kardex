// Fonctions pour les modals
function openArticleModal() {
    console.log('Tentative d\'ouverture du modal Article');
    try {
        const modal = document.getElementById('articleModal');
        if (modal) {
            modal.style.display = 'block';
            console.log('Modal Article ouvert avec succès');
        } else {
            console.error('Modal Article non trouvé');
            alert('Erreur: Modal Article non trouvé');
        }
    } catch (error) {
        console.error('Erreur lors de l\'ouverture du modal Article:', error);
        alert('Erreur lors de l\'ouverture du modal Article: ' + error.message);
    }
}

function closeArticleModal() {
    try {
        const modal = document.getElementById('articleModal');
        if (modal) {
            modal.style.display = 'none';
        }
    } catch (error) {
        console.error('Erreur lors de la fermeture du modal Article:', error);
    }
}

function openMouvementModal() {
    console.log('Tentative d\'ouverture du modal Mouvement');
    try {
        const modal = document.getElementById('mouvementModal');
        if (modal) {
            modal.style.display = 'block';
            console.log('Modal Mouvement ouvert avec succès');
            loadArticles();
            loadTypeMouvements();
            loadOperations();
        } else {
            console.error('Modal Mouvement non trouvé');
            alert('Erreur: Modal Mouvement non trouvé');
        }
    } catch (error) {
        console.error('Erreur lors de l\'ouverture du modal Mouvement:', error);
        alert('Erreur lors de l\'ouverture du modal Mouvement: ' + error.message);
    }
}

function closeMouvementModal() {
    try {
        const modal = document.getElementById('mouvementModal');
        if (modal) {
            modal.style.display = 'none';
        }
    } catch (error) {
        console.error('Erreur lors de la fermeture du modal Mouvement:', error);
    }
}

function openOperationModal() {
    console.log('Tentative d\'ouverture du modal Operation');
    try {
        const modal = document.getElementById('operationModal');
        if (modal) {
            modal.style.display = 'block';
            console.log('Modal Operation ouvert avec succès');
            loadTypeMouvementsForOperation();
        } else {
            console.error('Modal Operation non trouvé');
            alert('Erreur: Modal Operation non trouvé');
        }
    } catch (error) {
        console.error('Erreur lors de l\'ouverture du modal Operation:', error);
        alert('Erreur lors de l\'ouverture du modal Operation: ' + error.message);
    }
}

function closeOperationModal() {
    try {
        const modal = document.getElementById('operationModal');
        if (modal) {
            modal.style.display = 'none';
        }
    } catch (error) {
        console.error('Erreur lors de la fermeture du modal Operation:', error);
    }
}

function openTypeMouvementModal() {
    console.log('Tentative d\'ouverture du modal TypeMouvement');
    try {
        const modal = document.getElementById('typeMouvementModal');
        if (modal) {
            modal.style.display = 'block';
            console.log('Modal TypeMouvement ouvert avec succès');
        } else {
            console.error('Modal TypeMouvement non trouvé');
            alert('Erreur: Modal TypeMouvement non trouvé');
        }
    } catch (error) {
        console.error('Erreur lors de l\'ouverture du modal TypeMouvement:', error);
        alert('Erreur lors de l\'ouverture du modal TypeMouvement: ' + error.message);
    }
}

function closeTypeMouvementModal() {
    try {
        const modal = document.getElementById('typeMouvementModal');
        if (modal) {
            modal.style.display = 'none';
        }
    } catch (error) {
        console.error('Erreur lors de la fermeture du modal TypeMouvement:', error);
    }
}

// Fonction utilitaire pour gérer l'URL d'API dynamiquement
function getApiUrl(path) {
    let apiUrl;
    
    if (window.location.pathname.includes('/stockDb/public/')) {
        apiUrl = window.location.origin + '/stockDb/public' + path;
    } else if (window.location.pathname.includes('/stockDb/') && !window.location.pathname.includes('/public/')) {
        apiUrl = window.location.origin + '/stockDb/public' + path;
    } else if (window.location.pathname.includes('/public/')) {
        apiUrl = window.location.origin + '/public' + path;
    } else {
        apiUrl = window.location.origin + '/public' + path;
    }
    
    return apiUrl;
}

// Fonction pour formater les dates
function formatDate(dateString) {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return date.toLocaleDateString('fr-FR');
}

// Variables globales pour les tableaux
let currentPage = 1;
let itemsPerPage = 10;
let allArticles = [];
let filteredArticles = [];
let currentArticlePage = 1;

let allTypeMouvements = [];
let filteredTypeMouvements = [];
let currentTypeMouvementPage = 1;
const itemsPerTypeMouvementPage = 10;

let allOperations = [];
let filteredOperations = [];
let currentOperationPage = 1;
const itemsPerOperationPage = 10;

let allMouvements = [];
let filteredMouvements = [];
let currentMouvementPage = 1;
const itemsPerMouvementPage = 10;

// Charger les tableaux au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    fetch('/stockDb/public/api/operations')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data) {
                const select = document.getElementById('operation');
                data.data.forEach(op => {
                    const option = document.createElement('option');
                    option.value = op.id_operation;
                    option.textContent = op.libelle;
                    select.appendChild(option);
                });
            }
        });
});

// Fermer les modals en cliquant en dehors
window.onclick = function(event) {
    const modals = ['articleModal', 'mouvementModal', 'operationModal', 'typeMouvementModal'];
    modals.forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (event.target == modal) {
            if (modalId === 'articleModal') closeArticleModal();
            if (modalId === 'mouvementModal') closeMouvementModal();
            if (modalId === 'operationModal') closeOperationModal();
            if (modalId === 'typeMouvementModal') closeTypeMouvementModal();
        }
    });
}

document.getElementById('mouvementForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch(getApiUrl('/api/mouvements'), {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            alert('Mouvement enregistré !');
            this.reset();
            if (typeof loadMouvementsTable === 'function') loadMouvementsTable();
        } else {
            alert('Erreur : ' + (data.message || 'Vérifiez les champs'));
        }
    });
});

// Fonction pour recharger le tableau des mouvements
function loadMouvementsTable() {
    fetch(getApiUrl('/api/mouvements'))
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data) {
                const tbody = document.getElementById('mouvementsTableBody');
                tbody.innerHTML = '';
                data.data.forEach(mouvement => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${mouvement.date_mouvement}</td>
                        <td>${mouvement.typeMouvement ? mouvement.typeMouvement.libelle : ''}</td>
                        <td>${mouvement.operation ? mouvement.operation.libelle : ''}</td>
                        <td>${mouvement.codeArticle}</td>
                        <td>${mouvement.designation || ''}</td>
                        <td>${mouvement.demandeur || ''}</td>
                        <td>${mouvement.fournisseur || ''}</td>
                        <td>${mouvement.numeroCommande || ''}</td>
                        <td>${mouvement.document_number || ''}</td>
                        <td>${mouvement.quantiteServis}</td>
                        <td>${mouvement.receptionnaire || ''}</td>
                    `;
                    tbody.appendChild(tr);
                });
            }
        });
} 