<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Conditions d'utilisation - SportCoach</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="./assets/css/index.css">
</head>

<body class="bg-gray-100 text-gray-800">

<!-- NAVBAR -->
<nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 h-16 flex justify-between items-center">
        <div class="flex items-center space-x-2">
            <i class="fas fa-dumbbell text-2xl"></i>
            <span class="text-xl font-bold">SportCoach</span>
        </div>
        <div class="hidden md:flex space-x-6">
            <a href="index.php">Accueil</a>
            <a href="coach.php">Coachs</a>
            <a href="sportif.php">Sportifs</a>
            <a href="login.php">Connexion</a>
            <a href="inscri.php">Inscription</a>
        </div>
    </div>
</nav>

<!-- CONTENU -->
<div class="max-w-4xl mx-auto px-4 py-12 bg-white shadow-lg rounded-xl mt-8 mb-12">

    <h1 class="text-3xl font-bold mb-6 text-blue-700">
        Conditions Générales d’Utilisation
    </h1>

    <p class="mb-4 text-gray-600">
        Les présentes Conditions Générales d’Utilisation (CGU) régissent l’accès et l’utilisation
        de la plateforme <strong>SportCoach</strong>.
        En utilisant ce site, vous acceptez sans réserve les conditions ci-dessous.
    </p>

    <!-- ARTICLE 1 -->
    <h2 class="text-xl font-semibold mt-6 mb-2">1. Objet</h2>
    <p class="text-gray-600">
        SportCoach est une plateforme de mise en relation entre des sportifs et des coachs
        professionnels dans différents domaines sportifs.
    </p>

    <!-- ARTICLE 2 -->
    <h2 class="text-xl font-semibold mt-6 mb-2">2. Inscription</h2>
    <p class="text-gray-600">
        L’inscription est gratuite. L’utilisateur s’engage à fournir des informations exactes
        et à jour lors de la création de son compte.
    </p>

    <!-- ARTICLE 3 -->
    <h2 class="text-xl font-semibold mt-6 mb-2">3. Responsabilités</h2>
    <p class="text-gray-600">
        SportCoach n’est pas responsable des prestations réalisées par les coachs.
        Chaque utilisateur est responsable de l’utilisation qu’il fait de la plateforme.
    </p>

    <!-- ARTICLE 4 -->
    <h2 class="text-xl font-semibold mt-6 mb-2">4. Compte utilisateur</h2>
    <p class="text-gray-600">
        Les utilisateurs sont responsables de la confidentialité de leurs identifiants.
        Toute activité effectuée depuis un compte est réputée effectuée par son titulaire.
    </p>

    <!-- ARTICLE 5 -->
    <h2 class="text-xl font-semibold mt-6 mb-2">5. Données personnelles</h2>
    <p class="text-gray-600">
        Les données personnelles sont collectées uniquement dans le cadre de l’utilisation
        de la plateforme et ne sont jamais partagées sans consentement.
    </p>

    <!-- ARTICLE 6 -->
    <h2 class="text-xl font-semibold mt-6 mb-2">6. Modification des conditions</h2>
    <p class="text-gray-600">
        SportCoach se réserve le droit de modifier les présentes conditions à tout moment.
        Les utilisateurs seront informés de toute modification importante.
    </p>

    <!-- ARTICLE 7 -->
    <h2 class="text-xl font-semibold mt-6 mb-2">7. Contact</h2>
    <p class="text-gray-600">
        Pour toute question concernant ces conditions, vous pouvez nous contacter à :
        <strong>contact@sportcoach.ma</strong>
    </p>

    <div class="mt-8 text-center">
        <a href="inscri.php"
           class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
            Retour à l’inscription
        </a>
    </div>

</div>

<!-- FOOTER -->
<footer class="bg-gray-800 text-gray-300 py-6 text-center">
    <p>&copy; <?= date('Y') ?> SportCoach – Tous droits réservés</p>
</footer>

</body>
</html>
