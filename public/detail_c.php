<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'config.php';


if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'sportif') {
    header("Location: login.php");
    exit;
}

$id_sportif = $_SESSION['id_user'];

$id_user = $_SESSION['id_user'];

$stmt = $conn->prepare("SELECT id FROM sportif WHERE id_user = ?");
$stmt->bind_param("i", $id_user);
$stmt->execute();
$sportif = $stmt->get_result()->fetch_assoc();

if (!$sportif) {
    die("Sportif introuvable !");
}


$id_sportif = $sportif['id'];

if (!isset($_GET['id'])) {
    die("Coach introuvable");
}

$id_coach = (int) $_GET['id'];

$stmt = $conn->prepare("
    SELECT c.*, u.nom, u.email
    FROM coach c
    JOIN users u ON c.id_user = u.id_user
    WHERE c.id = ?
");
$stmt->bind_param("i", $id_coach);
$stmt->execute();
$coach = $stmt->get_result()->fetch_assoc();

if (!$coach) {
    die("Coach introuvable");
}


$stmt = $conn->prepare("
    SELECT * FROM disponibilite
    WHERE id_coach=?
");
$stmt->bind_param("i", $id_coach);
$stmt->execute();
$dispos = $stmt->get_result();


$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date  = $_POST['date_r'];
    $heure = $_POST['heure'];
    $statut = 'en_attente';

    $stmt = $conn->prepare("
        INSERT INTO reservation (id_coach, id_sportif, date_r, heure, statut)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("iisss", $id_coach, $id_sportif, $date, $heure, $statut);

    if ($stmt->execute()) {
        $message = "Réservation envoyée avec succès ";
    } else {
        $message = "Erreur lors de la réservation ";
    }
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails du Coach</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black text-white min-h-screen">

<div class="max-w-4xl mx-auto py-16 px-4">
    
    <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-xl p-8">
        <a href="ListeC.php" class="flex justify-end ">
            <button class="md:col-span-2 bg-emerald-500 hover:bg-emerald-600 p-3 rounded-lg font-bold transition"> X </button>
        </a>
        <div class="flex flex-col md:flex-row gap-8">
            <?php
                $photo = !empty($coach['photo']) && file_exists("assets/images/".$coach['photo']) 
                        ? $coach['photo'] 
                        : 'profile.avif';
            ?>
            <img src="assets/images/<?= $photo ?>" class="w-64 h-64 object-cover rounded-xl">


            <!-- INFOS -->
            <div>
                <h1 class="text-3xl font-bold mb-2"><?= $coach['nom'] ?></h1>
                <p class="text-gray-300 text-xl mb-2">Certification :  <?= $coach['certif'] ?></p>
                <p class="text-gray-300 text-xl mb-2"> Biographie : <?= $coach['biographie'] ?? '—' ?></p>
                <p class="text-gray-300 text-xl mb-2"> Expérience : <?= $coach['experience'] ?? '—' ?> ans</p>

            </div>
        </div>

        <!-- MESSAGE -->
        <?php if ($message): ?>
            <div class="mt-6 bg-emerald-500/20 text-emerald-400 p-4 rounded-lg">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <!-- RÉSERVATION -->
        <div class="mt-10">
            
                <h2 class="text-2xl font-bold mb-4">Disponibilités</h2>

                    <?php if ($dispos->num_rows > 0): ?>
                        <table class="w-full text-left">
                            <tr class="border-b">
                                <th>Jour</th>
                                <th>De</th>
                                <th>À</th>
                                <th>Action</th>
                            </tr>

                            <?php while($d = $dispos->fetch_assoc()): ?>
                            <tr class="border-b">
                                <td><?= $d['jour'] ?></td>
                                <td><?= $d['heure_d'] ?></td>
                                <td><?= $d['heure_f'] ?></td>
                                <td>
                                <form method="POST" class="inline">
                                    <input type="hidden" name="date_r" value="<?= $d['jour'] ?>">
                                    <input type="hidden" name="heure" value="<?= $d['heure_d'] ?>">
                                    <button type="submit"
                                    class="bg-emerald-500 px-3 py-1 rounded">
                                    Réserver
                                    </button>
                                </form>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </table>
                    <?php else: ?>
                        <p>Aucune disponibilité</p>
                    <?php endif; ?>
            <h2 class="text-2xl font-bold mb-4 mt-6">Réserver une séance</h2>

                <form method="POST" class="grid md:grid-cols-2 gap-4">
                    <input type="date" name="date_r" required
                           class="bg-black/30 border border-white/20 rounded-lg px-4 py-2">

                    <input type="time" name="heure" required
                           class="bg-black/30 border border-white/20 rounded-lg px-4 py-2">

                    <button type="submit"
                            class="md:col-span-2 bg-emerald-500 hover:bg-emerald-600
                                   py-3 rounded-lg font-bold transition">
                        Confirmer la réservation
                    </button>

                    </form>
                    
        </div>

    

    </div>

</div>

</body>
</html>
