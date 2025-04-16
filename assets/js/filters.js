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

        // Vérifier si les marques ont été chargées avec succès
        if (brandsData.success && brandsData.brands) {
            // Mettre à jour la sélection des marques
            updateBrandSelect(brandsData.brands);
        }

        // Vérifier si les types ont été chargés avec succès
        if (typesData.success && typesData.types) {
            // Mettre à jour la sélection des types
            updateTypeSelect(typesData.types);
        }

        // Retourner les marques et les types
        return {
            brands: brandsData.brands || [],
            types: typesData.types || []
        };
    } catch (error) {
        // Log l'erreur
        console.error('Error loading brands and types:', error);
        // Retourner un tableau vide
        return { brands: [], types: [] };
    }
}

// Mettre à jour les options de la sélection des marques
function updateBrandSelect(brands) {
    const brandSelects = document.querySelectorAll('[data-filter="brand"]');
    brandSelects.forEach(select => {
        const currentValue = select.value;
        select.innerHTML = '<option value="">Toutes les marques</option>';
        // Parcourir les marques    
        brands.forEach(brand => {
            // Créer une option
            const option = document.createElement('option');
            // Définir la valeur de l'option
            option.value = brand.IdMarque;
            // Définir le texte de l'option
            option.textContent = brand.NomMarque;
            // Ajouter l'option au sélecteur
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