<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - Vroom Prestige</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f6f9fc 0%, #edf2f7 100%);
        }
        .profile-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .profile-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .stats-card {
            animation: fadeIn 0.6s ease-out;
            transition: all 0.3s ease;
        }
        .stats-card:hover {
            transform: translateY(-3px);
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .profile-image-container {
            position: relative;
            transition: transform 0.3s ease;
        }
        .profile-image-container:hover {
            transform: scale(1.05);
        }
        .input-animated {
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        .input-animated:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            transform: translateY(-1px);
        }
        .save-button {
            transition: all 0.3s ease;
        }
        .save-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.2);
        }
    </style>
</head>
<body class="min-h-screen">
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
                        <div class="relative" id="profile-menu">
                            <button class="text-blue-600 border-b-2 border-blue-600 px-3 py-2 rounded-md font-medium flex items-center">
                                <span id="user-name">Mon Profil</span>
                                <i class="fas fa-chevron-down ml-2"></i>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden" id="profile-dropdown">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" id="edit-profile-btn">
                                    <i class="fas fa-user-edit mr-2"></i>Modifier le profil
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" id="my-reservations-btn">
                                    <i class="fas fa-calendar-alt mr-2"></i>Mes réservations
                                </a>
                                <hr class="my-1">
                                <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100" id="logout-btn">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Profile Header Card -->
        <div class="profile-card rounded-xl shadow-lg p-8 mb-8">
            <div class="flex flex-col md:flex-row items-center md:items-start space-y-6 md:space-y-0 md:space-x-8">
                <div class="profile-image-container">
                    <img id="profile-image" src="assets/images/default-profile.png" alt="Photo de profil" 
                         class="w-32 h-32 rounded-full object-cover border-4 border-blue-600 shadow-lg">
                    <button id="change-photo-btn" class="absolute bottom-0 right-0 bg-blue-600 text-white rounded-full p-3 shadow-lg hover:bg-blue-700 transition-all">
                        <i class="fas fa-camera"></i>
                    </button>
                </div>
                <div class="flex-1 text-center md:text-left">
                    <h1 id="profile-name" class="text-3xl font-bold text-gray-900 mb-2"></h1>
                    <p id="profile-email" class="text-lg text-gray-600 mb-2"></p>
                    <p class="text-sm text-gray-500 mb-4">Membre depuis <span id="member-since" class="font-medium"></span></p>
                    <div class="flex flex-wrap justify-center md:justify-start gap-4">
                        <div class="stats-card bg-blue-50 rounded-lg p-4 text-center min-w-[150px]">
                            <p class="text-2xl font-bold text-blue-600" id="reservations-count">0</p>
                            <p class="text-sm text-gray-600">Réservations</p>
                        </div>
                        <div class="stats-card bg-purple-50 rounded-lg p-4 text-center min-w-[150px]">
                            <p class="text-2xl font-bold text-purple-600" id="favorites-count">0</p>
                            <p class="text-sm text-gray-600">Favoris</p>
                        </div>
                        <div class="stats-card bg-green-50 rounded-lg p-4 text-center min-w-[150px]">
                            <p class="text-2xl font-bold text-green-600" id="reviews-count">0</p>
                            <p class="text-sm text-gray-600">Avis</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Form Card -->
        <div class="profile-card rounded-xl shadow-lg p-8">
            <form id="profile-form" class="space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
                        <input type="text" name="nom" class="input-animated w-full px-4 py-3 rounded-lg bg-gray-50 focus:bg-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Prénom</label>
                        <input type="text" name="prenom" class="input-animated w-full px-4 py-3 rounded-lg bg-gray-50 focus:bg-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" class="input-animated w-full px-4 py-3 rounded-lg bg-gray-50 focus:bg-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                        <input type="tel" name="tel" class="input-animated w-full px-4 py-3 rounded-lg bg-gray-50 focus:bg-white">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Adresse</label>
                        <input type="text" name="adresse" class="input-animated w-full px-4 py-3 rounded-lg bg-gray-50 focus:bg-white">
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-8 mt-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Changer le mot de passe</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mot de passe actuel</label>
                            <input type="password" name="current_password" class="input-animated w-full px-4 py-3 rounded-lg bg-gray-50 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nouveau mot de passe</label>
                            <input type="password" name="new_password" class="input-animated w-full px-4 py-3 rounded-lg bg-gray-50 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Confirmer le mot de passe</label>
                            <input type="password" name="confirm_password" class="input-animated w-full px-4 py-3 rounded-lg bg-gray-50 focus:bg-white">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 pt-6">
                    <button type="button" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-all" id="cancel-btn">
                        Annuler
                    </button>
                    <button type="submit" class="save-button px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class="fas fa-save mr-2"></i>Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>

        <!-- Logout Section -->
        <div class="profile-card rounded-xl shadow-lg p-8 mt-8">
            <div class="flex flex-col items-center text-center">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Déconnexion</h3>
                <p class="text-gray-600 mb-6">Vous souhaitez vous déconnecter de votre compte ?</p>
                <button id="logout-btn-bottom" class="flex items-center px-8 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all transform hover:scale-105 hover:shadow-lg">
                    <i class="fas fa-sign-out-alt mr-2"></i>
                    Se déconnecter
                </button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script>
        // Initialiser Notyf
        const notyf = new Notyf({
            duration: 3000,
            position: { x: 'right', y: 'top' },
            types: [
                {
                    type: 'success',
                    background: '#3b82f6',
                    icon: {
                        className: 'fas fa-check',
                        tagName: 'i',
                        color: '#fff'
                    }
                },
                {
                    type: 'error',
                    background: '#ef4444',
                    icon: {
                        className: 'fas fa-times',
                        tagName: 'i',
                        color: '#fff'
                    }
                }
            ]
        });

        // Basculer la liste déroulante des profils
        const profileMenu = document.getElementById('profile-menu');
        const profileDropdown = document.getElementById('profile-dropdown');

        profileMenu.addEventListener('click', () => {
            profileDropdown.classList.toggle('hidden');
        });

        // Fermer la liste déroulante lors d'un clic en dehors
        document.addEventListener('click', (e) => {
            if (!profileMenu.contains(e.target)) {
                profileDropdown.classList.add('hidden');
            }
        });

        // Charger les données de l'utilisateur et les statistiques
        async function loadUserData() {
            try {
                const formData = new FormData();
                formData.append('action', 'check-auth');
                
                const response = await fetch('api/auth.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (!data.success || !data.isAuthenticated) {
                    window.location.href = 'login_register.html';
                    return;
                }

                // Mettre à jour les informations du profil avec une animation de disparition
                const updateWithAnimation = (element, value) => {
                    element.style.opacity = '0';
                    element.textContent = value;
                    setTimeout(() => {
                        element.style.opacity = '1';
                    }, 100);
                };

                updateWithAnimation(document.getElementById('user-name'), `${data.user.prenom} ${data.user.nom}`);
                updateWithAnimation(document.getElementById('profile-name'), `${data.user.prenom} ${data.user.nom}`);
                updateWithAnimation(document.getElementById('profile-email'), data.user.email);
                
                // Remplir les champs du formulaire avec les valeurs par défaut si elles sont indéfinies
                const form = document.getElementById('profile-form');
                form.querySelector('[name="nom"]').value = data.user.nom || '';
                form.querySelector('[name="prenom"]').value = data.user.prenom || '';
                form.querySelector('[name="email"]').value = data.user.email || '';
                form.querySelector('[name="tel"]').value = data.user.tel || '';
                form.querySelector('[name="adresse"]').value = data.user.adresse || '';

                // Définir l'image de profil avec effet de fondu
                if (data.user.photo) {
                    const img = document.getElementById('profile-image');
                    img.style.opacity = '0';
                    img.src = data.user.photo;
                    img.onload = () => {
                        img.style.opacity = '1';
                    };
                }

                // Formater et définir la date de membre
                let memberSinceDate = 'Non disponible';
                if (data.user.dateInscription) {
                    try {
                        const memberSince = new Date(data.user.dateInscription);
                        if (!isNaN(memberSince.getTime())) {
                            memberSinceDate = memberSince.toLocaleDateString('fr-FR', {
                                day: 'numeric',
                                month: 'long',
                                year: 'numeric'
                            });
                        }
                    } catch (error) {
                        console.error('Error formatting date:', error);
                    }
                }
                updateWithAnimation(document.getElementById('member-since'), memberSinceDate);

                // Animer les compteurs de statistiques
                const animateCounter = (element, target) => {
                    let current = 0;
                    const increment = target / 30;
                    const interval = setInterval(() => {
                        current += increment;
                        if (current >= target) {
                            current = target;
                            clearInterval(interval);
                        }
                        element.textContent = Math.round(current);
                    }, 50);
                };

                // Simuler le chargement des statistiques (remplacer par les données réelles lorsqu'elles seront disponibles)
                setTimeout(() => {
                    animateCounter(document.getElementById('reservations-count'), data.user.reservations || 0);
                    animateCounter(document.getElementById('favorites-count'), data.user.favorites || 0);
                    animateCounter(document.getElementById('reviews-count'), data.user.reviews || 0);
                }, 500);

            } catch (error) {
                console.error('Error loading user data:', error);
                notyf.error('Erreur lors du chargement des données');
            }
        }

        // Gérer l'envoi du formulaire avec l'état de chargement
        document.getElementById('profile-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const submitButton = e.target.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Enregistrement...';
            submitButton.disabled = true;
            
            const formData = new FormData(e.target);
            formData.append('action', 'update_profile');
            
            try {
                const response = await fetch('api/auth.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    notyf.success('Profil mis à jour avec succès');
                    loadUserData(); // Recharger les données de l'utilisateur
                } else {
                    notyf.error(data.error || 'Erreur lors de la mise à jour');
                }
            } catch (error) {
                console.error('Error updating profile:', error);
                notyf.error('Erreur lors de la mise à jour');
            } finally {
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            }
        });

        // Gérer le changement de photo
        document.getElementById('change-photo-btn').addEventListener('click', () => {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/*';
            input.onchange = async (e) => {
                const file = e.target.files[0];
                if (file) {
                    const formData = new FormData();
                    formData.append('action', 'update_photo');
                    formData.append('photo', file);
                    
                    try {
                        const response = await fetch('api/auth.php', {
                            method: 'POST',
                            body: formData
                        });
                        
                        const data = await response.json();
                        
                        if (data.success) {
                            notyf.success('Photo de profil mise à jour');
                            loadUserData();
                        } else {
                            notyf.error(data.error || 'Erreur lors de la mise à jour de la photo');
                        }
                    } catch (error) {
                        console.error('Error updating photo:', error);
                        notyf.error('Erreur lors de la mise à jour de la photo');
                    }
                }
            };
            input.click();
        });

        // Gérer la déconnexion pour les deux boutons
        const handleLogout = async (e) => {
            e.preventDefault();
            
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
                notyf.error('Erreur lors de la déconnexion');
            }
        };

        // Ajouter des écouteurs d'événements pour les deux boutons de déconnexion
        document.getElementById('logout-btn').addEventListener('click', handleLogout);
        document.getElementById('logout-btn-bottom').addEventListener('click', handleLogout);

        // Charger les données de l'utilisateur au chargement de la page avec une animation de disparition
        document.addEventListener('DOMContentLoaded', () => {
            document.body.style.opacity = '0';
            loadUserData();
            setTimeout(() => {
                document.body.style.opacity = '1';
                document.body.style.transition = 'opacity 0.5s ease-in-out';
            }, 100);
        });
    </script>
</body>
</html> 