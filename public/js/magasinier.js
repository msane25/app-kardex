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

function printMouvementsTable() {
    fetch(getApiUrl('/api/mouvements'))
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data) {
                // Générer le tableau HTML avec toutes les données
                let tableHtml = `<table style='width:100%; border-collapse: collapse; margin-bottom: 20px;'>`;
                tableHtml += `<thead><tr>`;
                tableHtml += `<th style='border:1px solid #ccc; padding:8px;'>Date Mouvement</th>`;
                tableHtml += `<th style='border:1px solid #ccc; padding:8px;'>Type Mouvement</th>`;
                tableHtml += `<th style='border:1px solid #ccc; padding:8px;'>Opération</th>`;
                tableHtml += `<th style='border:1px solid #ccc; padding:8px;'>Code Article</th>`;
                tableHtml += `<th style='border:1px solid #ccc; padding:8px;'>Désignation</th>`;
                tableHtml += `<th style='border:1px solid #ccc; padding:8px;'>Demandeur</th>`;
                tableHtml += `<th style='border:1px solid #ccc; padding:8px;'>Fournisseur</th>`;
                tableHtml += `<th style='border:1px solid #ccc; padding:8px;'>Numéro Commande</th>`;
                tableHtml += `<th style='border:1px solid #ccc; padding:8px;'>Document</th>`;
                tableHtml += `<th style='border:1px solid #ccc; padding:8px;'>Quantité Servie</th>`;
                tableHtml += `<th style='border:1px solid #ccc; padding:8px;'>Réceptionnaire</th>`;
                tableHtml += `</tr></thead><tbody>`;
                data.data.forEach(mouvement => {
                    tableHtml += `<tr>`;
                    tableHtml += `<td style='border:1px solid #ccc; padding:8px;'>${mouvement.date_mouvement || ''}</td>`;
                    tableHtml += `<td style='border:1px solid #ccc; padding:8px;'>${mouvement.typeMouvement ? mouvement.typeMouvement.libelle : ''}</td>`;
                    tableHtml += `<td style='border:1px solid #ccc; padding:8px;'>${mouvement.operation ? mouvement.operation.libelle : ''}</td>`;
                    tableHtml += `<td style='border:1px solid #ccc; padding:8px;'>${mouvement.codeArticle || ''}</td>`;
                    tableHtml += `<td style='border:1px solid #ccc; padding:8px;'>${mouvement.designation || ''}</td>`;
                    tableHtml += `<td style='border:1px solid #ccc; padding:8px;'>${mouvement.demandeur || ''}</td>`;
                    tableHtml += `<td style='border:1px solid #ccc; padding:8px;'>${mouvement.fournisseur || ''}</td>`;
                    tableHtml += `<td style='border:1px solid #ccc; padding:8px;'>${mouvement.numeroCommande || ''}</td>`;
                    tableHtml += `<td style='border:1px solid #ccc; padding:8px;'>${mouvement.document_number || ''}</td>`;
                    tableHtml += `<td style='border:1px solid #ccc; padding:8px;'>${mouvement.quantiteServis || ''}</td>`;
                    tableHtml += `<td style='border:1px solid #ccc; padding:8px;'>${mouvement.receptionnaire || ''}</td>`;
                    tableHtml += `</tr>`;
                });
                tableHtml += `</tbody></table>`;

                const printWindow = window.open('', '', 'width=1000,height=700');
                printWindow.document.write(`
                    <html>
                    <head>
                        <title>Impression de tous les mouvements</title>
                        <style>
                            body { font-family: Arial, sans-serif; margin: 20px; }
                            table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                            th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
                            th { background: #16a34a; color: #fff; }
                            h2 { text-align: center; color: #16a34a; }
                            @media print { .no-print { display: none; } }
                        </style>
                    </head>
                    <body>
                        <h2>Tableau de récupération de tous les mouvements</h2>
                        ${tableHtml}
                        <div class="no-print" style="text-align:center; margin-top:30px;">
                            <button onclick="window.print()" style="padding:10px 20px; background:#16a34a; color:white; border:none; border-radius:5px; cursor:pointer;">Imprimer</button>
                            <button onclick="window.close()" style="padding:10px 20px; background:#6b7280; color:white; border:none; border-radius:5px; cursor:pointer; margin-left:10px;">Fermer</button>
                        </div>
                    </body>
                    </html>
                `);
                printWindow.document.close();
                printWindow.focus();
            } else {
                alert('Impossible de récupérer les mouvements pour impression.');
            }
        })
        .catch(() => alert('Erreur lors de la récupération des mouvements pour impression.'));
}

function exportMouvementsToExcel() {
    fetch(getApiUrl('/api/mouvements'))
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data) {
                // Générer le contenu CSV
                let csv = 'Date Mouvement,Type Mouvement,Opération,Code Article,Désignation,Demandeur,Fournisseur,Numéro Commande,Document,Quantité Servie,Réceptionnaire\n';
                data.data.forEach(mouvement => {
                    csv += `"${mouvement.date_mouvement || ''}",`;
                    csv += `"${mouvement.typeMouvement ? mouvement.typeMouvement.libelle : ''}",`;
                    csv += `"${mouvement.operation ? mouvement.operation.libelle : ''}",`;
                    csv += `"${mouvement.codeArticle || ''}",`;
                    csv += `"${mouvement.designation || ''}",`;
                    csv += `"${mouvement.demandeur || ''}",`;
                    csv += `"${mouvement.fournisseur || ''}",`;
                    csv += `"${mouvement.numeroCommande || ''}",`;
                    csv += `"${mouvement.document_number || ''}",`;
                    csv += `"${mouvement.quantiteServis || ''}",`;
                    csv += `"${mouvement.receptionnaire || ''}"\n`;
                });
                // Créer un blob et déclencher le téléchargement
                const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
                const url = URL.createObjectURL(blob);
                const link = document.createElement('a');
                link.setAttribute('href', url);
                link.setAttribute('download', 'mouvements.csv');
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            } else {
                alert('Impossible de récupérer les mouvements pour export.');
            }
        })
        .catch(() => alert('Erreur lors de la récupération des mouvements pour export.'));
} 