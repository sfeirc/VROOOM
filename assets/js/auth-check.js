// Verifie si l'utilisateur est authentifié
async function isAuthenticated() {
    try {
        // Préparer la requête
        const formData = new FormData();
        formData.append('action', 'check-auth');
        // Exécuter la requête
        const response = await fetch('api/auth.php', {
            method: 'POST',
            body: formData
        });
        // Récupérer les données
        const data = await response.json();
        // Retourner true si l'utilisateur est authentifié
        return data.success && data.isAuthenticated;
    } catch (error) {
        // Log l'erreur
        console.error('Error checking auth:', error);
        // Retourner false si l'utilisateur n'est pas authentifié
        return false;
    }
}

// Vérifie si l'utilisateur est un administrateur
async function isAdmin() {
    try {
        // Préparer la requête
        const formData = new FormData();
        formData.append('action', 'check-auth');
        // Exécuter la requête
        const response = await fetch('api/auth.php', {
            method: 'POST',
            body: formData
        });
        // Récupérer les données
        const data = await response.json();
        // Retourner true si l'utilisateur est authentifié et est un administrateur
        return data.success && data.isAuthenticated && data.isAdmin;
    } catch (error) {
        // Log l'erreur
        console.error('Error checking admin status:', error);
        // Retourner false si l'utilisateur n'est pas un administrateur
        return false;
    }
}

// Gestion de la tentative de réservation
async function handleBookingAttempt(carId) {
    const authenticated = await isAuthenticated();
    // Vérifier si l'utilisateur est authentifié
    if (authenticated) {
        // Rediriger vers la page de réservation
        window.location.href = `reserver.html?id=${carId}`;
    } else {
        // Stocker l'ID de la voiture dans la session pour rediriger après la connexion
        sessionStorage.setItem('pendingBooking', carId);
        // Afficher le modal de connexion
        showLoginModal();
    }
}

// Afficher le modal de connexion
function showLoginModal() {
    // Récupérer le modal de connexion
    const modal = document.getElementById('login-modal');
    // Vérifier si le modal existe
    if (modal) {
        // Supprimer la classe hidden du modal
        modal.classList.remove('hidden');
        // Empêcher le défilement de la page
        document.body.style.overflow = 'hidden';
    } else {
        // Si aucun modal n'existe, rediriger à la page de connexion avec l'URL de retour
        const currentPage = encodeURIComponent(window.location.href);
        // Rediriger vers la page de connexion
        window.location.href = `login_register.html?redirect=${currentPage}`;
    }
}

// Fermer le modal de connexion
function closeLoginModal() {
    const modal = document.getElementById('login-modal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}

// Mettre à jour la navigation en fonction de l'état d'authentification
async function updateNavigation() {
    const authenticated = await isAuthenticated();
    const isAdminUser = await isAdmin();
    const navContainer = document.querySelector('.ml-10.flex.items-baseline.space-x-4');
    
    // Vérifier si le conteneur de navigation existe
    if (navContainer) {
        // Vérifier si l'utilisateur est authentifié
        if (authenticated) {
            // Récupérer les données de l'utilisateur et mettre à jour la navigation
            const formData = new FormData();
            formData.append('action', 'check-auth');
            // Exécuter la requête
            const response = await fetch('api/auth.php', {
                method: 'POST',
                body: formData
            });
            // Récupérer les données
            const data = await response.json();
            // Vérifier si les liens d'authentification existent
            let authLinks = `
                <a href="index.html" class="${window.location.pathname.endsWith('index.html') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-800 hover:text-gray-600'} px-3 py-2 rounded-md font-medium">Accueil</a>
                <a href="search.html" class="${window.location.pathname.endsWith('search.html') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-800 hover:text-gray-600'} px-3 py-2 rounded-md font-medium">Rechercher</a>`;
            
            // Ajouter le lien vers la page de réservations pour tous les utilisateurs authentifiés, qu'ils soient utilisateurs normaux ou administrateurs
            authLinks += `
                <a href="mes-reservations.html" class="${window.location.pathname.endsWith('mes-reservations.html') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-800 hover:text-gray-600'} px-3 py-2 rounded-md font-medium">Réservations</a>`;
            // Ajouter le lien vers la page de contact
            authLinks += `
                <a href="contact.html" class="${window.location.pathname.endsWith('contact.html') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-800 hover:text-gray-600'} px-3 py-2 rounded-md font-medium">Contact</a>`;                
            // Ajouter le lien vers le dashboard admin si l'utilisateur est un administrateur
            if (isAdminUser) {
                authLinks += `
                <a href="admin-dashboard.php" class="${window.location.pathname.endsWith('admin-dashboard.php') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-800 hover:text-gray-600'} px-3 py-2 rounded-md font-medium">Dashboard Admin</a>`;
            }
            // Ajouter le menu de profil
            authLinks += `
                <div class="relative group" id="profile-menu">
                    <button onclick="window.location.href='profile.html'" class="flex items-center space-x-1 ${window.location.pathname.endsWith('profile.html') ? 'text-blue-600' : 'text-gray-800'} hover:text-blue-600 px-3 py-2 rounded-md font-medium">
                        <img src="${data.user.photo || 'assets/images/default-profile.png'}" alt="Profile" class="w-8 h-8 rounded-full object-cover border-2 border-blue-600">
                        <span id="user-name" class="ml-2">${data.user.prenom} ${data.user.nom}</span>
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2 hidden group-hover:block">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-sm text-gray-500">Connecté en tant que</p>
                            <p class="text-sm font-medium text-gray-900 truncate">${data.user.email}</p>
                            ${isAdminUser ? '<p class="text-xs font-medium text-blue-600 mt-1">Administrateur</p>' : ''}
                        </div>`;
                
            // Afficher différentes options selon le type d'utilisateur
            if (isAdminUser) {
                authLinks += `
                        <a href="admin-dashboard.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                            <i class="fas fa-tachometer-alt mr-2"></i> Dashboard Admin
                        </a>`;
            } else {
                // Ajouter le lien vers la page de profil
                authLinks += `
                        <a href="profile.html" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                            <i class="fas fa-user-circle mr-2"></i> Mon Profil
                        </a>
                        <a href="mes-reservations.html" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                            <i class="fas fa-calendar-alt mr-2"></i> Mes Réservations
                        </a>`;
            }
            // Ajouter le lien de déconnexion
            authLinks += `
                        <div class="border-t border-gray-100 mt-2 pt-2">
                            <a href="#" id="logout-btn" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                            </a>
                        </div>
                    </div>
                </div>`;
            navContainer.innerHTML = authLinks;
                        
            // Ajouter l'événement de déconnexion
            document.getElementById('logout-btn').addEventListener('click', function(e) {
                e.preventDefault();
                logout();
            });
        } else {
            // Ajouter les liens d'authentification
            const nonAuthLinks = `
                <a href="index.html" class="${window.location.pathname.endsWith('index.html') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-800 hover:text-gray-600'} px-3 py-2 rounded-md font-medium">Accueil</a>
                <a href="search.html" class="${window.location.pathname.endsWith('search.html') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-800 hover:text-gray-600'} px-3 py-2 rounded-md font-medium">Rechercher</a>
                <a href="contact.html" class="${window.location.pathname.endsWith('contact.html') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-800 hover:text-gray-600'} px-3 py-2 rounded-md font-medium">Contact</a>
                <a href="login_register.html" class="bg-blue-600 text-white px-4 py-2 rounded-md font-medium hover:bg-blue-700">
                    Se Connecter / S'inscrire
                </a>`;
            // Mettre à jour le contenu de la navigation
            navContainer.innerHTML = nonAuthLinks;
        }
    }
}

// Fonction de déconnexion
async function logout() {
    try {
        const formData = new FormData();
        formData.append('action', 'logout');
        // Exécuter la requête
        const response = await fetch('api/auth.php', {
            method: 'POST',
            body: formData
        });
        // Récupérer les données
        const data = await response.json();
        // Vérifier si la déconnexion a été effectuée avec succès
        if (data.success) {
            // Rediriger vers la page d'accueil
            window.location.href = 'index.html';
        }
    } catch (error) {
        // Log l'erreur
        console.error('Error during logout:', error);
    }
}

// Initialiser la vérification de l'authentification au chargement de la page
document.addEventListener('DOMContentLoaded', () => {
    // Mettre à jour la navigation
    updateNavigation();
    
    // Vérifier si une réservation est en attente après la connexion
    const pendingBooking = sessionStorage.getItem('pendingBooking');
    if (pendingBooking) {
        sessionStorage.removeItem('pendingBooking');
        handleBookingAttempt(pendingBooking);
    }
});