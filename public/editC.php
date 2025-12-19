<?php
session_start();
require 'config.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'coach') {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

$stmt = $conn->prepare("SELECT * FROM coach WHERE id_user=?");
$stmt->bind_param("i", $id_user);
$stmt->execute();
$coach = $stmt->get_result()->fetch_assoc();

if (isset($_POST['save'])) {

    $bio = $_POST['biographie'];
    $exper = $_POST['experience'];
    $certif = $_POST['certif'];

 

    $update = $conn->prepare("
        UPDATE coach 
        SET biographie=?, experience=?, certif=?, photo=?
        WHERE id_user=?
    ");
    $update->bind_param("sissi", $bio, $exper, $certif, $photo, $id_user);
    $update->execute();

    header("Location: profil.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Profil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black text-white min-h-screen p-10">

<h1 class="text-3xl font-bold text-emerald-400 mb-6">Modifier Mon Profil</h1>

<form method="POST" enctype="multipart/form-data"
      class="bg-white/10 p-8 rounded-xl max-w-3xl space-y-4">

    <div>
        <label>Photo</label>
        <input type="file" name="photo">
    </div>
    <div>
        <label>Nom</label>
        <input type="text" name="nom" value="<?= $coach['nom'] ?>"
               class="w-full p-3 bg-black/40 border border-white/20 rounded">
    </div>

    <div>
        <label>Biographie</label>
        <textarea name="biographie" class="w-full p-3 bg-black/40 border border-white/20 rounded"
                  rows="4"><?= $coach['biographie'] ?></textarea>
    </div>

    <div>
        <label>Experience</label>
        <input type="number" name="experience" value="<?= $coach['experience'] ?>"
               class="w-full p-3 bg-black/40 border border-white/20 rounded">
    </div>

    <div>
        <label>Certification</label>
        <textarea name="certif" class="w-full p-3 bg-black/40 border border-white/20 rounded"
                  rows="4"><?= $coach['certif'] ?></textarea>
    </div>

    <button name="save"
            class="bg-emerald-400 text-black px-6 py-2 rounded-lg font-bold hover:bg-emerald-300">
        Enregistrer
    </button>
</form>

</body>
</html>
