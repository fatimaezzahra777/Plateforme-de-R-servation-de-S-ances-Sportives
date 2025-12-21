<?php
session_start();
require 'config.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'coach') {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

if (!isset($_GET['id'], $_GET['action'])) {
    header("Location: profil.php");
    exit;
}

$id_reservation = intval($_GET['id']);
$action = $_GET['action'];

if ($action === 'accept') {
    $statut = 'acceptée';
} elseif ($action === 'refuse') {
    $statut = 'refusée';
} else {
    header("Location: profil.php");
    exit;
}

$stmt = $conn->prepare("
    SELECT r.id_reserv
    FROM reservation r
    JOIN coach c ON r.id_coach = c.id
    WHERE r.id_reserv = ? AND c.id_user = ?
");
$stmt->bind_param("ii", $id_reservation, $id_user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Réservation introuvable ou non autorisée !");
}

$stmt = $conn->prepare("UPDATE reservation SET statut = ? WHERE id_reserv = ?");
$stmt->bind_param("si", $statut, $id_reservation);
$stmt->execute();

header("Location: profil.php");
exit;
