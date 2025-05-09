<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de Réservation - Vroom Prestige</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
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
                        <!-- This section will be dynamically updated by auth-check.js -->
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        <div class="mb-6 flex items-center space-x-4">
            <a href="admin-dashboard.php" class="text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left mr-2"></i>Retour au dashboard
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Détails de la Réservation</h1>
        </div>

        <!-- Détails de la réservation -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6" id="reservation-info">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-semibold mb-2">Réservation <span id="reservation-id" class="text-blue-600"></span></h2>
                        <p class="text-gray-600">Réservée le <span id="date-reservation"></span></p>
                    </div>
                    <div>
                        <span id="status-badge" class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full"></span>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
                <!-- Informations client -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold mb-3 text-gray-800"><i class="fas fa-user mr-2"></i>Informations Client</h3>
                    <div class="space-y-2">
                        <p><span class="font-medium">Nom:</span> <span id="client-name"></span></p>
                        <p><span class="font-medium">Email:</span> <span id="client-email"></span></p>
                        <p><span class="font-medium">Téléphone:</span> <span id="client-phone"></span></p>
                        <p><span class="font-medium">Adresse:</span> <span id="client-address"></span></p>
                    </div>
                </div>
                
                <!-- Informations véhicule -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold mb-3 text-gray-800"><i class="fas fa-car mr-2"></i>Véhicule Réservé</h3>
                    <div id="car-info" class="space-y-2">
                        <p><span class="font-medium">Marque/Modèle:</span> <span id="car-model"></span></p>
                        <p><span class="font-medium">Type:</span> <span id="car-type"></span></p>
                        <p><span class="font-medium">Année:</span> <span id="car-year"></span></p>
                        <p><span class="font-medium">Couleur:</span> <span id="car-color"></span></p>
                        <p><span class="font-medium">Statut actuel:</span> <span id="car-status"></span></p>
                    </div>
                </div>
                
                <!-- Informations location -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold mb-3 text-gray-800"><i class="fas fa-calendar-alt mr-2"></i>Détails Location</h3>
                    <div class="space-y-2">
                        <p><span class="font-medium">Date début:</span> <span id="start-date"></span></p>
                        <p><span class="font-medium">Date fin:</span> <span id="end-date"></span></p>
                        <p><span class="font-medium">Durée:</span> <span id="duration"></span> jours</p>
                        <p><span class="font-medium">Prix journalier:</span> <span id="daily-price"></span> €</p>
                        <p><span class="font-medium">Montant total:</span> <span id="total-amount" class="text-lg font-semibold text-blue-600"></span> €</p>
                    </div>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="p-6 bg-gray-50 border-t border-gray-200">
                <h3 class="text-lg font-semibold mb-3">Actions</h3>
                <div class="flex flex-wrap gap-3">
                    <button id="change-status-btn" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                        <i class="fas fa-exchange-alt mr-2"></i>Changer le statut
                    </button>
                    <button id="cancel-btn" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition">
                        <i class="fas fa-ban mr-2"></i>Annuler la réservation
                    </button>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Modal pour la gestion des statuts de réservation -->
    <div id="status-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-xl p-6 max-w-md w-full">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Modifier le statut de la réservation</h3>
                <button id="close-modal" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="mb-4">
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
                <button id="cancel-status" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Annuler
                </button>
                <button id="save-status" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Enregistrer
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notyf = new Notyf({
                duration: 3000,
                position: { x: 'right', y: 'top' }
            });
            
            const urlParams = new URLSearchParams(window.location.search);
            const reservationId = urlParams.get('id');
            
            if (!reservationId) {
                notyf.error('ID de réservation manquant');
                setTimeout(() => {
                    window.location.href = 'admin-dashboard.php';
                }, 2000);
                return;
            }
            
            // Vérifier si l'utilisateur est connecté et est administrateur
            checkAuthStatus();
            
            // Charger les détails de la réservation
            loadReservationDetails(reservationId);
            
            // Configurer les événements
            document.getElementById('change-status-btn').addEventListener('click', openStatusModal);
            document.getElementById('close-modal').addEventListener('click', closeModal);
            document.getElementById('cancel-status').addEventListener('click', closeModal);
            document.getElementById('save-status').addEventListener('click', updateReservationStatus);
            document.getElementById('cancel-btn').addEventListener('click', confirmCancelReservation);
            
            // Fonction pour vérifier le statut d'authentification
            function checkAuthStatus() {
                fetch('api/auth.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'action=check-auth'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.isAuthenticated && data.isAdmin) {
                        // L'utilisateur est un administrateur, tout va bien
                    } else {
                        // Rediriger vers la page de connexion si ce n'est pas un administrateur
                        window.location.href = 'login_register.php';
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de la vérification d\'authentification:', error);
                    notyf.error('Erreur de connexion');
                });
            }
            
            // Fonction pour charger les détails de la réservation
            function loadReservationDetails(id) {
                fetch('api/reservation-details-super-simple.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    console.log("API response:", data);
                    if (data.success) {
                        displayReservationDetails(data.reservation);
                    } else {
                        console.error("API error:", data.message);
                        notyf.error(data.message || 'Erreur lors du chargement des détails');
                        setTimeout(() => {
                            window.location.href = 'admin-dashboard.php';
                        }, 2000);
                    }
                })
                .catch(error => {
                    console.error('Erreur lors du chargement des détails:', error);
                    notyf.error('Erreur de connexion');
                });
            }
            
            // Fonction pour afficher les détails de la réservation
            function displayReservationDetails(reservation) {
                try {
                    console.log("Reservation data:", reservation);
                    
                    // Informations de réservation
                    document.getElementById('reservation-id').textContent = reservation.IdReservation;
                    
                    const dateReservation = new Date(reservation.DateReservation);
                    document.getElementById('date-reservation').textContent = dateReservation.toLocaleDateString('fr-FR', { 
                        day: 'numeric', 
                        month: 'long', 
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                    
                    // Statut de réservation
                    const statusBadge = document.getElementById('status-badge');
                    statusBadge.textContent = reservation.Statut;
                    
                    let statusClass = '';
                    switch (reservation.Statut) {
                        case 'En attente': statusClass = 'bg-yellow-100 text-yellow-800'; break;
                        case 'Confirmée': statusClass = 'bg-blue-100 text-blue-800'; break;
                        case 'En cours': statusClass = 'bg-purple-100 text-purple-800'; break;
                        case 'Terminée': statusClass = 'bg-green-100 text-green-800'; break;
                        case 'Annulée': statusClass = 'bg-red-100 text-red-800'; break;
                    }
                    statusBadge.className = `px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full ${statusClass}`;
                    
                    // Informations client
                    document.getElementById('client-name').textContent = `${reservation.Prenom} ${reservation.Nom}`;
                    document.getElementById('client-email').textContent = reservation.Email || 'Non spécifié';
                    document.getElementById('client-phone').textContent = reservation.Tel || 'Non spécifié';
                    document.getElementById('client-address').textContent = reservation.Adresse || 'Non spécifiée';
                    
                    // Informations véhicule
                    document.getElementById('car-model').textContent = `${reservation.NomMarque} ${reservation.Modele}`;
                    document.getElementById('car-type').textContent = reservation.NomType;
                    document.getElementById('car-year').textContent = reservation.Annee;
                    document.getElementById('car-color').textContent = reservation.Couleur;
                    
                    // Map status ID to display name
                    let carStatusText = 'Inconnu';
                    switch (reservation.IdStatut) {
                        case 'STAT001': carStatusText = 'Disponible'; break;
                        case 'STAT002': carStatusText = 'Louée'; break;
                        case 'STAT003': carStatusText = 'En maintenance'; break;
                        default: carStatusText = `${reservation.IdStatut} (Status non reconnu)`;
                    }
                    document.getElementById('car-status').textContent = carStatusText;
                    
                    // Informations location
                    const startDate = new Date(reservation.DateDebut);
                    const endDate = new Date(reservation.DateFin);
                    const diffTime = Math.abs(endDate - startDate);
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    
                    document.getElementById('start-date').textContent = startDate.toLocaleDateString('fr-FR');
                    document.getElementById('end-date').textContent = endDate.toLocaleDateString('fr-FR');
                    document.getElementById('duration').textContent = diffDays;
                    
                    // Calculate daily price by dividing total by duration
                    const totalAmount = parseFloat(reservation.MontantReservation);
                    const dailyPrice = diffDays > 0 ? totalAmount / diffDays : totalAmount;
                    
                    document.getElementById('daily-price').textContent = dailyPrice.toFixed(2);
                    document.getElementById('total-amount').textContent = totalAmount.toFixed(2);
                } catch (error) {
                    console.error("Erreur lors de l'affichage des détails:", error);
                    console.error("Données reçues:", reservation);
                    notyf.error("Erreur lors de l'affichage des détails de réservation");
                }
            }
            
            // Fonction pour ouvrir la modal de statut
            function openStatusModal() {
                const currentStatus = document.getElementById('status-badge').textContent;
                document.getElementById('new-status').value = currentStatus;
                document.getElementById('status-modal').classList.remove('hidden');
            }
            
            // Fonction pour fermer la modal
            function closeModal() {
                document.getElementById('status-modal').classList.add('hidden');
            }
            
            // Fonction pour mettre à jour le statut d'une réservation
            function updateReservationStatus() {
                const newStatus = document.getElementById('new-status').value;
                
                fetch('api/admin.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=update_reservation_status&reservation_id=${reservationId}&status=${newStatus}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        notyf.success('Statut mis à jour avec succès');
                        closeModal();
                        // Recharger les détails
                        loadReservationDetails(reservationId);
                    } else {
                        notyf.error(data.message || 'Erreur lors de la mise à jour du statut');
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de la mise à jour du statut:', error);
                    notyf.error('Erreur de connexion');
                });
            }
            
            // Fonction pour confirmer l'annulation d'une réservation
            function confirmCancelReservation() {
                if (confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')) {
                    document.getElementById('new-status').value = 'Annulée';
                    updateReservationStatus();
                }
            }
        });
    </script>
</body>
</html> 