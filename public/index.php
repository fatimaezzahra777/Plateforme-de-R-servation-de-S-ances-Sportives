<!DOCTYPE html>
<html lang="fr">
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
                    <a href="sportif.php">Sportifs</a>
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
                <a href="sportif.php">Sportifs</a>
                <a href="login.php">Connexion</a>
                <a href="inscri.php">Inscription</a>

            </div>
        </div>
    </nav>

    <!-- Page d'accueil -->
    <div id="home" class="page active">
        <!-- Hero Section -->
        <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900 text-white py-20 px-4">
            <div class="max-w-7xl mx-auto text-center animate-fade-in">
                <h1 class="text-5xl md:text-6xl font-bold mb-6">
                    Trouvez Votre Coach Sportif Idéal
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-blue-100">
                    Réservez des séances personnalisées avec des coachs certifiés
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="coach.php"><button  class="bg-white text-blue-600 px-8 py-4 rounded-full text-lg font-semibold hover:bg-blue-50 transition transform hover:scale-105 shadow-lg">
                        Découvrir les Coachs
                    </button></a>
                    <a href="inscri.php"><button class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-full text-lg font-semibold hover:bg-white hover:text-blue-600 transition transform hover:scale-105">
                        Devenir Coach
                    </button></a>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="max-w-7xl mx-auto px-4 -mt-10">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl shadow-lg p-6 text-center hover-scale">
                    <i class="fas fa-users text-blue-600 text-5xl mb-3"></i>
                    <div class="text-3xl font-bold text-gray-800 mb-1">2,500+</div>
                    <div class="text-gray-600">Sportifs Actifs</div>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 text-center hover-scale">
                    <i class="fas fa-award text-blue-600 text-5xl mb-3"></i>
                    <div class="text-3xl font-bold text-gray-800 mb-1">150+</div>
                    <div class="text-gray-600">Coachs Certifiés</div>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 text-center hover-scale">
                    <i class="fas fa-calendar-check text-blue-600 text-5xl mb-3"></i>
                    <div class="text-3xl font-bold text-gray-800 mb-1">15,000+</div>
                    <div class="text-gray-600">Séances Réalisées</div>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 text-center hover-scale">
                    <i class="fas fa-star text-blue-600 text-5xl mb-3"></i>
                    <div class="text-3xl font-bold text-gray-800 mb-1">4.8/5</div>
                    <div class="text-gray-600">Note Moyenne</div>
                </div>
            </div>
        </div>
   
  

    <script src="../assets/js/index.js" ></script>

</body>
</html>