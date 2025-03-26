document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content Loaded');
    // Charger les voitures en vedette
    loadFeaturedCars();
    
    // Charger les marques et les types pour le formulaire de recherche
    loadBrandsAndTypes();
});

async function loadFeaturedCars() {
    try {
        const response = await fetch('api/featured-cars.php');
        const cars = await response.json();
        
        const featuredCarsContainer = document.getElementById('featured-cars');
        if (!featuredCarsContainer) return;

        featuredCarsContainer.innerHTML = '';
        
        cars.forEach(car => {
            const carElement = document.createElement('div');
            carElement.className = 'bg-white rounded-lg shadow-lg overflow-hidden transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl';
            
            const defaultImage = 'assets/images/car-placeholder.jpg';
            const image = car.Photo && car.Photo !== '' ? car.Photo : defaultImage;
            
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
                    <a href="reserver.html?id=${car.IdVoiture}" 
                       class="block w-full bg-blue-600 text-white text-center py-2 rounded hover:bg-blue-700 transition-colors">
                        Réserver
                    </a>
                </div>
            `;
            
            featuredCarsContainer.appendChild(carElement);
        });
    } catch (error) {
        console.error('Error loading featured cars:', error);
    }
}

async function loadBrandsAndTypes() {
    try {
        console.log('Fetching brands and types...');
        const [brandsResponse, typesResponse] = await Promise.all([
            fetch('api/brands.php'),
            fetch('api/types.php')
        ]);

        if (!brandsResponse.ok) {
            throw new Error(`HTTP error! status: ${brandsResponse.status}`);
        }
        if (!typesResponse.ok) {
            throw new Error(`HTTP error! status: ${typesResponse.status}`);
        }

        const brands = await brandsResponse.json();
        const types = await typesResponse.json();
        
        console.log('Brands loaded:', brands);
        console.log('Types loaded:', types);
        
        const brandSelect = document.querySelector('select[name="marque"]');
        const typeSelect = document.querySelector('select[name="type"]');
        
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
        
        brands.forEach(brand => {
            const option = document.createElement('option');
            option.value = brand.IdMarque;
            option.textContent = brand.NomMarque;
            brandSelect.appendChild(option);
        });
        
        types.forEach(type => {
            const option = document.createElement('option');
            option.value = type.IdType;
            option.textContent = type.NomType;
            typeSelect.appendChild(option);
        });
    } catch (error) {
        console.error('Error loading brands and types:', error);
    }
}

// Gestion du formulaire de recherche
document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.getElementById('search-form');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const filters = getFilterValues();
            const params = new URLSearchParams();
            
            if (filters.brand) params.append('marque', filters.brand);
            if (filters.type) params.append('type', filters.type);
            
            // Rediriger à la page de recherche avec les filtres
            window.location.href = `search.html${params.toString() ? '?' + params.toString() : ''}`;
        });
    }

    // Charger les voitures en vedette sur la page d'accueil
    loadFeaturedCars();
}); 