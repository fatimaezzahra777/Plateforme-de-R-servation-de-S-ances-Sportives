<?php
session_start();
require 'config.php';


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


$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id_sportif) {
    $date  = $_POST['date'];
    $heure = $_POST['heure'];

    $stmt = $conn->prepare("
        INSERT INTO reservation (id_coach, id_sportif, date_r, heure, statut)
        VALUES (?, ?, ?, ?, 'en_attente')
    ");
    $stmt->bind_param("iiss", $id_coach, $id_sportif, $date, $heure);

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

        <div class="flex flex-col md:flex-row gap-8">
            <!-- PHOTO -->
            <img src="assets/<?= $coach['photo'] ?? 'profile.avif' ?>"
                 class="w-64 h-64 object-cover rounded-xl">

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
            <h2 class="text-2xl font-bold mb-4">Réserver une séance</h2>

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
        </div>

    </div>

</div>

</body>
</html>
