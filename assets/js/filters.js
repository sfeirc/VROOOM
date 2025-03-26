// Variables globales pour suivre les sélections actuelles
let currentBrandId = null;
let currentTypeId = null;

// Fonction pour charger les marques et les types
async function loadBrandsAndTypes() {
    try {
        // Charger les marques
        const brandsResponse = await fetch('api/brands.php');
        const brandsData = await brandsResponse.json();
        
        // Charger les types
        const typesResponse = await fetch('api/types.php');
        const typesData = await typesResponse.json();

        if (brandsData.success && brandsData.brands) {
            updateBrandSelect(brandsData.brands);
        }

        if (typesData.success && typesData.types) {
            updateTypeSelect(typesData.types);
        }

        return {
            brands: brandsData.brands || [],
            types: typesData.types || []
        };
    } catch (error) {
        console.error('Error loading brands and types:', error);
        return { brands: [], types: [] };
    }
}

// Mettre à jour les options de la sélection des marques
function updateBrandSelect(brands) {
    const brandSelects = document.querySelectorAll('[data-filter="brand"]');
    brandSelects.forEach(select => {
        const currentValue = select.value;
        select.innerHTML = '<option value="">Toutes les marques</option>';
        
        brands.forEach(brand => {
            const option = document.createElement('option');
            option.value = brand.IdMarque;
            option.textContent = brand.NomMarque;
            select.appendChild(option);
        });

        // Restaurer la sélection précédente si elle existe dans les nouvelles options
        if (currentValue && brands.some(b => b.IdMarque === currentValue)) {
            select.value = currentValue;
        }
    });
}

// Mettre à jour les options de la sélection des types
function updateTypeSelect(types) {
    const typeSelects = document.querySelectorAll('[data-filter="type"]');
    typeSelects.forEach(select => {
        const currentValue = select.value;
        select.innerHTML = '<option value="">Tous les types</option>';
        
        types.forEach(type => {
            const option = document.createElement('option');
            option.value = type.IdType;
            option.textContent = type.NomType;
            select.appendChild(option);
        });

        // Restaurer la sélection précédente si elle existe dans les nouvelles options
        if (currentValue && types.some(t => t.IdType === currentValue)) {
            select.value = currentValue;
        }
    });
}

// Réinitialiser tous les filtres à l'état initial
async function resetFilters() {
    currentBrandId = null;
    currentTypeId = null;
    await loadBrandsAndTypes();
}

// Récupérer les valeurs actuelles des filtres
function getFilterValues() {
    const brandSelect = document.querySelector('[data-filter="brand"]');
    const typeSelect = document.querySelector('[data-filter="type"]');
    
    return {
        brand: brandSelect ? brandSelect.value : null,
        type: typeSelect ? typeSelect.value : null
    };
}

// Initialiser les filtres au chargement du DOM
document.addEventListener('DOMContentLoaded', () => {
    loadBrandsAndTypes();
    
    // Ajouter des écouteurs d'événements aux sélections de filtre
    document.querySelectorAll('[data-filter]').forEach(select => {
        select.addEventListener('change', (e) => {
            if (e.target.dataset.filter === 'brand') {
                currentBrandId = e.target.value;
            } else if (e.target.dataset.filter === 'type') {
                currentTypeId = e.target.value;
            }
        });
    });
}); 