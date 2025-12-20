<?php
session_start();
require 'config.php';


    if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'sportif') {
        header("Location: login.php");
        exit;
    }

    $q_coachs = $conn->prepare("
        SELECT 
            coach.id,
            coach.photo,
            coach.certif,
            users.nom
        FROM coach
        INNER JOIN users ON coach.id_user = users.id_user
    ");
    $q_coachs->execute();
    $coachs = $q_coachs->get_result();

    $stmt = $conn->prepare("
        SELECT * FROM disponibilite
        WHERE id_coach = ?
    ");
    $stmt->bind_param("i", $coach['id']);
    $stmt->execute();
    $dispos = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>SportCoach - Dashboard Sportif</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="relative min-h-screen bg-black overflow-x-hidden text-white">


<div class="absolute inset-0 -z-10 overflow-hidden">
    <div class="absolute -left-52 top-1/2 w-[900px] h-[900px]
        bg-gradient-to-r from-blue-500 to-emerald-500
        opacity-30 rounded-full blur-3xl"></div>

    <div class="absolute -right-52 top-1/3 w-[900px] h-[900px]
        bg-gradient-to-r from-emerald-500 to-blue-500
        opacity-30 rounded-full blur-3xl"></div>
</div>


<nav class="bg-white/10 backdrop-blur-xl border-b border-white/20
            text-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <div class="flex items-center space-x-2">
                <i class="fas fa-dumbbell text-3xl text-emerald-400"></i>
                <span class="text-2xl font-bold">SportCoach</span>
            </div>

            <div class="hidden md:flex items-center space-x-8">
                <a href="index.php" class="hover:text-emerald-400">Accueil</a>
                <a href="sportif.php" class="hover:text-emerald-400">Sportif</a>
                <a href="ListeC.php" class="text-emerald-400 font-bold">Coachs</a>
                <a href="logout.php" class="hover:text-red-400">Deconnexion</a>
            </div>
        </div>
    </div>
</nav>
     <div class="grid md:grid-cols-3 gap-8 px-32 mb-20 mt-20">

<?php if ($coachs->num_rows > 0): ?>
    <?php while ($row = $coachs->fetch_assoc()): ?>
        
        <div class="bg-white/10 p-6 rounded-xl border border-white/20">
            <?php
            $photo = (!empty($row['photo']))
                ? "assets/images/".$row['photo']
                : "assets/images/profile.avif";
            ?>
            <img src="<?= $photo ?>" class="w-28 h-28 rounded-full object-cover">
            <h2 class="text-xl font-bold">
                <?= $row['nom'] ?>
            </h2>

            <p class="text-emerald-400">
                <?= $row['certif'] ?>
            </p>

            <a href="detail_c.php?id=<?= $row['id'] ?>" class="block text-center mt-4 bg-emerald-500 hover:bg-emerald-600 text-white py-2 rounded-lg transition"> 
                Voir Profil 
            </a>
        </div>

    <?php endwhile; ?>
<?php else: ?>
    <p class="text-center text-gray-300">
        Aucun coach trouvé
    </p>
<?php endif; ?>
</body>
</html>