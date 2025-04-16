// Variables globales pour stocker l'état des filtres
let currentFilters = {};
let availableFilters = {};

// Initialiser l'interface de recherche
async function initializeSearch() {
    // Chargement initial des filtres disponibles
    await updateAvailableFilters();
    
    // Configuration des écouteurs d'événements
    setupFilterListeners();
    
    // Effectuer la recherche initiale
    performSearch();
}

// Mettre à jour les filtres disponibles en fonction de la sélection actuelle
async function updateAvailableFilters() {
    try {
        const queryParams = new URLSearchParams(currentFilters);
        const response = await fetch(`api/advanced-search.php?${queryParams}`);
        const data = await response.json();
        
        // Vérifier si les filtres ont été chargés avec succès  
        if (data.success) {
            // Mettre à jour les filtres disponibles
            availableFilters = data.filters;
            // Mettre à jour l'interface des filtres
            updateFilterUI();
        }
    } catch (error) {
        console.error('Error updating filters:', error);
    }
}

// Mettre à jour l'interface des filtres en fonction des options disponibles
function updateFilterUI() {
    // Mettre à jour la sélection des marques
    const brandSelect = document.getElementById('marque');
    updateSelect(brandSelect, availableFilters.marques);

    // Mettre à jour la sélection des types
    const typeSelect = document.getElementById('type');
    updateSelect(typeSelect, availableFilters.types);

    // Mettre à jour la sélection de l'énergie
    const fuelSelect = document.getElementById('energie');
    updateSelectSimple(fuelSelect, availableFilters.energies);

    // Mettre à jour la sélection de la boîte de vitesse
    const transmissionSelect = document.getElementById('boite');
    updateSelectSimple(transmissionSelect, availableFilters.boites);

    // Mettre à jour la sélection du nombre de places
    const seatsSelect = document.getElementById('places');
    updateSelectSimple(seatsSelect, availableFilters.places);

    // Mettre à jour la plage de puissance
    const powerMinInput = document.getElementById('puissance_min');
    const powerMaxInput = document.getElementById('puissance_max');
    if (availableFilters.puissance) {
        // Mettre à jour la plage de puissance
        powerMinInput.min = availableFilters.puissance.min;
        powerMinInput.max = availableFilters.puissance.max;
        powerMaxInput.min = availableFilters.puissance.min;
        powerMaxInput.max = availableFilters.puissance.max;
    }

    // Mettre à jour la plage d'années
    const yearMinInput = document.getElementById('annee_min');
    const yearMaxInput = document.getElementById('annee_max');
    if (availableFilters.annees) {
        // Mettre à jour la plage d'années
        yearMinInput.min = availableFilters.annees.min;
        yearMinInput.max = availableFilters.annees.max;
        yearMaxInput.min = availableFilters.annees.min;
        yearMaxInput.max = availableFilters.annees.max;
    }
}

// aide pour mettre à jour les sélections
function updateSelect(selectElement, options) {
    const currentValue = selectElement.value;
    selectElement.innerHTML = '<option value="">All</option>';
    
    // Parcourir les options
    Object.entries(options).forEach(([value, label]) => {
        // Créer une option
        const option = document.createElement('option');
        // Définir la valeur de l'option
        option.value = value;
        // Définir le texte de l'option
        option.textContent = label;
        // Ajouter l'option au sélecteur
        selectElement.appendChild(option);
    });
    // Vérifier si la valeur actuelle existe et est incluse dans les options
    if (currentValue && Object.keys(options).includes(currentValue)) {
        // Mettre à jour la valeur du sélecteur
        selectElement.value = currentValue;
    }
}

// aide pour mettre à jour les sélections
function updateSelectSimple(selectElement, options) {
    const currentValue = selectElement.value;
    selectElement.innerHTML = '<option value="">All</option>';
    // Parcourir les options
    options.forEach(value => {
        // Créer une option
        const option = document.createElement('option');
        // Définir la valeur de l'option
        option.value = value;
        // Définir le texte de l'option
        option.textContent = value;
        // Ajouter l'option au sélecteur
        selectElement.appendChild(option);
    });
    // Vérifier si la valeur actuelle existe et est incluse dans les options
    if (currentValue && options.includes(currentValue)) {
        // Mettre à jour la valeur du sélecteur
        selectElement.value = currentValue;
    }
}

// Mettre en place les écouteurs d'événements pour tous les filtres
function setupFilterListeners() {
    const filterElements = document.querySelectorAll('[data-filter]');
    filterElements.forEach(element => {
        element.addEventListener('change', async () => {
            const filterName = element.dataset.filter;
            const value = element.value;
            // Vérifier si la valeur existe
            if (value) {
                // Ajouter la valeur au filtre
                currentFilters[filterName] = value;
            } else {
                // Supprimer la valeur du filtre
                delete currentFilters[filterName];
            }
            // Mettre à jour les filtres disponibles
            await updateAvailableFilters();
            // Effectuer la recherche
            performSearch();
        });
    });
}

// Effectuer la recherche avec les filtres actuels
async function performSearch() {
    try {
        const queryParams = new URLSearchParams(currentFilters);
        const response = await fetch(`api/advanced-search.php?${queryParams}`);
        const data = await response.json();
        // Vérifier si les résultats ont été chargés avec succès
        if (data.success) {
            // Afficher les résultats
            displayResults(data.cars);
            // Mettre à jour le nombre de résultats
            updateResultCount(data.count);
        }
    } catch (error) {
        console.error('Error performing search:', error);
    }
}

// Afficher les résultats de la recherche
function displayResults(cars) {
    const resultsContainer = document.getElementById('search-results');
    resultsContainer.innerHTML = '';
    // Parcourir les voitures
    cars.forEach(car => {
        // Créer un élément de voiture
        const carElement = createCarElement(car);
        // Ajouter l'élément de voiture au conteneur
        resultsContainer.appendChild(carElement);
    });
}

// Créer un élément de voiture
function createCarElement(car) {
    const article = document.createElement('article');
    article.className = 'bg-white rounded-lg shadow-md overflow-hidden';
    // Ajouter le contenu de la voiture au conteneur
    article.innerHTML = `
        <div class="relative">
            <img src="${car.Image}" alt="${car.Modele}" class="w-full h-48 object-cover">
            ${car.isAvailable === false ? '<span class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded">Not Available</span>' : ''}
        </div>
        <div class="p-4">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-xl font-semibold">${car.NomMarque} ${car.Modele}</h3>
                <span class="text-lg font-bold text-blue-600">€${car.PrixLocation}/day</span>
            </div>
            <div class="grid grid-cols-2 gap-2 text-sm text-gray-600">
                <div>Type: ${car.NomType}</div>
                <div>Year: ${car.Annee}</div>
                <div>Power: ${car.Puissance} HP</div>
                <div>Seats: ${car.NbPlaces}</div>
                <div>Fuel: ${car.Energie}</div>
                <div>Transmission: ${car.BoiteVitesse}</div>
            </div>
            <button onclick="window.location.href='reserver.html?id=${car.IdVoiture}'" 
                    class="mt-4 w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition-colors">
                Book Now
            </button>
        </div>
    `;
    // Retourner l'élément de voiture
    return article;
}

// Mettre à jour le nombre de résultats
function updateResultCount(count) {
    const countElement = document.getElementById('result-count');
    if (countElement) {
        countElement.textContent = `${count} vehicle${count !== 1 ? 's' : ''} found`;
    }
}

// Initialiser la recherche au chargement de la page
document.addEventListener('DOMContentLoaded', initializeSearch); 