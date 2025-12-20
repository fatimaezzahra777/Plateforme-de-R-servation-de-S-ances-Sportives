<?php
session_start();
require 'config.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'coach') {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

/* ================= RÉCUPÉRER LE COACH ================= */
$stmt = $conn->prepare("
    SELECT c.*, u.nom, u.email
    FROM coach c
    JOIN users u ON c.id_user = u.id_user
    WHERE c.id_user = ?
");
$stmt->bind_param("i", $id_user);
$stmt->execute();
$coach = $stmt->get_result()->fetch_assoc();

if (!$coach) {
    die("Coach introuvable");
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date    = $_POST['jour'];
    $heure_d = $_POST['heure_d'];
    $heure_f = $_POST['heure_f'];

    $stmt = $conn->prepare("
        INSERT INTO disponibilite (id_coach, jour, heure_d, heure_f)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->bind_param("isss", $coach['id'], $date, $heure_d, $heure_f);
    $stmt->execute();

    header("Location: profil.php");
    exit;
}

/* ================= SUPPRESSION DISPONIBILITÉ ================= */
if (isset($_GET['delete_dispo'])) {
    $id_dispo = intval($_GET['delete_dispo']);

    $stmt = $conn->prepare("
        DELETE FROM disponibilite
        WHERE id = ? AND id_coach = ?
    ");
    $stmt->bind_param("ii", $id_dispo, $coach['id']);
    $stmt->execute();

    header("Location: profil.php");
    exit;
}


$stmt = $conn->prepare("
    SELECT * FROM disponibilite
    WHERE id_coach = ?
    ORDER BY jour, heure_d
");
$stmt->bind_param("i", $coach['id']);
$stmt->execute();
$dispos = $stmt->get_result();


$stmt = $conn->prepare("
    SELECT 
        r.id_reserv,
        r.date_r,
        r.heure,
        r.statut,
        u.nom AS nom_sportif,
        u.email
    FROM reservation r
    JOIN sportif s ON r.id_sportif = s.id
    JOIN users u ON s.id_user = u.id_user
    WHERE r.id_coach = ?
    ORDER BY r.date_r DESC, r.heure DESC
");
$stmt->bind_param("i", $coach['id']);
$stmt->execute();
$reservations = $stmt->get_result();

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
<div class="mt-20 grid grid-cols-2">


<div class="bg-white/10 p-8 rounded-xl max-w-3xl">
    <h1 class="text-4xl font-bold text-emerald-400 mb-8">Mon Profil</h1>

    <div class="flex items-center space-x-6 mb-6">
        <?php
            $photo = (!empty($coach['photo']) && file_exists("assets/images/".$coach['photo']))
                    ? "assets/images/".$coach['photo']
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
<div>

<form method="POST" class="bg-white/10 p-6 rounded-xl w-96 mx-auto mt-10">
    <h2 class="text-xl font-bold mb-4">Ajouter disponibilité</h2>

    <input type="date" name="jour" required class="w-full mb-3 p-2 rounded text-black">
    <input type="time" name="heure_d" required class="w-full mb-3 p-2 rounded text-black">
    <input type="time" name="heure_f" required class="w-full mb-3 p-2 rounded text-black">

    <button type="submit" class="bg-emerald-500 w-full py-2 rounded">Ajouter</button>
</form>
</div>


</div>

<!-- DISPONIBILITÉS -->
<div class="bg-white/10 p-6 rounded-xl max-w-3xl mt-8">
    <h2 class="text-xl font-bold mb-4 text-emerald-400">
        Mes disponibilités
    </h2>

    <?php if ($dispos->num_rows > 0): ?>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-white/20 text-white/70">
                    <th class="py-2">Jour</th>
                    <th>Début</th>
                    <th>Fin</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($d = $dispos->fetch_assoc()): ?>
                <tr class="border-b border-white/10">
                    <td><?= $d['jour'] ?></td>
                    <td><?= $d['heure_d'] ?></td>
                    <td><?= $d['heure_f'] ?></td>
                    <td class="text-center">
                        <a href="?delete_dispo=<?= $d['id'] ?>"
                           onclick="return confirm('Supprimer cette disponibilité ?')"
                           class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-sm">
                           Supprimer
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-white/70">
            Aucune disponibilité ajoutée.
        </p>
    <?php endif; ?>
</div>

<div class="bg-white/10 p-6 rounded-xl max-w-4xl mt-10">
    <h2 class="text-xl font-bold mb-4 text-emerald-400">
        Réservations reçues
    </h2>

    <?php if ($reservations->num_rows > 0): ?>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-white/20 text-white/70">
                    <th>Sportif</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Statut</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($r = $reservations->fetch_assoc()): ?>
                <tr class="border-b border-white/10">
                    <td><?= htmlspecialchars($r['nom_sportif']) ?></td>
                    <td><?= $r['date_r'] ?></td>
                    <td><?= $r['heure'] ?></td>
                    <td>
                        <?php if ($r['statut'] === 'en_attente'): ?>
                            <span class="text-yellow-400">En attente</span>
                        <?php elseif ($r['statut'] === 'acceptee'): ?>
                            <span class="text-green-400">Acceptée</span>
                        <?php else: ?>
                            <span class="text-red-400">Refusée</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center space-x-2">
                        <?php if ($r['statut'] === 'en_attente'): ?>
                            <a href="reservation_action.php?id=<?= $r['id'] ?>&action=accept"
                               class="bg-emerald-500 px-3 py-1 rounded text-sm">
                               Accepter
                            </a>
                            <a href="reservation_action.php?id=<?= $r['id'] ?>&action=refuse"
                               class="bg-red-500 px-3 py-1 rounded text-sm">
                               Refuser
                            </a>
                        <?php else: ?>
                            —
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-white/70">Aucune réservation reçue.</p>
    <?php endif; ?>
</div>






</body>
</html>
