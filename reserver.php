<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réserver - Vroom Prestige</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #1a1a1a;
            color: white;
        }
        .calendar-day {
            transition: all 0.3s ease;
        }
        .calendar-day:hover:not(:disabled) {
            background-color: rgba(1, 152, 99, 0.2);
        }
        .calendar-day.selected {
            background-color: #019863 !important;
            color: white !important;
        }
    </style>
</head>
<body>
    <div class="min-h-screen">
        <div class="layout-container flex h-full grow flex-col">
            <!-- Navigation -->
            <header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-b-[#2E2E2E] px-10 py-3">
                <div class="flex items-center gap-4 text-[#FFFFFF]">
                    <div class="size-4">
                        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M36.7273 44C33.9891 44 31.6043 39.8386 30.3636 33.69C29.123 39.8386 26.7382 44 24 44C21.2618 44 18.877 39.8386 17.6364 33.69C16.3957 39.8386 14.0109 44 11.2727 44C7.25611 44 4 35.0457 4 24C4 12.9543 7.25611 4 11.2727 4C14.0109 4 16.3957 8.16144 17.6364 14.31C18.877 8.16144 21.2618 4 24 4C26.7382 4 29.123 8.16144 30.3636 14.31C31.6043 8.16144 33.9891 4 36.7273 4C40.7439 4 44 12.9543 44 24C44 35.0457 40.7439 44 36.7273 44Z" fill="currentColor"></path>
                        </svg>
                    </div>
                    <h2 class="text-[#FFFFFF] text-lg font-bold leading-tight tracking-[-0.015em]">VROUMMM Prestige</h2>
                </div>
                <div class="flex flex-1 justify-end gap-8">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <!-- Navigation will be injected here by auth-check.js -->
                    </div>
                </div>
            </header>

            <div class="gap-1 px-6 flex flex-1 justify-center py-5">
                <div class="layout-content-container flex flex-col max-w-[920px] flex-1">
                    <div id="car-details" class="mb-8">
                        <!-- Car details will be loaded here -->
                    </div>
                </div>
                <div class="layout-content-container flex flex-col w-[360px]">
                    <div class="flex flex-wrap items-center justify-center gap-6 p-4">
                        <div class="flex min-w-72 max-w-[336px] flex-1 flex-col gap-0.5">
                            <div id="calendar" class="grid grid-cols-7 gap-0">
                                <!-- Calendar will be generated here -->
                            </div>
                        </div>
                    </div>
                    <div class="flex px-4 py-3 justify-start">
                        <button id="book-button" class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-12 px-5 flex-1 bg-[#019863] text-[#FFFFFF] text-base font-bold leading-normal tracking-[0.015em] disabled:opacity-50 disabled:cursor-not-allowed">
                            <span class="truncate">Réserver</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script src="assets/js/auth-check.js"></script>
    <script>
        // Initialiser Notyf
        const notyf = new Notyf({
            duration: 3000,
            position: { x: 'right', y: 'top' }
        });

        // Récupérer l'ID de la voiture à partir de l'URL
        const urlParams = new URLSearchParams(window.location.search);
        const carId = urlParams.get('id');

        // Dates sélectionnées
        let selectedStartDate = null;
        let selectedEndDate = null;

        // Charger les détails de la voiture
        async function loadCarDetails() {
            try {
                const response = await fetch(`api/car-details.php?id=${carId}`);
                const data = await response.json();

                if (data.success) {
                    const carDetailsHtml = `
                        <div class="grid grid-cols-[repeat(auto-fit,minmax(158px,1fr))] gap-3 p-4">
                            <div class="flex flex-col gap-3">
                                <div class="w-full bg-center bg-no-repeat aspect-square bg-cover rounded-xl"
                                    style="background-image: url('${data.car.PhotoPrincipale}');">
                                </div>
                            </div>
                        </div>
                        <h1 class="text-[#FFFFFF] tracking-light text-[32px] font-bold leading-tight px-4 text-left pb-3 pt-6">
                            ${data.car.Marque} ${data.car.Modele}
                        </h1>
                        <div class="p-4 grid grid-cols-[20%_1fr] gap-x-6">
                            <div class="col-span-2 grid grid-cols-subgrid border-t border-t-[#3D3D3D] py-5">
                                <p class="text-[#999999] text-sm font-normal leading-normal">Marque</p>
                                <p class="text-[#FFFFFF] text-sm font-normal leading-normal">${data.car.Marque}</p>
                            </div>
                            <div class="col-span-2 grid grid-cols-subgrid border-t border-t-[#3D3D3D] py-5">
                                <p class="text-[#999999] text-sm font-normal leading-normal">Modèle</p>
                                <p class="text-[#FFFFFF] text-sm font-normal leading-normal">${data.car.Modele}</p>
                            </div>
                            <div class="col-span-2 grid grid-cols-subgrid border-t border-t-[#3D3D3D] py-5">
                                <p class="text-[#999999] text-sm font-normal leading-normal">Année</p>
                                <p class="text-[#FFFFFF] text-sm font-normal leading-normal">${data.car.Annee}</p>
                            </div>
                            <div class="col-span-2 grid grid-cols-subgrid border-t border-t-[#3D3D3D] py-5">
                                <p class="text-[#999999] text-sm font-normal leading-normal">Type</p>
                                <p class="text-[#FFFFFF] text-sm font-normal leading-normal">${data.car.Type}</p>
                            </div>
                            <div class="col-span-2 grid grid-cols-subgrid border-t border-t-[#3D3D3D] py-5">
                                <p class="text-[#999999] text-sm font-normal leading-normal">Prix journalier</p>
                                <p class="text-[#FFFFFF] text-sm font-normal leading-normal">${data.car.PrixJournalier}€ / jour</p>
                            </div>
                        </div>
                    `;
                    document.getElementById('car-details').innerHTML = carDetailsHtml;
                } else {
                    notyf.error('Erreur lors du chargement des détails du véhicule');
                }
            } catch (error) {
                console.error('Error loading car details:', error);
                notyf.error('Une erreur est survenue');
            }
        }

        // Générer le calendrier
        function generateCalendar() {
            const calendar = document.getElementById('calendar');
            calendar.innerHTML = '';

            // Ajouter les en-têtes de jour
            const days = ['D', 'L', 'M', 'M', 'J', 'V', 'S'];
            days.forEach(day => {
                const dayHeader = document.createElement('p');
                dayHeader.className = 'text-[#FFFFFF] text-[13px] font-bold leading-normal tracking-[0.015em] flex h-12 w-full items-center justify-center pb-0.5';
                dayHeader.textContent = day;
                calendar.appendChild(dayHeader);
            });

            // Récupérer la date du jour
            const today = new Date();
            const currentMonth = today.getMonth();
            const currentYear = today.getFullYear();

            // Récupérer le premier jour du mois et le nombre de jours
            const firstDay = new Date(currentYear, currentMonth, 1);
            const lastDay = new Date(currentYear, currentMonth + 1, 0);
            const daysInMonth = lastDay.getDate();

            // Ajouter des cellules vides pour les jours avant le premier jour du mois
            for (let i = 0; i < firstDay.getDay(); i++) {
                const emptyDay = document.createElement('div');
                emptyDay.className = 'h-12 w-full';
                calendar.appendChild(emptyDay);
            }

            // Ajouter les jours du calendrier
            for (let day = 1; day <= daysInMonth; day++) {
                const date = new Date(currentYear, currentMonth, day);
                const button = document.createElement('button');
                button.className = 'calendar-day h-12 w-full text-[#FFFFFF] text-sm font-medium leading-normal';
                button.innerHTML = `<div class="flex size-full items-center justify-center rounded-full">${day}</div>`;
                
                // Désactiver les dates passées
                if (date < today) {
                    button.disabled = true;
                    button.classList.add('opacity-50');
                } else {
                    button.addEventListener('click', () => handleDateSelection(date));
                }

                calendar.appendChild(button);
            }
        }

        // Gérer la sélection de date
        function handleDateSelection(date) {
            if (!selectedStartDate || (selectedStartDate && selectedEndDate)) {
                // Début d'une nouvelle sélection
                selectedStartDate = date;
                selectedEndDate = null;
            } else {
                // Compléter la sélection
                if (date > selectedStartDate) {
                    selectedEndDate = date;
                } else {
                    selectedEndDate = selectedStartDate;
                    selectedStartDate = date;
                }
            }

            // Mettre à jour l'interface du calendrier
            updateCalendarSelection();

            // Activer/désactiver le bouton de réservation
            const bookButton = document.getElementById('book-button');
            bookButton.disabled = !(selectedStartDate && selectedEndDate);
        }

        // Mettre à jour l'interface de sélection du calendrier
        function updateCalendarSelection() {
            const buttons = document.querySelectorAll('.calendar-day');
            buttons.forEach(button => {
                const buttonDate = new Date(
                    new Date().getFullYear(),
                    new Date().getMonth(),
                    parseInt(button.textContent)
                );

                button.querySelector('div').classList.remove('bg-[#019863]');
                
                if (selectedStartDate && selectedEndDate) {
                    if (buttonDate >= selectedStartDate && buttonDate <= selectedEndDate) {
                        button.querySelector('div').classList.add('bg-[#019863]');
                    }
                } else if (selectedStartDate && buttonDate.getTime() === selectedStartDate.getTime()) {
                    button.querySelector('div').classList.add('bg-[#019863]');
                }
            });
        }

        // Gérer la réservation
        async function handleBooking() {
            if (!selectedStartDate || !selectedEndDate) {
                notyf.error('Veuillez sélectionner les dates de réservation');
                return;
            }

            try {
                const formData = new FormData();
                formData.append('action', 'create_reservation');
                formData.append('car_id', carId);
                formData.append('start_date', selectedStartDate.toISOString().split('T')[0]);
                formData.append('end_date', selectedEndDate.toISOString().split('T')[0]);

                const response = await fetch('api/reservations.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    notyf.success('Réservation créée avec succès');
                    window.location.href = 'recapitulatif.html?reservation=' + data.reservationId;
                } else {
                    notyf.error(data.error || 'Erreur lors de la création de la réservation');
                }
            } catch (error) {
                console.error('Error creating reservation:', error);
                notyf.error('Une erreur est survenue');
            }
        }

        // Vérifier l'authentification au chargement de la page
        document.addEventListener('DOMContentLoaded', async () => {
            const authenticated = await isAuthenticated();
            if (!authenticated) {
                window.location.href = `login_register.html?redirect=${encodeURIComponent(window.location.href)}`;
                return;
            }

            // Initialiser la page
            updateNavigation();
            loadCarDetails();
            generateCalendar();

            // Ajouter un écouteur d'événements au bouton de réservation
            document.getElementById('book-button').addEventListener('click', handleBooking);
        });
    </script>
</body>
</html>
