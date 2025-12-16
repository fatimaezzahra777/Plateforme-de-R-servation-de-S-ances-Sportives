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
    <!-- Page Connexion -->
    <div id="login" class="page">
        <div class="min-h-screen bg-gradient-to-br from-blue-600 to-blue-900 flex items-center justify-center px-4 py-12">
            <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md animate-fade-in">
                <div class="text-center mb-8">
                    <i class="fas fa-dumbbell text-blue-600 text-6xl mb-4"></i>
                    <h2 class="text-3xl font-bold text-gray-800">Connexion</h2>
                    <p class="text-gray-600 mt-2">Accédez à votre espace personnel</p>
                </div>
                
                <form id="loginForm" class="space-y-6" onsubmit="handleLogin(event)">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Email</label>
                        <input 
                            type="email" 
                            id="loginEmail"
                            placeholder="votre@email.com"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-600"
                            required
                        />
                        <span class="text-red-500 text-sm hidden" id="emailError">Email invalide</span>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Mot de passe</label>
                        <input 
                            type="password" 
                            id="loginPassword"
                            placeholder="••••••••"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-600"
                            required
                        />
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox" class="mr-2" />
                            <span class="text-sm text-gray-600">Se souvenir de moi</span>
                        </label>
                        <a href="#" class="text-sm text-blue-600 hover:underline">Mot de passe oublié?</a>
                    </div>

                    <button 
                        type="submit"
                        class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-semibold"
                    >
                        Se Connecter
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-gray-600">
                        Pas encore de compte? 
                        <a href="#" onclick="showPage('register')" class="text-blue-600 hover:underline ml-1 font-medium">S'inscrire</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>