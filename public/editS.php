<?php
session_start();
require 'config.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'sportif') {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

$stmt = $conn->prepare("SELECT * FROM sportif WHERE id_user=?");
$stmt->bind_param("i", $id_user);
$stmt->execute();
$coach = $stmt->get_result()->fetch_assoc();

if (isset($_POST['save'])) {

    $niveau = $_POST['niveau'];

    $update = $conn->prepare("
        UPDATE sportif 
        SET niveau=?
        WHERE id_user=?
    ");
    $update->bind_param("si", $niveau, $id_user);
    $update->execute();

    header("Location: sportif.php");
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
        <label>Niveau</label>
        <input type="text" name="niveau" class="w-full p-3 bg-black/40 border border-white/20 rounded"
                  rows="4"><?= $sportif['niveau'] ?></input>
    </div>

    <button name="save"
            class="bg-emerald-400 text-black px-6 py-2 rounded-lg font-bold hover:bg-emerald-300">
        Enregistrer
    </button>
</form>

</body>
</html>
