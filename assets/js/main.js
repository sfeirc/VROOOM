document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content Loaded');
    // Charger les voitures en vedette
    loadFeaturedCars();
    
    // Charger les marques et les types pour le formulaire de recherche
    loadBrandsAndTypes();
    
    // Gestion du formulaire de recherche
    const searchForm = document.getElementById('search-form');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            // Récupérer les valeurs des filtres
            const filters = getFilterValues();
            // Créer une URLSearchParams
            const params = new URLSearchParams();
            // Ajouter les filtres à l'URL
            if (filters.brand) params.append('marque', filters.brand);
            if (filters.type) params.append('type', filters.type);
            
            // Rediriger à la page de recherche avec les filtres
            window.location.href = `search.html${params.toString() ? '?' + params.toString() : ''}`;
        });
    }
});
// Charger les voitures en vedette
async function loadFeaturedCars() {
    try {
        // Récupérer les voitures en vedette
        const response = await fetch('api/featured-cars.php');
        const data = await response.json();
        // Vérifier si les voitures en vedette ont été chargées avec succès
        if (!data.success) {
            throw new Error(data.error || 'Failed to load featured cars');
        }
        // Récupérer le conteneur des voitures en vedette
        const featuredCarsContainer = document.getElementById('featured-cars');
        // Vérifier si le conteneur des voitures en vedette existe
        if (!featuredCarsContainer) {
            console.log('Featured cars container not found');
            return;
        }
        // Effacer le contenu du conteneur des voitures en vedette
        featuredCarsContainer.innerHTML = '';
        // Vérifier si l'utilisateur est authentifié    
        const authenticated = await isAuthenticated();
        // Parcourir les voitures en vedette
        data.cars.forEach(car => {
            const carElement = document.createElement('div');
            carElement.className = 'bg-white rounded-lg shadow-lg overflow-hidden transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl';
            // Récupérer l'image de la voiture
            const defaultImage = 'assets/images/car-placeholder.jpg';
            const image = car.Photo && car.Photo !== '' ? car.Photo : defaultImage;
            // Ajouter le contenu de la voiture au conteneur
            carElement.innerHTML = `
                <div class="relative">
                    <img src="${image}" 
                         alt="${car.NomMarque} ${car.Modele}" 
                         class="w-full h-48 object-cover"
                         onerror="this.onerror=null; this.src='${defaultImage}';">
                </div>
                <div class="p-4">
                    <h3 class="text-xl font-semibold mb-2">${car.NomMarque} ${car.Modele}</h3>
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-2xl font-bold text-blue-600">${car.PrixLocation}€<span class="text-sm text-gray-600">/jour</span></span>
                        <span class="text-sm text-gray-600">${car.NomType}</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2 text-sm text-gray-600 mb-4">
                        <div><i class="fas fa-calendar-alt mr-1"></i> ${car.Annee}</div>
                        <div><i class="fas fa-gas-pump mr-1"></i> ${car.Energie}</div>
                        <div><i class="fas fa-cog mr-1"></i> ${car.BoiteVitesse}</div>
                        <div><i class="fas fa-users mr-1"></i> ${car.NbPlaces} places</div>
                    </div>
                    ${authenticated ? `
                        <a href="reserver.html?id=${car.IdVoiture}" 
                           class="block w-full bg-blue-600 text-white text-center py-2 rounded hover:bg-blue-700 transition-colors">
                            Réserver
                        </a>
                    ` : ''}
                </div>
            `;
            // Ajouter la voiture au conteneur
            featuredCarsContainer.appendChild(carElement);
        });
    } catch (error) {
        // Log l'erreur
        console.error('Error loading featured cars:', error);
    }
}

async function loadBrandsAndTypes() {
    try {
        // Log l'information
        console.log('Fetching brands and types...');
        // Récupérer les marques et les types
        const [brandsResponse, typesResponse] = await Promise.all([
            fetch('api/brands.php'),
            fetch('api/types.php')
        ]);
        // Vérifier si les marques ont été chargées avec succès
        if (!brandsResponse.ok) {
            throw new Error(`HTTP error! status: ${brandsResponse.status}`);
        }
        if (!typesResponse.ok) {
            throw new Error(`HTTP error! status: ${typesResponse.status}`);
        }
        // Récupérer les marques et les types
        const brands = await brandsResponse.json();
        const types = await typesResponse.json();
        // Log les marques et les types
        console.log('Brands loaded:', brands);
        console.log('Types loaded:', types);
        // Récupérer les sélecteurs de marques et de types
        const brandSelect = document.querySelector('select[name="marque"]');
        const typeSelect = document.querySelector('select[name="type"]');
        // Vérifier si le sélecteur de marques existe
        if (!brandSelect) {
            console.error('Brand select element not found!');
            return;
        }
        if (!typeSelect) {
            console.error('Type select element not found!');
            return;
        }
        // Effacer les options existantes sauf la première
        brandSelect.innerHTML = '<option value="">Toutes les marques</option>';
        typeSelect.innerHTML = '<option value="">Tous les types</option>';
        // Parcourir les marques
        brands.forEach(brand => {
            const option = document.createElement('option');
            option.value = brand.IdMarque;
            option.textContent = brand.NomMarque;
            brandSelect.appendChild(option);
        });
        // Parcourir les types
        types.forEach(type => {
            const option = document.createElement('option');
            option.value = type.IdType;
            option.textContent = type.NomType;
            typeSelect.appendChild(option);
        });
    } catch (error) {
        // Log l'erreur
        console.error('Error loading brands and types:', error);
    }
} 