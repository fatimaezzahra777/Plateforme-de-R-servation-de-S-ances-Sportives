<?php
session_start();
require 'config.php';


if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'coach') {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];


$stmt = $conn->prepare("SELECT id FROM coach WHERE id_user = ?");
$stmt->bind_param("i", $id_user);
$stmt->execute();
$coach = $stmt->get_result()->fetch_assoc();
if (!$coach) {
    die("Coach non trouvé dans la table coach");
}

$id_coach = $coach['id'];

$q_attente = $conn->prepare("
    SELECT COUNT(*) total 
    FROM reservation 
    WHERE id_coach=? AND statut='en_attente'
");
$q_attente->bind_param("i", $id_coach);
$q_attente->execute();
$attente = $q_attente->get_result()->fetch_assoc()['total'];

$q_today = $conn->prepare("
    SELECT COUNT(*) total 
    FROM reservation 
    WHERE id_coach=? 
    AND statut='acceptée' 
    AND date_r = CURDATE()
");
$q_today->bind_param("i", $id_coach);
$q_today->execute();
$today = $q_today->get_result()->fetch_assoc()['total'];


$q_tomorrow = $conn->prepare("
    SELECT COUNT(*) total 
    FROM reservation 
    WHERE id_coach=? 
    AND statut='acceptée' 
    AND date_r = CURDATE() + INTERVAL 1 DAY
");
$q_tomorrow->bind_param("i", $id_coach);
$q_tomorrow->execute();
$tomorrow = $q_tomorrow->get_result()->fetch_assoc()['total'];


$id_user = $_SESSION['id_user'];

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


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportCoach - Plateforme de Coaching Sportif</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="./assets/css/index.css" rel="stylesheet">
</head>
<body class="relative min-h-screen bg-black overflow-x-hidden text-white">
        <!-- Background graphique glassmorphism -->
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
                    <a href="profil.php" class="hover:text-emerald-400 transition">Profile</a>
                    <a href="coach.php" class="text-emerald-400 font-bold">Dashboard</a>
                    <a href="logout.php" class="hover:text-emerald-400 transition">Deconnexion</a>
                </div>
                <!-- Mobile Menu Button -->
                <button class="md:hidden">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobileMenu" class="hidden md:hidden pb-4 space-y-2">
                <a href="profil.php" class="block hover:text-emerald-400">Profile</a>
                <a href="coach.php" class="block text-emerald-400 font-bold">Dashboard</a>
                <a href="login.php" class="block hover:text-emerald-400">Deconnexion</a>
            </div>
        </div>
    </nav>
       <div class="max-w-7xl mx-auto px-4 py-16">
            <h2 class="text-4xl font-bold text-emerald-400 mb-8 text-center">Nos Coachs Vedettes</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6" id="featuredCoaches"></div>
        </div>
        <div class="grid md:grid-cols-4 px-32 gap-6 mb-12">
            <div class="bg-white/10 p-6 rounded-xl">
                Demandes en attente<br>
                <span class="text-2xl font-bold"><?= $attente ?></span>
            </div>

            <div class="bg-white/10 p-6 rounded-xl">
                Séances aujourd'hui<br>
                <span class="text-2xl font-bold"><?= $today ?></span>
            </div>

            <div class="bg-white/10 p-6 rounded-xl">
                Séances demain<br>
                <span class="text-2xl font-bold"><?= $tomorrow ?></span>
            </div>

            <div class="bg-white/10 p-6 rounded-xl">
                Prochaine séance<br>
                <?php if($next): ?>
                    <?= $next['nom'] ?><br>
                    <?= $next['date_r'] ?> à <?= $next['heure'] ?>
                <?php else: ?>
                    Aucune
                <?php endif; ?>
            </div>
       </div>

        <!-- How It Works -->
        <div class="bg-balck py-16">
            <div class="max-w-7xl mx-auto px-4">
                <h2 class="text-4xl font-bold text-emerald-400 mb-12 text-center">Comment Ça Marche ?</h2>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="bg-white text-black w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">1</div>
                        <h3 class="text-xl font-bold mb-3">Choisissez Votre Coach</h3>
                        <p class="text-gray-500">Parcourez les profils des coachs certifiés et trouvez celui qui correspond à vos objectifs</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-white text-black w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">2</div>
                        <h3 class="text-xl font-bold mb-3">Réservez une Séance</h3>
                        <p class="text-gray-500">Sélectionnez un créneau disponible et confirmez votre réservation en quelques clics</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-white text-black w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">3</div>
                        <h3 class="text-xl font-bold mb-3">Atteignez Vos Objectifs</h3>
                        <p class="text-gray-500">Profitez d'un accompagnement personnalisé pour progresser rapidement</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

 <div class="grid md:grid-cols-3 gap-8 px-32 mb-20">

<?php if ($coachs->num_rows > 0): ?>
    <?php while ($row = $coachs->fetch_assoc()): ?>
        
        <div class="bg-white/10 p-6 rounded-xl border border-white/20">
            <?php
            $photo = (!empty($coach['photo']))
                ? "assets/".$coach['photo']
                : "assets/images/profile.avif";
            ?>
            <img src="<?= $photo ?>" class="w-28 h-28 rounded-full object-cover">
            <h2 class="text-xl font-bold">
                <?= $row['nom'] ?>
            </h2>

            <p class="text-emerald-400">
                <?= $row['certif'] ?>
            </p>

            <a href="detail_c.php?id=<?= $coach['id'] ?>" class="block text-center mt-4 bg-emerald-500 hover:bg-emerald-600 text-white py-2 rounded-lg transition"> 
                Voir Profil 
            </a>
        </div>

    <?php endwhile; ?>
<?php else: ?>
    <p class="text-center text-gray-300">
        Aucun coach trouvé
    </p>
<?php endif; ?>

</div>

     <script src="./assets/js/index.js" ></script>
    
</body>
</html>