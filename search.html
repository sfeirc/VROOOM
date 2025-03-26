<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rechercher - Vroom Prestige</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .filter-group {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.5s ease forwards;
        }
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .loading-skeleton {
            animation: pulse 1.5s infinite;
        }
        @keyframes pulse {
            0% { opacity: 0.6; }
            50% { opacity: 0.8; }
            100% { opacity: 0.6; }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="/" class="flex-shrink-0">
                        <img class="h-8 w-auto" src="assets/images/logo.png" alt="Vroom Prestige">
                    </a>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <!-- La navigation sera injectée par auth-check.js -->
                    </div>
                </div>
                <div class="md:hidden">
                    <button type="button" class="text-gray-800 hover:text-gray-600" id="mobile-menu-button">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile menu -->
        <div class="hidden md:hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="index.html" class="block text-gray-800 hover:text-gray-600 px-3 py-2 rounded-md font-medium">Accueil</a>
                <a href="search.html" class="block text-blue-600 bg-blue-50 px-3 py-2 rounded-md font-medium">Rechercher</a>
                <a href="contact.html" class="block text-gray-800 hover:text-gray-600 px-3 py-2 rounded-md font-medium">Contact</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8 flex flex-col md:flex-row gap-8">
        <!-- Filters Sidebar -->
        <aside class="filter-sidebar w-full md:w-80 bg-white p-6 rounded-xl shadow-lg md:sticky md:top-24 md:h-[calc(100vh-6rem)] overflow-y-auto">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-blue-800">
                    Filtres
                </h2>
                <button id="clear-filters" class="text-sm text-blue-600 hover:text-blue-800 transition-colors">
                    Effacer tout
                </button>
            </div>

            <!-- Filter Groups -->
            <div class="space-y-6">
                <!-- Brand Filter -->
                <div class="filter-group" style="animation-delay: 0.1s">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Marque</label>
                    <select id="marque" data-filter="marque" class="filter-input w-full border border-gray-300 rounded-lg p-2.5 bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Toutes les marques</option>
                    </select>
                </div>

                <!-- Type Filter -->
                <div class="filter-group" style="animation-delay: 0.2s">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type de véhicule</label>
                    <select id="type" data-filter="type" class="filter-input w-full border border-gray-300 rounded-lg p-2.5 bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tous les types</option>
                    </select>
                </div>

                <!-- Price Range Filter -->
                <div class="filter-group" style="animation-delay: 0.3s">
                    <label class="block text-sm font-medium text-gray-700 mb-4">Prix maximum par jour (€)</label>
                    <div class="space-y-4">
                        <input type="range" 
                               id="prix_max" 
                               data-filter="prix_max" 
                               min="200" 
                               max="1500" 
                               value="1500"
                               step="50" 
                               class="w-full cursor-pointer">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>200€</span>
                            <span id="prix_max_value">1500€</span>
                        </div>
                    </div>
                </div>

                <!-- Year Filter -->
                <div class="filter-group" style="animation-delay: 0.4s">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Année</label>
                    <div class="grid grid-cols-2 gap-4">
                        <input type="number" id="annee_min" data-filter="annee_min" placeholder="Min" class="filter-input w-full border border-gray-300 rounded-lg p-2.5">
                        <input type="number" id="annee_max" data-filter="annee_max" placeholder="Max" class="filter-input w-full border border-gray-300 rounded-lg p-2.5">
                    </div>
                </div>

                <!-- Fuel Type Filter -->
                <div class="filter-group" style="animation-delay: 0.5s">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Carburant</label>
                    <select id="energie" data-filter="energie" class="filter-input w-full border border-gray-300 rounded-lg p-2.5 bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tous les carburants</option>
                    </select>
                </div>

                <!-- Transmission Filter -->
                <div class="filter-group" style="animation-delay: 0.6s">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Transmission</label>
                    <select id="boite" data-filter="boite" class="filter-input w-full border border-gray-300 rounded-lg p-2.5 bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Toutes les transmissions</option>
                    </select>
                </div>

                <!-- Sort Options -->
                <div class="filter-group" style="animation-delay: 0.7s">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Trier par</label>
                    <select id="sort" data-filter="sort" class="filter-input w-full border border-gray-300 rounded-lg p-2.5 bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="prix_asc">Prix : croissant</option>
                        <option value="prix_desc">Prix : décroissant</option>
                        <option value="annee_desc">Année : plus récent</option>
                        <option value="annee_asc">Année : plus ancien</option>
                    </select>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1">
            <!-- Results Count -->
            <div class="mb-6">
                <h1 class="text-4xl font-bold mb-2">Véhicules disponibles</h1>
                <p id="result-count" class="text-gray-600"></p>
            </div>

            <!-- Loading State -->
            <div id="loading-state" class="hidden grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Loading skeletons will be inserted here -->
            </div>

            <!-- Results Grid -->
            <div id="results-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Car cards will be inserted here -->
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-white text-lg font-semibold mb-4">À propos</h3>
                    <p class="text-gray-400">Vroom Prestige est votre partenaire de confiance pour la location de voitures de luxe.</p>
                </div>
                <div>
                    <h3 class="text-white text-lg font-semibold mb-4">Liens rapides</h3>
                    <ul class="space-y-2">
                        <li><a href="search.html" class="text-gray-400 hover:text-white">Rechercher</a></li>
                        <li><a href="contact.html" class="text-gray-400 hover:text-white">Contact</a></li>
                        <li><a href="login_register.html" class="text-gray-400 hover:text-white">Connexion</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white text-lg font-semibold mb-4">Contact</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><i class="fas fa-phone mr-2"></i> +33 1 23 45 67 89</li>
                        <li><i class="fas fa-envelope mr-2"></i> contact@vroom-prestige.fr</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i> 123 Avenue des Champs-Élysées, Paris</li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 border-t border-gray-800 pt-8">
                <p class="text-gray-400 text-center">&copy; 2024 Vroom Prestige. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Login Modal -->
    <div id="login-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
            <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full mx-auto">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-lock text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Connexion Requise</h3>
                    <p class="text-gray-600 mb-6">
                        Veuillez vous connecter ou créer un compte pour réserver ce véhicule.
                    </p>
                    <div class="flex gap-4">
                        <a href="login_register.html" class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors text-center">
                            Se connecter
                        </a>
                        <button onclick="closeLoginModal()" class="flex-1 bg-gray-100 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-200 transition-colors">
                            Annuler
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script src="assets/js/auth-check.js"></script>
    <script>
        // Initialize Notyf for beautiful notifications
        const notyf = new Notyf({
            duration: 3000,
            position: { x: 'right', y: 'top' },
            types: [
                {
                    type: 'success',
                    background: '#3182ce',
                    icon: false
                },
                {
                    type: 'error',
                    background: '#e53e3e',
                    icon: false
                }
            ]
        });

        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });

        // Fonctions de gestion des modales
        function showLoginModal() {
            const modal = document.getElementById('login-modal');
            if (modal) {
                modal.classList.remove('hidden');
            }
        }

        function closeLoginModal() {
            const modal = document.getElementById('login-modal');
            if (modal) {
                modal.classList.add('hidden');
            }
        }

        // Gestionnaire de tentative de réservation
        async function handleBookingAttempt(carId) {
            try {
                // Vérifier si l'utilisateur est connecté
                const response = await fetch('api/check-auth.php', {
                    credentials: 'include' // Important: inclure les identifiants pour les cookies de session
                });
                
                if (!response.ok) {
                    throw new Error(`Erreur HTTP! statut: ${response.status}`);
                }
                
                const data = await response.json();
                
                if (data.isLoggedIn) {
                    // L'utilisateur est connecté, rediriger vers la page de réservation
                    window.location.href = `reserver.html?id=${carId}`;
                } else {
                    // L'utilisateur n'est pas connecté, afficher la modale de connexion
                    showLoginModal();
                }
            } catch (error) {
                console.error('Erreur lors de la vérification de l\'authentification:', error);
                // Afficher la modale de connexion en cas d'erreur
                showLoginModal();
            }
        }

        // Fermer la modale lors d'un clic à l'extérieur
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('login-modal');
            if (modal && !modal.classList.contains('hidden')) {
                const modalContent = modal.querySelector('.bg-white');
                if (!modalContent.contains(event.target) && !event.target.closest('button')) {
                    closeLoginModal();
                }
            }
        });

        // Écouteurs d'événements pour les filtres
        document.addEventListener('DOMContentLoaded', function() {
            // Charger tous les filtres depuis la base de données
            loadFilters();

            // Ajouter des écouteurs d'événements à tous les champs de filtres
            const filterInputs = document.querySelectorAll('[data-filter]');
            filterInputs.forEach(input => {
                input.addEventListener('change', searchVehicles);
            });

            // Événement du curseur de prix
            const prixMaxInput = document.getElementById('prix_max');
            if (prixMaxInput) {
                // Définir la valeur initiale
                document.getElementById('prix_max_value').textContent = prixMaxInput.value + '€';
                
                // Ajouter les écouteurs d'événements 'input' et 'change'
                ['input', 'change'].forEach(eventType => {
                    prixMaxInput.addEventListener(eventType, function() {
                        document.getElementById('prix_max_value').textContent = this.value + '€';
                        if (eventType === 'change') {
                            searchVehicles();
                        }
                    });
                });
            }

            // Bouton pour effacer les filtres
            document.getElementById('clear-filters').addEventListener('click', function() {
                document.querySelectorAll('[data-filter]').forEach(element => {
                    if (element.type === 'range') {
                        element.value = element.max;
                        document.getElementById('prix_max_value').textContent = element.max + '€';
                    } else {
                        element.value = '';
                    }
                });
                searchVehicles();
            });

            // Recherche initiale
            searchVehicles();
        });

        // Afficher l'état de chargement
        function showLoading() {
            const loadingState = document.getElementById('loading-state');
            if (loadingState) {
                loadingState.classList.remove('hidden');
            }
        }

        // Masquer l'état de chargement
        function hideLoading() {
            const loadingState = document.getElementById('loading-state');
            if (loadingState) {
                loadingState.classList.add('hidden');
            }
        }

        // Afficher les voitures dans la grille
        function displayCars(cars) {
            const resultsContainer = document.getElementById('results-container');
            resultsContainer.innerHTML = '';

            cars.forEach(car => {
                // Créer l'élément de voiture
                const carElement = document.createElement('div');
                carElement.className = 'bg-white rounded-lg shadow-lg overflow-hidden transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl';
                
                // Obtenir les noms de champs corrects depuis la base de données
                const price = car.PrixLocation ? `${car.PrixLocation}` : 'Prix non défini';
                const brand = car.NomMarque || 'Marque non définie';
                const model = car.Modele || 'Modèle non défini';
                const type = car.NomType || 'Type non défini';
                const year = car.Annee || 'Année non définie';
                const energy = car.Energie || 'Non spécifié';
                const transmission = car.BoiteVitesse || 'Non spécifié';
                const seats = car.NbPlaces || '5';
                const power = car.Puissance ? `${car.Puissance} ch` : 'Non spécifié';
                
                // Utiliser le champ Photo de la base de données
                const defaultImage = 'assets/images/car-placeholder.jpg';
                const image = car.Photo && car.Photo !== '' ? car.Photo : defaultImage;
                
                carElement.innerHTML = `
                    <div class="relative">
                        <img src="${image}" 
                             alt="${brand} ${model}" 
                             class="w-full h-48 object-cover"
                             onerror="this.onerror=null; this.src='${defaultImage}';">
                        ${car.IdStatut !== 'STAT001' ? '<div class="absolute top-0 right-0 bg-red-500 text-white px-2 py-1 m-2 rounded">Non disponible</div>' : ''}
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2">${brand} ${model}</h3>
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-2xl font-bold text-blue-600">${price}€<span class="text-sm text-gray-600">/jour</span></span>
                            <span class="text-sm text-gray-600">${type}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-sm text-gray-600 mb-4">
                            <div><i class="fas fa-calendar-alt mr-1"></i> ${year}</div>
                            <div><i class="fas fa-gas-pump mr-1"></i> ${energy}</div>
                            <div><i class="fas fa-cog mr-1"></i> ${transmission}</div>
                            <div><i class="fas fa-users mr-1"></i> ${seats} places</div>
                            <div><i class="fas fa-horse mr-1"></i> ${power}</div>
                            <div><i class="fas fa-door-open mr-1"></i> ${car.NbPorte || '-'} portes</div>
                        </div>
                        <button onclick="handleBookingAttempt('${car.IdVoiture}')" 
                                class="block w-full bg-blue-600 text-white text-center py-2 rounded hover:bg-blue-700 transition-colors ${car.IdStatut !== 'STAT001' ? 'opacity-50 cursor-not-allowed' : ''}"
                                ${car.IdStatut !== 'STAT001' ? 'disabled' : ''}>
                            ${car.IdStatut === 'STAT001' ? 'Réserver' : 'Non disponible'}
                        </button>
                    </div>
                `;
                resultsContainer.appendChild(carElement);
            });
        }

        // Charger tous les filtres à partir de la base de données
        async function loadFilters() {
            try {
                // Charger les marques
                const brandsResponse = await fetch('api/brands.php');
                const brandsData = await brandsResponse.json();
                console.log('Brands data:', brandsData); // Log de débogage
                
                if (brandsData.success) {
                    const marqueSelect = document.getElementById('marque');
                    marqueSelect.innerHTML = '<option value="">Toutes les marques</option>';
                    brandsData.brands.forEach(brand => {
                        const option = document.createElement('option');
                        option.value = brand.IdMarque;
                        option.textContent = brand.NomMarque;
                        console.log('Adding brand option:', brand); // Debug log
                        marqueSelect.appendChild(option);
                    });
                }

                // Charger les types
                const typesResponse = await fetch('api/types.php');
                const typesData = await typesResponse.json();
                if (typesData.success) {
                    const typeSelect = document.getElementById('type');
                    typeSelect.innerHTML = '<option value="">Tous les types</option>';
                    typesData.types.forEach(type => {
                        const option = document.createElement('option');
                        option.value = type.IdType;
                        option.textContent = type.NomType;
                        typeSelect.appendChild(option);
                    });
                }

                // charger les energies
                const energiesResponse = await fetch('api/energies.php');
                const energiesData = await energiesResponse.json();
                if (energiesData.success) {
                    const energieSelect = document.getElementById('energie');
                    energieSelect.innerHTML = '<option value="">Tous les carburants</option>';
                    energiesData.energies.forEach(energie => {
                        const option = document.createElement('option');
                        option.value = energie;
                        option.textContent = energie;
                        energieSelect.appendChild(option);
                    });
                }

                // charger les transmissions
                const transmissionsResponse = await fetch('api/transmissions.php');
                const transmissionsData = await transmissionsResponse.json();
                if (transmissionsData.success) {
                    const boiteSelect = document.getElementById('boite');
                    boiteSelect.innerHTML = '<option value="">Toutes les transmissions</option>';
                    transmissionsData.transmissions.forEach(transmission => {
                        const option = document.createElement('option');
                        option.value = transmission;
                        option.textContent = transmission;
                        boiteSelect.appendChild(option);
                    });
                }
            } catch (error) {
                console.error('Error loading filters:', error);
                notyf.error('Erreur lors du chargement des filtres');
            }
        }

        // Chercher les voitures
        async function searchVehicles() {
            showLoading();
            
            try {
                // construire les paramètres de la requête
                const params = new URLSearchParams();
                
                // Ajouter chaque valeur de filtre avec un log de débogage
                const marque = document.getElementById('marque').value;
                const type = document.getElementById('type').value;
                const energie = document.getElementById('energie').value;
                const boite = document.getElementById('boite').value;
                const anneeMin = document.getElementById('annee_min').value;
                const anneeMax = document.getElementById('annee_max').value;
                const prixMax = document.getElementById('prix_max').value;
                const sort = document.getElementById('sort').value;

                console.log('Selected brand:', marque);

                // Ajouter les paramètres uniquement s'ils ont une valeur
                if (marque) {
                    params.append('marque', marque);
                    console.log('Adding brand parameter:', marque);
                }
                if (type) params.append('type', type);
                if (energie) params.append('energie', energie);
                if (boite) params.append('boite', boite);
                if (anneeMin) params.append('annee_min', anneeMin);
                if (anneeMax) params.append('annee_max', anneeMax);
                if (prixMax) params.append('prix_max', prixMax);
                if (sort) params.append('sort', sort);

                // Log les paramètres de la requête
                const searchUrl = `api/advanced-search.php?${params.toString()}`;
                console.log('Search URL:', searchUrl);

                // Récupérer les résultats
                const response = await fetch(searchUrl);
                const data = await response.json();
                console.log('Search results:', data); // Log de débogage

                if (data.success) {
                    displayCars(data.cars);
                    document.getElementById('result-count').textContent = 
                        `${data.count} véhicule${data.count !== 1 ? 's' : ''} trouvé${data.count !== 1 ? 's' : ''}`;
                } else {
                    notyf.error('Erreur lors de la recherche');
                    console.error('Search error:', data.error);
                }
            } catch (error) {
                console.error('Search error:', error);
                notyf.error('Une erreur est survenue');
            } finally {
                hideLoading();
            }
        }
    </script>
</body>
</html>
