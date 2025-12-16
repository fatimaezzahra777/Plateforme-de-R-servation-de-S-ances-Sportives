<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportCoach - Plateforme de Coaching Sportif</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="../assets/css/index.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
     <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-2 cursor-pointer" onclick="showPage('home')">
                    <i class="fas fa-dumbbell text-3xl"></i>
                    <span class="text-2xl font-bold">SportCoach</span>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="index.php">Accueil</a>
                    <a href="coach.php">Coachs</a>
                    <a href="login.php">Connexion</a>
                    <a href="inscri.php">Inscription</a>

                </div>

                <!-- Mobile Menu Button -->
                <button class="md:hidden" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobileMenu" class="hidden md:hidden pb-4 space-y-2">
                <a href="index.php">Accueil</a>
                <a href="coach.php">Coachs</a>
                <a href="login.php">Connexion</a>
                <a href="inscri.php">Inscription</a>

            </div>
        </div>
    </nav>
     <div id="register" class="page">
        <div class="min-h-screen bg-gradient-to-br from-blue-600 to-blue-900 flex items-center justify-center px-4 py-12">
            <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-2xl animate-fade-in">
                <div class="text-center mb-8">
                    <i class="fas fa-dumbbell text-blue-600 text-6xl mb-4"></i>
                    <h2 class="text-3xl font-bold text-gray-800">Inscription</h2>
                    <p class="text-gray-600 mt-2">Créez votre compte en quelques clics</p>
                </div>
                
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-3">Je suis:</label>
                    <div class="grid grid-cols-2 gap-4">
                        <button onclick="selectRole('athlete')" id="athleteBtn" class="border-2 border-blue-600 bg-blue-50 text-blue-600 py-3 rounded-lg font-semibold hover:bg-blue-100 transition">
                            <i class="fas fa-running mr-2"></i>Sportif
                        </button>
                        <button onclick="selectRole('coach')" id="coachBtn" class="border-2 border-gray-300 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-50 transition">
                            <i class="fas fa-whistle mr-2"></i>Coach
                        </button>
                    </div>
                </div>

                <form id="registerForm" class="space-y-4" onsubmit="handleRegister(event)">
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Prénom</label>
                            <input 
                                type="text" 
                                id="firstName"
                                placeholder="Votre prénom"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-600"
                                required
                            />
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Nom</label>
                            <input 
                                type="text" 
                                id="lastName"
                                placeholder="Votre nom"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-600"
                                required
                            />
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Email</label>
                        <input 
                            type="email" 
                            id="email"
                            placeholder="votre@email.com"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-600"
                            required
                        />
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Téléphone</label>
                        <input 
                            type="tel" 
                            id="phone"
                            placeholder="+212 6XX XXX XXX"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-600"
                            required
                        />
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Mot de passe</label>
                        <input 
                            type="password" 
                            id="password"
                            placeholder="••••••••"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-600"
                            required
                        />
                        <span class="text-sm text-gray-500">Minimum 8 caractères, 1 majuscule, 1 chiffre</span>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Confirmer le mot de passe</label>
                        <input 
                            type="password" 
                            id="confirmPassword"
                            placeholder="••••••••"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-600"
                            required
                        />
                    </div>

                    <div class="flex items-start">
                        <input type="checkbox" class="mr-2 mt-1" required />
                        <span class="text-sm text-gray-600">
                            J'accepte les <a href="#" class="text-blue-600 hover:underline">conditions d'utilisation</a> et la <a href="#" class="text-blue-600 hover:underline">politique de confidentialité</a>
                        </span>
                    </div>

                    <button 
                        type="submit"
                        class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-semibold"
                    >
                        Créer mon compte
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-gray-600">
                        Déjà un compte? 
                        <a href="#" onclick="showPage('login')" class="text-blue-600 hover:underline ml-1 font-medium">Se connecter</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>