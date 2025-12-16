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
    <div class="max-w-7xl mx-auto px-4 py-16">
            <h2 class="text-4xl font-bold text-gray-800 mb-8 text-center">Nos Coachs Vedettes</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6" id="featuredCoaches"></div>
        </div>

        <!-- How It Works -->
        <div class="bg-blue-50 py-16">
            <div class="max-w-7xl mx-auto px-4">
                <h2 class="text-4xl font-bold text-gray-800 mb-12 text-center">Comment Ça Marche ?</h2>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="bg-blue-600 text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">1</div>
                        <h3 class="text-xl font-bold mb-3">Choisissez Votre Coach</h3>
                        <p class="text-gray-600">Parcourez les profils des coachs certifiés et trouvez celui qui correspond à vos objectifs</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-blue-600 text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">2</div>
                        <h3 class="text-xl font-bold mb-3">Réservez une Séance</h3>
                        <p class="text-gray-600">Sélectionnez un créneau disponible et confirmez votre réservation en quelques clics</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-blue-600 text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">3</div>
                        <h3 class="text-xl font-bold mb-3">Atteignez Vos Objectifs</h3>
                        <p class="text-gray-600">Profitez d'un accompagnement personnalisé pour progresser rapidement</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Page Liste des Coachs -->
    <div id="coaches" class="page">
        <div class="min-h-screen bg-gray-50 py-8">
            <div class="max-w-7xl mx-auto px-4">
                <h1 class="text-4xl font-bold text-gray-800 mb-8">Nos Coachs Sportifs</h1>
                
                <!-- Filtres -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                    <div class="grid md:grid-cols-4 gap-4">
                        <select class="border border-gray-300 rounded-lg px-4 py-2" onchange="filterCoaches()">
                            <option value="">Tous les sports</option>
                            <option value="Football">Football</option>
                            <option value="Tennis">Tennis</option>
                            <option value="Natation">Natation</option>
                            <option value="Sports de Combat">Sports de Combat</option>
                        </select>
                        <select class="border border-gray-300 rounded-lg px-4 py-2">
                            <option>Toutes les villes</option>
                            <option>Casablanca</option>
                            <option>Rabat</option>
                            <option>Marrakech</option>
                            <option>Tanger</option>
                        </select>
                        <select class="border border-gray-300 rounded-lg px-4 py-2">
                            <option>Expérience</option>
                            <option>0-5 ans</option>
                            <option>5-10 ans</option>
                            <option>10+ ans</option>
                        </select>
                        <select class="border border-gray-300 rounded-lg px-4 py-2">
                            <option>Prix</option>
                            <option>0-300 DH</option>
                            <option>300-500 DH</option>
                            <option>500+ DH</option>
                        </select>
                    </div>
                </div>

                <!-- Liste des coachs -->
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6" id="coachesList"></div>
            </div>
        </div>
    </div>

    <!-- Page Dashboard Coach -->
    <div id="coach-dashboard" class="page">
        <div class="min-h-screen bg-gray-50 py-8">
            <div class="max-w-7xl mx-auto px-4">
                <div class="mb-8">
                    <h1 class="text-4xl font-bold text-gray-800">Tableau de Bord Coach</h1>
                    <p class="text-gray-600 mt-2">Gérez vos séances et votre planning</p>
                </div>

                <div class="grid md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="bg-orange-100 p-3 rounded-lg inline-block mb-4">
                            <i class="fas fa-clock text-orange-600 text-3xl"></i>
                        </div>
                        <div class="text-3xl font-bold text-gray-800 mb-1">5</div>
                        <div class="text-gray-600">En Attente</div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="bg-green-100 p-3 rounded-lg inline-block mb-4">
                            <i class="fas fa-check-circle text-green-600 text-3xl"></i>
                        </div>
                        <div class="text-3xl font-bold text-gray-800 mb-1">8</div>
                        <div class="text-gray-600">Aujourd'hui</div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="bg-blue-100 p-3 rounded-lg inline-block mb-4">
                            <i class="fas fa-calendar text-blue-600 text-3xl"></i>
                        </div>
                        <div class="text-3xl font-bold text-gray-800 mb-1">12</div>
                        <div class="text-gray-600">Demain</div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="bg-purple-100 p-3 rounded-lg inline-block mb-4">
                            <i class="fas fa-chart-line text-purple-600 text-3xl"></i>
                        </div>
                        <div class="text-3xl font-bold text-gray-800 mb-1">254</div>
                        <div class="text-gray-600">Total Séances</div>
                    </div>
                </div>

                <div class="grid lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-2xl font-bold text-gray-800">Demandes de Réservation</h2>
                                <span class="bg-orange-100 text-orange-600 px-3 py-1 rounded-full text-sm font-semibold">5 nouvelles</span>
                            </div>
                            <div id="pendingRequests"></div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-gradient-to-br from-blue-600 to-blue-800 text-white rounded-xl shadow-lg p-6">
                            <h3 class="text-xl font-bold mb-4">Prochaine Séance</h3>
                            <div class="space-y-3">
                                <div>
                                    <div class="text-sm opacity-80">Sportif</div>
                                    <div class="font-bold text-lg">Yassine Tazi</div>
                                </div>
                                <div>
                                    <div class="text-sm opacity-80">Heure</div>
                                    <div class="font-bold">Aujourd'hui, 16:00</div>
                                </div>
                                <div>
                                    <div class="text-sm opacity-80">Discipline</div>
                                    <div class="font-bold">Tennis</div>
                                </div>
                                                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-xl font-bold mb-4 text-gray-800">Mon Profil Coach</h3>
                            <div class="space-y-3">
                                <div>
                                    <div class="text-sm text-gray-600">Spécialité</div>
                                    <div class="font-medium">Tennis Professionnel</div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-600">Ville</div>
                                    <div class="font-medium">Casablanca</div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-600">Tarif / séance</div>
                                    <div class="font-medium">400 DH</div>
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

     <script src="../assets/js/index.js" ></script>
    
</body>
</html>