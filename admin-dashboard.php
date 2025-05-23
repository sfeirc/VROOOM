<!-- Dashboard Administrateur -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Titre -->
    <title>Dashboard Admin - Vroom Prestige</title>
    <!-- CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Notyf -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <!-- JavaScript -->
    <script src="assets/js/auth-check.js"></script>
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="/" class="flex-shrink-0">
                        <img class="h-16 w-auto" src="assets/logo/logo.png" alt="Vroom Prestige">
                    </a>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <!-- Cette section sera mise à jour dynamiquement par auth-check.js -->
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard Administrateur</h1>
            <div id="admin-info" class="text-lg font-semibold text-blue-700"></div>
        </div>

        <!-- Onglets -->
        <div class="mb-6 border-b border-gray-200">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
                <li class="mr-2">
                    <a href="#" class="tab-link active inline-block p-4 border-b-2 border-blue-600 rounded-t-lg text-blue-600" data-target="reservations">
                        <i class="fas fa-calendar-alt mr-2"></i>Réservations
                    </a>
                </li>
            </ul>
        </div>

        <!-- Onglet Réservations -->
        <div id="reservations-tab" class="tab-content">
            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Filtrer les réservations</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <!-- Statut -->
                        <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                        <select id="status-filter" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Tous les statuts</option>
                            <option value="En attente">En attente</option>
                            <option value="Confirmée">Confirmée</option>
                            <option value="En cours">En cours</option>
                            <option value="Terminée">Terminée</option>
                            <option value="Annulée">Annulée</option>
                        </select>
                    </div>
                    <div>
                        <!-- Date début -->
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date début</label>
                        <input type="date" id="date-start-filter" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <!-- Date fin -->
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date fin</label>
                        <input type="date" id="date-end-filter" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div class="flex items-end">
                        <!-- Bouton filtre -->
                        <button id="filter-btn" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition w-full">
                            <i class="fas fa-filter mr-2"></i>Filtrer
                            <!-- Icone filtre -->
                        </button>
                    </div>
                </div>
            </div>
            <!-- Tableau des réservations -->
            <div class="overflow-x-auto bg-white shadow-md rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <!-- ID -->
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <!-- Client -->
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                            <!-- Voiture -->
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Voiture</th>
                            <!-- Dates -->
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                            <!-- Montant -->
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                            <!-- Statut -->
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <!-- Actions -->
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="reservations-table" class="bg-white divide-y divide-gray-200">
                        <!-- Les réservations seront chargées ici -->
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal pour la gestion des statuts de réservation -->
    <div id="status-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-xl p-6 max-w-md w-full">
            <!-- Titre -->
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Modifier le statut de la réservation</h3>
                <button id="close-modal" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="mb-4">
                <!-- Nouveau statut -->
                <label class="block text-sm font-medium text-gray-700 mb-1">Nouveau statut</label>
                <select id="new-status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="En attente">En attente</option>
                    <option value="Confirmée">Confirmée</option>
                    <option value="En cours">En cours</option>
                    <option value="Terminée">Terminée</option>
                    <option value="Annulée">Annulée</option>
                </select>
            </div>
            <div class="flex justify-end space-x-3">
                <!-- Bouton annuler -->
                <button id="cancel-status" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Annuler
                </button>
                <!-- Bouton enregistrer -->
                <button id="save-status" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Enregistrer
                </button>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialiser Notyf
            const notyf = new Notyf({
                duration: 3000,
                position: { x: 'right', y: 'top' }
            });
            // Initialiser l'ID de la réservation actuelle
            let currentReservationId = null;
            
            // Vérifier si l'utilisateur est connecté et est administrateur
            checkAuthStatus();
                        
            // Chargement initial des données
            loadReservations();
            
            // Configurer les événements
            document.getElementById('filter-btn').addEventListener('click', loadReservations);
            document.getElementById('close-modal').addEventListener('click', closeModal);
            document.getElementById('cancel-status').addEventListener('click', closeModal);
            document.getElementById('save-status').addEventListener('click', updateReservationStatus);
            
            // Fonction pour vérifier le statut d'authentification
            function checkAuthStatus() {
                fetch('api/auth.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'action=check-auth'
                })
                // Récupérer les données
                .then(response => response.json())
                .then(data => {
                    // Vérifier si l'utilisateur est connecté et est administrateur
                    if (data.success && data.isAuthenticated && data.isAdmin) {
                        // Afficher les informations de l'administrateur dans le header du dashboard
                        document.getElementById('admin-info').textContent = `Connecté en tant qu'administrateur: ${data.user.prenom} ${data.user.nom}`;
                    } else {
                        // Rediriger vers la page de connexion si ce n'est pas un administrateur
                        window.location.href = 'login_register.php';
                    }
                })
                // Gestion des erreurs
                .catch(error => {
                    console.error('Erreur lors de la vérification d\'authentification:', error);
                    notyf.error('Erreur de connexion');
                });
            }
            
            // Fonction pour charger les réservations
            function loadReservations() {
                // Récupérer les valeurs des filtres
                const statusFilter = document.getElementById('status-filter').value;
                const dateStartFilter = document.getElementById('date-start-filter').value;
                const dateEndFilter = document.getElementById('date-end-filter').value;
                // Créer une URLSearchParams
                const params = new URLSearchParams();
                // Ajouter les actions
                params.append('action', 'get_reservations');
                // Ajouter les filtres
                if (statusFilter) params.append('status', statusFilter);
                if (dateStartFilter) params.append('date_start', dateStartFilter);
                if (dateEndFilter) params.append('date_end', dateEndFilter);
                // Récupérer les réservations
                fetch('api/admin.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: params.toString()
                })
                // Récupérer les données
                .then(response => response.json())
                .then(data => {
                    // Vérifier si les réservations ont été chargées avec succès
                    if (data.success) {
                        // Afficher les réservations
                        renderReservations(data.reservations);
                    } else {
                        // Afficher un message d'erreur
                        notyf.error(data.message || 'Erreur lors du chargement des réservations');
                    }
                })
                // Gestion des erreurs
                .catch(error => {
                    console.error('Erreur lors du chargement des réservations:', error);
                    notyf.error('Erreur de connexion');
                });
            }
            
            // Fonction pour afficher les réservations
            function renderReservations(reservations) {
                const table = document.getElementById('reservations-table');
                table.innerHTML = '';
                // Vérifier si les réservations sont disponibles
                if (reservations.length === 0) {
                    table.innerHTML = `
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                Aucune réservation trouvée
                            </td>
                        </tr>
                    `;
                    return;
                }
                // Parcourir les réservations
                reservations.forEach(reservation => {
                    // Récupérer les dates
                    const startDate = new Date(reservation.DateDebut).toLocaleDateString('fr-FR');
                    const endDate = new Date(reservation.DateFin).toLocaleDateString('fr-FR');
                    // Définir la classe du statut
                    let statusClass = '';
                    switch (reservation.Statut) {
                        case 'En attente': statusClass = 'bg-yellow-100 text-yellow-800'; break;
                        case 'Confirmée': statusClass = 'bg-blue-100 text-blue-800'; break;
                        case 'En cours': statusClass = 'bg-purple-100 text-purple-800'; break;
                        case 'Terminée': statusClass = 'bg-green-100 text-green-800'; break;
                        case 'Annulée': statusClass = 'bg-red-100 text-red-800'; break;
                    }
                    
                    // Ajouter les réservations au tableau
                    table.innerHTML += `
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${reservation.IdReservation}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${reservation.PrenomClient} ${reservation.NomClient}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${reservation.NomMarque} ${reservation.Modele}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${startDate} - ${endDate}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${parseFloat(reservation.MontantReservation).toFixed(2)} €</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statusClass}">
                                    ${reservation.Statut}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <button class="text-blue-600 hover:text-blue-900 mr-3" onclick="openStatusModal('${reservation.IdReservation}', '${reservation.Statut}')">
                                    <i class="fas fa-edit"></i> Statut
                                </button>
                                <a href="reservation-details.php?id=${reservation.IdReservation}" class="text-gray-600 hover:text-gray-900">
                                    <i class="fas fa-eye"></i> Détails
                                </a>
                            </td>
                        </tr>
                    `;
                });
            }
            
            // Fonction pour ouvrir la modal de statut
            window.openStatusModal = function(reservationId, currentStatus) {
                currentReservationId = reservationId;
                document.getElementById('new-status').value = currentStatus;
                document.getElementById('status-modal').classList.remove('hidden');
            }
            
            // Fonction pour fermer la modal
            function closeModal() {
                document.getElementById('status-modal').classList.add('hidden');
                currentReservationId = null;
            }
            
            // Fonction pour mettre à jour le statut d'une réservation
            function updateReservationStatus() {
                const newStatus = document.getElementById('new-status').value;
                
                // Récupérer les données
                fetch('api/admin.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=update_reservation_status&reservation_id=${currentReservationId}&status=${newStatus}`
                })
                // Récupérer les données
                .then(response => response.json())
                .then(data => {
                    // Vérifier si la mise à jour du statut a été effectuée avec succès
                    if (data.success) {
                        // Afficher un message de succès
                        notyf.success('Statut mis à jour avec succès');
                        // Fermer la modal
                        closeModal();
                        // Recharger les réservations
                        loadReservations();
                    } else {
                        // Afficher un message d'erreur
                        notyf.error(data.message || 'Erreur lors de la mise à jour du statut');
                    }
                })
                // Gestion des erreurs
                .catch(error => {
                    console.error('Erreur lors de la mise à jour du statut:', error);
                    notyf.error('Erreur de connexion');
                });
            }
        });
    </script>
</body>
</html> 