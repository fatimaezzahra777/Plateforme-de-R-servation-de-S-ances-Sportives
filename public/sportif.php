<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>SportCoach - Inscription</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
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
      <!-- Page Dashboard Sportif -->
    <div id="athlete-dashboard" class="page">
        <div class="min-h-screen bg-gray-50 py-8">
            <div class="max-w-7xl mx-auto px-4">
                <div class="mb-8">
                    <h1 class="text-4xl font-bold text-gray-800">Mon Espace Sportif</h1>
                    <p class="text-gray-600 mt-2">Gérez vos réservations et découvrez de nouveaux coachs</p>
                </div>

                <div class="grid md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="bg-blue-100 p-3 rounded-lg inline-block mb-4">
                            <i class="fas fa-calendar text-blue-600 text-3xl"></i>
                        </div>
                        <div class="text-3xl font-bold text-gray-800 mb-1">12</div>
                        <div class="text-gray-600">Séances Réservées</div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="bg-green-100 p-3 rounded-lg inline-block mb-4">
                            <i class="fas fa-check-circle text-green-600 text-3xl"></i>
                        </div>
                        <div class="text-3xl font-bold text-gray-800 mb-1">48</div>
                        <div class="text-gray-600">Séances Complétées</div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="bg-purple-100 p-3 rounded-lg inline-block mb-4">
                            <i class="fas fa-award text-purple-600 text-3xl"></i>
                        </div>
                        <div class="text-3xl font-bold text-gray-800 mb-1">5</div>
                        <div class="text-gray-600">Coachs Favoris</div>
                    </div>
                </div>

                <div class="grid lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h2 class="text-2xl font-bold text-gray-800 mb-6">Prochaines Séances</h2>
                            <div id="upcomingSessions"></div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-gradient-to-br from-blue-600 to-blue-800 text-white rounded-xl shadow-lg p-6">
                            <h3 class="text-xl font-bold mb-4">Réserver une Séance</h3>
                            <p class="mb-4 opacity-90">Trouvez le coach parfait pour atteindre vos objectifs</p>
                            <button onclick="showPage('coaches')" class="w-full bg-white text-blue-600 py-3 rounded-lg font-semibold hover:bg-blue-50 transition">
                                Découvrir les Coachs
                            </button>
                        </div>

                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-xl font-bold mb-4 text-gray-800">Mon Profil</h3>
                            <div class="space-y-3">
                                <div>
                                    <div class="text-sm text-gray-600">Objectif Principal</div>
                                    <div class="font-medium">Amélioration technique</div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-600">Sports Pratiqués</div>
                                    <div class="flex flex-wrap gap-2 mt-1">
                                        <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full">Football</span>
                                        <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full">Tennis</span>
                                    </div>
                                </div>
                                <button class="w-full border-2 border-blue-600 text-blue-600 py-2 rounded-lg font-semibold hover:bg-blue-50 transition mt-4">
                                    Modifier le Profil
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- JS -->
<script src="./assets/js/index.js"></script>
    
</body>
</html>