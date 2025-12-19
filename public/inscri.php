<?php
session_start();
require 'config.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nom     = $_POST['nom'];
    $email   = $_POST['email'];
    $tel     = $_POST['telephone'];
    $role    = $_POST['role'];
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    if ($password !== $confirm) {
        $error = "Les mots de passe ne correspondent pas";
    }

    if (empty($error)) {
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("
        INSERT INTO users (nom, email, telephone, password, role)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("sssss", $nom, $email, $tel, $passwordHash, $role);
    $stmt->execute();

    $id_user = $stmt->insert_id;
    $_SESSION['id_user'] = $id_user;
    $_SESSION['role'] = $role;

    if ($role === 'sportif') {
        $niveau = $_POST['niveau'];
        $stmt2 = $conn->prepare("INSERT INTO sportif (id_user, niveau) VALUES (?, ?)");
        $stmt2->bind_param("is", $id_user, $niveau);
        $stmt2->execute();
    } elseif ($role === 'coach') {
        $experience = $_POST['experience'];
        $biographie = $_POST['biographie'];
        $certif = $_POST['certif'];
        $photo = null ;
        if (!empty($_FILES['photo']['name']) && $_FILES['photo']['error'] === 0) {
         $photoName = uniqid() . "_" . $_FILES['photo']['name'];
         move_uploaded_file($_FILES['photo']['tmp_name'], "assets/" . $photoName);
    }
        $stmt2 = $conn->prepare("
            INSERT INTO coach (id_user, experience, certif, biographie, photo)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt2->bind_param("iiss", $id_user, $experience, $certif, $biographie, $photoName);
        $stmt2->execute();
}

        header("Location: login.php");
        exit;
}
}
?>


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

<body class="relative min-h-screen bg-black overflow-x-hidden text-white">
        <!-- Background graphique glassmorphism -->
    <div class="absolute inset-0 -z-10 overflow-hidden">
        <div class="absolute -left-52 top-1/2 w-[900px] h-[900px]
            bg-gradient-to-r from-blue-500 to-emerald-500
            opacity-30 rounded-full blur-3xl"></div>

        <div class="absolute -right-52 top-1/3 w-[900px] h-[900px]
            bg-gradient-to-r from-emerald-500 to-blue-500
            opacity-30 rounded-full blur-3xl"></div>
    </div>

     <nav class="bg-white/10 backdrop-blur-xl border-b border-white/20 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-2 cursor-pointer" onclick="showPage('home')">
                    <i class="fas fa-dumbbell text-3xl text-emerald-400"></i>
                    <span class="text-2xl font-bold">SportCoach</span>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="index.php" class="text-emerald-400 font-bold">Accueil</a>
                    <a href="login.php" class="hover:text-emerald-400 transition">Connexion</a>
                </div>

                <!-- Mobile Menu Button -->
                <button class="md:hidden" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobileMenu" class="hidden md:hidden pb-4 space-y-2">
                <a href="index.php" class="font-bold underline">Accueil</a>
                <a href="login.php">Connexion</a>
            </div>
        </div>
    </nav>

<!-- INSCRIPTION -->
<div class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl shadow-2xl p-8 w-full max-w-2xl">
        <div class="text-center mb-8">
            <i class="fas fa-user-plus text-emerald-400 text-5xl mb-4"></i>
            <h2 class="text-3xl font-bold">Inscription</h2>
            <p class="text-white/70 mt-2">Créez votre compte</p>
        </div>

        <!-- CHOIX ROLE -->
        <div class="mb-6">
            <label class="block font-medium mb-3">Je suis :</label>
            <div class="grid grid-cols-2 gap-4">
                <button type="button" id="athleteBtn"
                        onclick="selectRole('sportif')"
                        class="border-2 border-emerald-400 bg-emerald-400/10 text-emerald-400 py-3 rounded-lg font-semibold">
                    <i class="fas fa-running mr-2"></i> Sportif
                </button>

                <button type="button" id="coachBtn"
                        onclick="selectRole('coach')"
                        class="border-2 border-white/30 text-white/60
                               py-3 rounded-lg font-semibold hover:border-emerald-400 hover:text-emerald-400 transition">
                    <i class="fas fa-whistle mr-2"></i> Coach
                </button>
            </div>
        </div>

        <!-- FORMULAIRE -->
        <form method="POST" enctype="multipart/form-data" class="space-y-4">

            <input type="hidden" name="role" id="role" value="sportif">

            <div class="grid md:grid-cols-2 gap-4">
                <input type="text" name="nom" placeholder="Nom" id="nom" required
                       class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3">
                <input type="text" name="niveau" placeholder="Niveau" id="niveau"
                       class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3">
            </div>

            <input type="email" name="email" placeholder="Email" required
                   class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3">

            <input type="tel" name="telephone" placeholder="Téléphone" required
                   class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3">

            <input type="password" name="password" placeholder="Mot de passe" required
                   class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3">

            <input type="password" name="confirm_password" placeholder="Confirmer mot de passe" required
                   class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3">

            <!-- CHAMPS COACH -->
            <div id="coachFields" class="hidden space-y-4">

                <input type="number" name="experience" min="0"
                       placeholder="Années d'expérience"
                       class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3">

                 <input type="text" name="certif" min="0"
                       placeholder="Certification"
                       class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3">

                <textarea name="biographie" rows="4"
                          placeholder="Biographie"
                          class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3"></textarea>

                <input type="file" name="photo" accept="assets/*"
                       class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3">
            </div>

           <div class="flex items-start text-sm">
                <input type="checkbox" required class="mt-1 mr-2">
                <span>
                    J'accepte les
                    <a href="conditions.php" class="text-emerald-400 hover:underline">
                        conditions
                    </a>
                </span>
            </div>

            <button type="submit"
                    class="w-full bg-emerald-400 text-black py-3 rounded-lg
                           font-semibold hover:bg-emerald-300 transition">
                Créer mon compte
            </button>
        </form>

        <p class="mt-6 text-center text-white/70">
            Déjà inscrit ?
            <a href="login.php" class="text-emerald-400 hover:underline">
                Connexion
            </a>
        </p>

        <?php if (!empty($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>


    </div>
</div>


<script src="./assets/js/index.js"></script>

</body>
</html>
