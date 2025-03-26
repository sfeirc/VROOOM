// Verifie si l'utilisateur est authentifié
async function isAuthenticated() {
    try {
        const formData = new FormData();
        formData.append('action', 'check-auth');
        
        const response = await fetch('api/auth.php', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        return data.success && data.isAuthenticated;
    } catch (error) {
        console.error('Error checking auth:', error);
        return false;
    }
}

// Gestion de la tentative de réservation
async function handleBookingAttempt(carId) {
    const authenticated = await isAuthenticated();
    
    if (authenticated) {
        window.location.href = `reserver.html?id=${carId}`;
    } else {
        // Stocker l'ID de la voiture dans la session pour rediriger après la connexion
        sessionStorage.setItem('pendingBooking', carId);
        showLoginModal();
    }
}

// Afficher le modal de connexion
function showLoginModal() {
    const modal = document.getElementById('login-modal');
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    } else {
        // Si aucun modal n'existe, rediriger à la page de connexion avec l'URL de retour
        const currentPage = encodeURIComponent(window.location.href);
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
    const navContainer = document.querySelector('.ml-10.flex.items-baseline.space-x-4');
    
    if (navContainer) {
        if (authenticated) {
            // Récupérer les données de l'utilisateur et mettre à jour la navigation
            const formData = new FormData();
            formData.append('action', 'check-auth');
            
            const response = await fetch('api/auth.php', {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            
            const authLinks = `
                <a href="index.html" class="${window.location.pathname.endsWith('index.html') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-800 hover:text-gray-600'} px-3 py-2 rounded-md font-medium">Accueil</a>
                <a href="search.html" class="${window.location.pathname.endsWith('search.html') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-800 hover:text-gray-600'} px-3 py-2 rounded-md font-medium">Rechercher</a>
                <a href="contact.html" class="${window.location.pathname.endsWith('contact.html') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-800 hover:text-gray-600'} px-3 py-2 rounded-md font-medium">Contact</a>
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
                        </div>
                        <a href="profile.html" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                            <i class="fas fa-user-circle mr-2"></i> Mon Profil
                        </a>
                        <a href="reservations.html" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                            <i class="fas fa-calendar-alt mr-2"></i> Mes Réservations
                        </a>
                        <a href="favorites.html" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                            <i class="fas fa-heart mr-2"></i> Mes Favoris
                        </a>
                        <div class="border-t border-gray-100 mt-2 pt-2">
                            <a href="#" id="logout-btn" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                            </a>
                        </div>
                    </div>
                </div>`;
            navContainer.innerHTML = authLinks;
        } else {
            const nonAuthLinks = `
                <a href="index.html" class="${window.location.pathname.endsWith('index.html') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-800 hover:text-gray-600'} px-3 py-2 rounded-md font-medium">Accueil</a>
                <a href="search.html" class="${window.location.pathname.endsWith('search.html') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-800 hover:text-gray-600'} px-3 py-2 rounded-md font-medium">Rechercher</a>
                <a href="contact.html" class="${window.location.pathname.endsWith('contact.html') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-800 hover:text-gray-600'} px-3 py-2 rounded-md font-medium">Contact</a>
                <a href="login_register.html" class="bg-blue-600 text-white px-4 py-2 rounded-md font-medium hover:bg-blue-700">
                    Se Connecter / S'inscrire
                </a>`;
            navContainer.innerHTML = nonAuthLinks;
        }
    }
}

// Initialiser la vérification de l'authentification au chargement de la page
document.addEventListener('DOMContentLoaded', () => {
    updateNavigation();
    
    // Vérifier si une réservation est en attente après la connexion
    const pendingBooking = sessionStorage.getItem('pendingBooking');
    if (pendingBooking) {
        sessionStorage.removeItem('pendingBooking');
        handleBookingAttempt(pendingBooking);
    }
}); 