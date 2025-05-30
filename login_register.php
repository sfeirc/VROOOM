<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Vroom Prestige</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f6f9fc 0%, #edf2f7 100%);
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .form-container {
            animation: slideUp 0.5s ease-out;
        }
        
        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .input-group input {
            width: 100%;
            padding: 0.75rem 1rem;
            padding-left: 2.5rem;
            border: 2px solid transparent;
            border-radius: 0.5rem;
            outline: none;
            background-color: #f8fafc;
            transition: all 0.3s ease;
        }
        
        .input-group input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }
        
        .input-group i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            transition: all 0.3s ease;
        }
        
        .input-group input:focus + i {
            color: #3b82f6;
        }
        
        .switch-form {
            position: relative;
            overflow: hidden;
        }
        
        .switch-form::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 50%;
            height: 100%;
            background: #3b82f6;
            border-radius: 0.5rem;
            transition: transform 0.3s ease;
        }
        
        .switch-form[data-active="register"]::before {
            transform: translateX(100%);
        }
        
        .switch-btn {
            position: relative;
            z-index: 1;
            transition: all 0.3s ease;
        }
        
        .switch-btn.active {
            color: white;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .social-btn {
            transition: all 0.3s ease;
        }
        
        .social-btn:hover {
            transform: translateY(-2px);
        }
        
        .bg-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239BA6B1' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="min-h-screen bg-pattern">
    <div class="container mx-auto px-4 py-8">
        <!-- Logo and Navigation -->
        <nav class="mb-8">
            <a href="index.html" class="inline-flex items-center space-x-2">
                <img src="assets/logo/logo.png" alt="Vroom Prestige" class="h-10">
                <span class="text-2xl font-bold text-gray-900">Vroom Prestige</span>
            </a>
        </nav>

        <!-- Main Content -->
        <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left Side - Welcome Message -->
            <div class="hidden lg:block">
                <h1 class="text-4xl font-bold text-gray-900 mb-6">
                    Bienvenue chez<br>
                    <span class="text-blue-600">Vroom Prestige</span>
                </h1>
                <p class="text-lg text-gray-600 mb-8">
                    Découvrez notre collection exclusive de voitures de luxe et vivez une expérience de conduite incomparable.
                </p>
                <div class="space-y-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-car-side text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Véhicules Premium</h3>
                            <p class="text-gray-600">Une sélection exclusive de voitures de luxe</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-shield-alt text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Réservation Sécurisée</h3>
                            <p class="text-gray-600">Processus de réservation simple et sûr</p>
                        </div>
                    </div>
                    
                </div>
            </div>

            <!-- Right Side - Login/Register Form -->
            <div class="form-container">
                <div class="glass-card rounded-2xl shadow-xl p-8 max-w-md mx-auto">
                    <!-- Form Switch -->
                    <div class="switch-form mb-8 bg-gray-100 p-1 rounded-lg flex" data-active="login">
                        <button class="switch-btn flex-1 py-2 text-center rounded-md active" data-form="login">
                            Connexion
                        </button>
                        <button class="switch-btn flex-1 py-2 text-center rounded-md" data-form="register">
                            Inscription
                        </button>
                    </div>

                    <!-- Login Form -->
                    <form id="login-form" class="space-y-6" onsubmit="return false;">
                        <div class="input-group">
                            <input type="email" name="email" placeholder="Email" required>
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="input-group">
                            <input type="password" name="password" placeholder="Mot de passe" required>
                            <i class="fas fa-lock"></i>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <label class="flex items-center space-x-2 text-gray-600">
                                <input type="checkbox" class="rounded border-gray-300 text-blue-600">
                                <span>Se souvenir de moi</span>
                            </label>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                            Se connecter
                        </button>
                    </form>

                    <!-- Register Form -->
                    <form id="register-form" class="hidden space-y-6" onsubmit="return false;">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="input-group">
                                <input type="text" name="nom" placeholder="Nom" required minlength="2">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="input-group">
                                <input type="text" name="prenom" placeholder="Prénom" required minlength="2">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                        <div class="input-group">
                            <input type="email" name="email" placeholder="Email" required>
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="input-group">
                            <input type="tel" name="tel" placeholder="Téléphone" pattern="[0-9]{10}" title="Numéro de téléphone à 10 chiffres">
                            <i class="fas fa-phone"></i>
                            <p class="text-sm text-gray-500 mt-1">Optionnel</p>
                        </div>
                        <div class="input-group">
                            <input type="text" name="adresse" placeholder="Adresse">
                            <i class="fas fa-map-marker-alt"></i>
                            <p class="text-sm text-gray-500 mt-1">Optionnel</p>
                        </div>
                        <div class="input-group">
                            <input type="password" name="password" placeholder="Mot de passe" required minlength="8">
                            <i class="fas fa-lock"></i>
                        </div>
                        <div class="input-group">
                            <input type="password" name="confirmPassword" placeholder="Confirmer le mot de passe" required minlength="8">
                            <i class="fas fa-lock"></i>
                        </div>
                        
                        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                            Créer un compte
                        </button>
                    </form>

                    <!-- Social Login -->
                    <div class="mt-8">
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-2 bg-white text-gray-500">Ou continuer avec</span>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button onclick="initiateGoogleLogin()" class="social-btn w-full flex justify-center items-center py-3 px-4 border border-gray-300 rounded-lg hover:bg-gray-50 space-x-2">
                                <i class="fab fa-google text-red-600"></i>
                                <span class="text-gray-700">Continuer avec Google</span>
                            </button>
                        </div>
                    </div>
                </div>
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
                    icon: false
                },
                {
                    type: 'error',
                    background: '#ef4444',
                    icon: false
                }
            ]
        });

        // Fonctionnalité de basculement des formulaires
        const switchBtns = document.querySelectorAll('.switch-btn');
        const loginForm = document.getElementById('login-form');
        const registerForm = document.getElementById('register-form');
        const switchForm = document.querySelector('.switch-form');

        switchBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const formType = btn.dataset.form;
                switchBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                
                if (formType === 'login') {
                    loginForm.classList.remove('hidden');
                    registerForm.classList.add('hidden');
                    switchForm.dataset.active = 'login';
                } else {
                    loginForm.classList.add('hidden');
                    registerForm.classList.remove('hidden');
                    switchForm.dataset.active = 'register';
                }
            });
        });

        // Gérer la soumission du formulaire de connexion
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData();
            formData.append('action', 'login');
            formData.append('email', loginForm.querySelector('input[name="email"]').value.trim());
            formData.append('password', loginForm.querySelector('input[name="password"]').value);
            
            try {
                const response = await fetch('api/auth.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    notyf.success('Connexion réussie');
                    // Rediriger à la page précédente ou à la page d'accueil
                    const redirectUrl = new URLSearchParams(window.location.search).get('redirect') || 'index.html';
                    window.location.href = redirectUrl;
                } else {
                    notyf.error(data.error || 'Erreur de connexion');
                }
            } catch (error) {
                notyf.error('Une erreur est survenue');
                console.error('Error:', error);
            }
        });

        // Gérer la soumission du formulaire d'inscription
        registerForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData();
            const fields = ['email', 'password', 'confirmPassword', 'nom', 'prenom', 'tel', 'adresse'];
            
            // Collecter toutes les données du formulaire
            fields.forEach(field => {
                const input = registerForm.querySelector(`input[name="${field}"]`);
                formData.append(field, input.value.trim());
            });
            
            // Valider que les mots de passe correspondent
            if (formData.get('password') !== formData.get('confirmPassword')) {
                notyf.error('Les mots de passe ne correspondent pas');
                return;
            }
            
            // Valider la longueur du mot de passe
            if (formData.get('password').length < 8) {
                notyf.error('Le mot de passe doit contenir au moins 8 caractères');
                return;
            }
            
            // Ajouter l'action au formData
            formData.append('action', 'register');
            
            try {
                console.log('Sending registration request...');
                const response = await fetch('api/auth.php', {
                    method: 'POST',
                    body: formData
                });
                
                console.log('Response received:', response);
                const data = await response.json();
                console.log('Response data:', data);
                
                if (data.success) {
                    notyf.success('Inscription réussie! Vous pouvez maintenant vous connecter.');
                    registerForm.reset();
                    switchBtns[0].click(); // Basculer vers le formulaire de connexion
                } else {
                    notyf.error(data.error || 'Une erreur est survenue lors de l\'inscription');
                }
            } catch (error) {
                notyf.error('Une erreur est survenue lors de l\'inscription');
                console.error('Error:', error);
            }
        });

        // verifier si l'utilisateur est deja connecté
        async function checkAuth() {
            try {
                const formData = new FormData();
                formData.append('action', 'check-auth');
                
                const response = await fetch('api/auth.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success && data.isAuthenticated) {
                    const redirectUrl = new URLSearchParams(window.location.search).get('redirect') || 'index.html';
                    window.location.href = redirectUrl;
                }
            } catch (error) {
                console.error('Error checking auth:', error);
            }
        }

        // verifier si l'utilisateur est deja connecté au chargement de la page
        document.addEventListener('DOMContentLoaded', checkAuth);

        // Google OAuth Configuration
        const googleClientId = '549081801061-lgpg1eledv5ptt3dqsc272rg144vsi2p.apps.googleusercontent.com';
        const redirectUri = 'http://localhost/api/google-callback.php';

        function initiateGoogleLogin() {
            const scope = 'email profile';
            const authUrl = `https://accounts.google.com/o/oauth2/v2/auth?response_type=code&client_id=${encodeURIComponent(googleClientId)}&redirect_uri=${encodeURIComponent(redirectUri)}&scope=${encodeURIComponent(scope)}&access_type=offline&prompt=consent`;
            window.location.href = authUrl;
        }
    </script>
</body>
</html>
