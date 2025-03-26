// Vérifier l'état d'authentification et mettre à jour la barre de navigation
async function checkAuthAndUpdateNav() {
    try {
        const formData = new FormData();
        formData.append('action', 'check-auth');
        
        const response = await fetch('api/auth.php', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        // Récupérer le conteneur de navigation
        const navContainer = document.querySelector('.ml-10.flex.items-baseline.space-x-4');
        
        if (data.success && data.isAuthenticated) {
            // L'utilisateur est connecté
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
                </div>
            `;
            navContainer.innerHTML = authLinks;
            
            // Gestion de la déconnexion
            document.getElementById('logout-btn')?.addEventListener('click', async (e) => {
                e.preventDefault();
                await logout();
            });

            // Fermer le menu déroulant lors d'un clic en dehors
            document.addEventListener('click', (e) => {
                const profileMenu = document.getElementById('profile-menu');
                if (profileMenu && !profileMenu.contains(e.target)) {
                    const dropdown = profileMenu.querySelector('div.absolute');
                    if (dropdown) {
                        dropdown.classList.add('hidden');
                    }
                }
            });
        } else {
            // L'utilisateur n'est pas connecté
            const nonAuthLinks = `
                <a href="index.html" class="${window.location.pathname.endsWith('index.html') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-800 hover:text-gray-600'} px-3 py-2 rounded-md font-medium">Accueil</a>
                <a href="search.html" class="${window.location.pathname.endsWith('search.html') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-800 hover:text-gray-600'} px-3 py-2 rounded-md font-medium">Rechercher</a>
                <a href="contact.html" class="${window.location.pathname.endsWith('contact.html') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-800 hover:text-gray-600'} px-3 py-2 rounded-md font-medium">Contact</a>
                <a href="login_register.html" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                    <i class="fas fa-sign-in-alt mr-2"></i>Connexion
                </a>
            `;
            navContainer.innerHTML = nonAuthLinks;
        }
    } catch (error) {
        console.error('Error checking auth status:', error);
    }
}

// Gestion de la déconnexion
async function logout() {
    try {
        const formData = new FormData();
        formData.append('action', 'logout');
        
        const response = await fetch('api/auth.php', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            window.location.href = 'index.html';
        }
    } catch (error) {
        console.error('Error logging out:', error);
        if (window.notyf) {
            notyf.error('Erreur lors de la déconnexion');
        }
    }
}

// Initialiser au chargement de la page
document.addEventListener('DOMContentLoaded', checkAuthAndUpdateNav); 