<?php
session_start();
require 'config.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'coach') {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];


$stmt = $conn->prepare("
    SELECT c.*, u.nom, u.email
    FROM coach c
    JOIN users u ON c.id_user = u.id_user
    WHERE c.id_user = ?
");

$stmt->bind_param("i", $id_user);
$stmt->execute();
$coach = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black text-white min-h-screen p-10">
    <div class="absolute inset-0 -z-10">
            <div class="absolute -left-40 top-1/2 w-[700px] h-[700px]
                        bg-gradient-to-r from-blue-500 to-green-500
                        opacity-30 rounded-full blur-3xl"></div>

            <div class="absolute -right-40 top-1/3 w-[700px] h-[700px]
                    bg-gradient-to-r from-green-500 to-blue-500
                    opacity-30 rounded-full blur-3xl"></div>
       </div>

        <nav class="bg-white/10 backdrop-blur-xl border-b border-white/20
            text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">

                <div class="flex items-center space-x-2 cursor-pointer">
                    <i class="fas fa-dumbbell text-3xl text-emerald-400"></i>
                    <span class="text-2xl font-bold">SportCoach</span>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8 font-medium">
                    <a href="profil.php" class="text-emerald-400 font-bold">Profile</a>
                    <a href="coach.php" class="hover:text-emerald-400 transition">Dashboard</a>
                    <a href="logout.php" class="hover:text-emerald-400 transition">Deconnexion</a>
                </div>
                <!-- Mobile Menu Button -->
                <button class="md:hidden">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobileMenu" class="hidden md:hidden pb-4 space-y-2">
                <a href="profil.php" class="block text-emerald-400 font-bold">Profile</a>
                <a href="coach.php" class="block hover:text-emerald-400">Dashboard</a>
                <a href="login.php" class="block hover:text-emerald-400">Deconnexion</a>
            </div>
        </div>
    </nav>

<h1 class="text-4xl font-bold text-emerald-400 mb-8">Mon Profil</h1>

<div class="bg-white/10 p-8 rounded-xl max-w-3xl">

    <div class="flex items-center space-x-6 mb-6">
        <?php
            $photo = (!empty($coach['photo']))
                ? "assets/".$coach['photo']
                : "assets/images/profile.avif";
        ?>

       <img src="<?= $photo ?>" class="w-28 h-28 rounded-full object-cover">


        <div>
            <h2 class="text-2xl font-bold"><?= $coach['nom'] ?></h2>
            <p class="text-white/70"><?= $coach['email'] ?></p>
        </div>
    </div>

    <p class="mb-4"><b>Biographie :</b><?= $coach['biographie'] ?></p>
    <p class="mb-2"><b>experience :</b> <?= $coach['experience'] ?></p>
    <p class="mb-2"><b>Certification :</b> <?= $coach['certif'] ?></p>

    <a href="editC.php" 
       class="bg-emerald-400 text-black px-6 py-2 rounded-lg font-bold hover:bg-emerald-300">
       Modifier Profil
    </a>
</div>



</body>
</html>
