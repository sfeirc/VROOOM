<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vroom Prestige - Location de Voitures de Luxe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script src="assets/js/filters.js"></script>
    <script src="assets/js/auth-check.js"></script>
    <script src="assets/js/main.js"></script>
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="/" class="flex-shrink-0">
                        <img class="h-8 w-auto" src="assets/images/logo.png" alt="Vroom Prestige">
                    </a>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="index.html" class="text-gray-800 hover:text-gray-600 px-3 py-2 rounded-md font-medium">Accueil</a>
                        <a href="search.html" class="text-gray-800 hover:text-gray-600 px-3 py-2 rounded-md font-medium">Rechercher</a>
                        <a href="contact.html" class="text-gray-800 hover:text-gray-600 px-3 py-2 rounded-md font-medium">Contact</a>
                        <a href="login_register.html" class="bg-blue-600 text-white px-4 py-2 rounded-md font-medium hover:bg-blue-700">Connexion</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative bg-gray-900 h-[600px]">
        <div class="absolute inset-0">
            <img class="w-full h-full object-cover" src="assets/images/hero-bg.jpg" alt="Luxury cars">
            <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
        </div>
        <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">Vroom Prestige</h1>
            <p class="mt-6 text-xl text-gray-300 max-w-3xl">Découvrez notre collection exclusive de voitures de luxe et vivez une expérience de conduite incomparable.</p>
            
            <!-- Search Form -->
            <div class="mt-10 max-w-xl bg-white rounded-lg shadow-xl p-6">
                <form id="search-form" class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="brand-select" class="block text-sm font-medium text-gray-700 mb-1">Marque</label>
                            <select id="brand-select" name="marque" data-filter="brand" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Toutes les marques</option>
                            </select>
                        </div>
                        <div>
                            <label for="type-select" class="block text-sm font-medium text-gray-700 mb-1">Type de véhicule</label>
                            <select id="type-select" name="type" data-filter="type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Tous les types</option>
                            </select>
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md font-medium hover:bg-blue-700">
                            Rechercher
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Featured Cars Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-3xl font-extrabold text-gray-900">Véhicules en vedette</h2>
        <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3" id="featured-cars">
            <!-- Cars will be loaded dynamically -->
        </div>
    </div>

    <!-- Why Choose Us Section -->
    <div class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-gray-900 text-center">Pourquoi nous choisir ?</h2>
            <div class="mt-10 grid gap-10 sm:grid-cols-2 lg:grid-cols-3">
                <div class="text-center">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white mx-auto">
                        <i class="fas fa-car text-xl"></i>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Véhicules Premium</h3>
                    <p class="mt-2 text-base text-gray-500">Une sélection exclusive de voitures de luxe et de prestige.</p>
                </div>
                <div class="text-center">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white mx-auto">
                        <i class="fas fa-shield-alt text-xl"></i>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Service Premium</h3>
                    <p class="mt-2 text-base text-gray-500">Un service client disponible 24/7 pour vous accompagner.</p>
                </div>
                <div class="text-center">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white mx-auto">
                        <i class="fas fa-money-bill-wave text-xl"></i>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Prix Transparent</h3>
                    <p class="mt-2 text-base text-gray-500">Des tarifs clairs sans frais cachés.</p>
                </div>
            </div>
        </div>
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

    <script src="assets/js/main.js"></script>
    <script>
    // mettre a jour la fonction performSearch pour utiliser les nouvelles valeurs des filtres
    async function performSearch() {
        const filters = getFilterValues();
        const params = new URLSearchParams();
        
        if (filters.brand) params.append('marque', filters.brand);
        if (filters.type) params.append('type', filters.type);
        
        try {
            const response = await fetch(`api/search.php?${params.toString()}`);
            const data = await response.json();
            updateSearchResults(data);
        } catch (error) {
            console.error('Error performing search:', error);
        }
    }

    // mettre a jour les resultats de la recherche
    function updateSearchResults(data) {
        const resultsContainer = document.getElementById('search-results');
        resultsContainer.innerHTML = '';
        
        if (!data || data.length === 0) {
            resultsContainer.innerHTML = `
                <div class="text-center py-8">
                    <p class="text-gray-500">Aucun véhicule trouvé correspondant à vos critères.</p>
                </div>
            `;
            return;
        }
        
        data.forEach(car => {
            const carElement = document.createElement('div');
            carElement.className = 'bg-white rounded-lg shadow-md overflow-hidden';
            carElement.innerHTML = `
                <div class="relative">
                    <img src="${car.Image || 'assets/images/placeholder.jpg'}" 
                         alt="${car.NomMarque} ${car.Modele}"
                         class="w-full h-48 object-cover">
                    <div class="absolute top-2 right-2 bg-blue-600 text-white px-2 py-1 rounded-md">
                        ${car.PrixLocation}€/day
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-semibold">${car.NomMarque} ${car.Modele}</h3>
                    <p class="text-sm text-gray-600 mb-2">${car.NomType}</p>
                    <div class="grid grid-cols-2 gap-2 text-sm text-gray-600 mb-4">
                        <div><i class="fas fa-calendar-alt mr-1"></i> ${car.Annee}</div>
                        <div><i class="fas fa-gas-pump mr-1"></i> ${car.Energie}</div>
                        <div><i class="fas fa-cog mr-1"></i> ${car.BoiteVitesse}</div>
                        <div><i class="fas fa-users mr-1"></i> ${car.NbPlaces} seats</div>
                    </div>
                    <a href="reserver.html?id=${car.IdVoiture}" 
                       class="block w-full bg-blue-600 text-white text-center py-2 rounded hover:bg-blue-700">
                        Reserver maintenant
                    </a>
                </div>
            `;
            resultsContainer.appendChild(carElement);
        });
    }

    // Gérer la soumission du formulaire de recherche
    document.getElementById('search-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const brand = document.getElementById('brand-select').value;
        const type = document.getElementById('type-select').value;
        
        // Construire la chaine de requete
        const params = new URLSearchParams();
        if (brand) params.append('marque', brand);
        if (type) params.append('type', type);
        
        // Rediriger vers search.html avec les paramètres
        window.location.href = `search.html${params.toString() ? '?' + params.toString() : ''}`;
    });
    </script>
</body>
</html>
