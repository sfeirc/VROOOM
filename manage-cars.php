<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Cars - Image Management</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">Car Image Management</h1>

        <!-- Section de recherche et de filtrage -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <input type="text" id="searchInput" placeholder="Search by brand or model..." 
                           class="w-full border border-gray-300 rounded-md p-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Brand</label>
                    <select id="brandFilter" class="w-full border border-gray-300 rounded-md p-2">
                        <option value="">All Brands</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                    <select id="typeFilter" class="w-full border border-gray-300 rounded-md p-2">
                        <option value="">All Types</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Grille de voitures -->
        <div id="carsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Les voitures seront chargées ici -->
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Charger les marques pour le filtrage
            fetch('api/brands.php')
                .then(response => response.json())
                .then(brands => {
                    const brandFilter = document.getElementById('brandFilter');
                    brands.forEach(brand => {
                        const option = document.createElement('option');
                        option.value = brand.IdMarque;
                        option.textContent = brand.NomMarque;
                        brandFilter.appendChild(option);
                    });
                });

            // Charger les types pour le filtrage
            fetch('api/types.php')
                .then(response => response.json())
                .then(types => {
                    const typeFilter = document.getElementById('typeFilter');
                    types.forEach(type => {
                        const option = document.createElement('option');
                        option.value = type.IdType;
                        option.textContent = type.NomType;
                        typeFilter.appendChild(option);
                    });
                });

            // Charger les voitures
            function loadCars() {
                const searchQuery = document.getElementById('searchInput').value;
                const brandFilter = document.getElementById('brandFilter').value;
                const typeFilter = document.getElementById('typeFilter').value;

                // Construire les paramètres de la requête
                const params = new URLSearchParams();
                if (searchQuery) params.append('q', searchQuery);
                if (brandFilter) params.append('marque', brandFilter);
                if (typeFilter) params.append('type', typeFilter);

                fetch(`api/search.php?${params.toString()}`)
                    .then(response => response.json())
                    .then(cars => {
                        const carsGrid = document.getElementById('carsGrid');
                        carsGrid.innerHTML = cars.map(car => `
                            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                                <div class="relative h-48">
                                    <img src="${car.Image || 'assets/images/placeholder.jpg'}" 
                                         alt="${car.NomMarque} ${car.Modele}"
                                         class="w-full h-full object-cover">
                                </div>
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold">${car.NomMarque} ${car.Modele}</h3>
                                    <p class="text-sm text-gray-600 mb-4">Type: ${car.NomType}</p>
                                    <div class="grid grid-cols-2 gap-2 text-sm mb-4">
                                        <div>Year: ${car.Annee}</div>
                                        <div>Power: ${car.Puissance} HP</div>
                                        <div>Fuel: ${car.Energie}</div>
                                        <div>Seats: ${car.NbPlaces}</div>
                                    </div>
                                    <a href="manage-images.html?id=${car.IdVoiture}" 
                                       class="block w-full bg-blue-600 text-white text-center py-2 rounded hover:bg-blue-700">
                                        Manage Images
                                    </a>
                                </div>
                            </div>
                        `).join('');
                    })
                    .catch(error => console.error('Error loading cars:', error));
            }

            // Ajouter des écouteurs d'événements
            document.getElementById('searchInput').addEventListener('input', loadCars);
            document.getElementById('brandFilter').addEventListener('change', loadCars);
            document.getElementById('typeFilter').addEventListener('change', loadCars);

            // Charger les voitures au chargement de la page
            loadCars();
        });
    </script>
</body>
</html> 