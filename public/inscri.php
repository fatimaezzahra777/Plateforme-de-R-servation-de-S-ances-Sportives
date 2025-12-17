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
        $photo = null ;
        if (!empty($_FILES['photo']['name']) && $_FILES['photo']['error'] === 0) {
         $photoName = uniqid() . "_" . $_FILES['photo']['name'];
         move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/" . $photoName);
    }
     $stmt2 = $conn->prepare("
            INSERT INTO coach (id_user, experience, biographie, photo)
            VALUES (?, ?, ?, ?)
        ");
        $stmt2->bind_param("iiss", $id_user, $experience, $biographie, $photoName);
        $stmt2->execute();
}


        header("Location: login.php");
        exit;
}
}
?>


<!DOCTYPE html><nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg sticky top-0 z-50">

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>SportCoach - Inscription</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="./assets/css/index.css">
</head>

<body class="bg-gray-50">

<!-- NAVBAR -->
    <div class="max-w-7xl mx-auto px-4 h-16 flex justify-between items-center">
        <div class="flex items-center space-x-2">
            <i class="fas fa-dumbbell text-2xl"></i>
            <span class="text-xl font-bold">SportCoach</span>
        </div>
        <div class="hidden md:flex space-x-6">
            <a href="index.php">Accueil</a>
            <a href="coach.php">Coachs</a>
            <a href="sportif.php">Sportifs</a>
            <a href="login.php">Connexion</a>
            <a href="inscri.php" class="font-bold underline">Inscription</a>
        </div>
        <button class="md:hidden" onclick="toggleMobileMenu()">
            <i class="fas fa-bars text-2xl"></i>
        </button>
    </div>

    <div id="mobileMenu" class="hidden md:hidden px-4 pb-4 space-y-2">
        <a href="index.php">Accueil</a>
        <a href="coach.php">Coachs</a>
        <a href="sportif.php">Sportifs</a>
        <a href="login.php">Connexion</a>
        <a href="inscri.php">Inscription</a>
    </div>
</nav>

<!-- INSCRIPTION -->
<div class="min-h-screen bg-gradient-to-br from-blue-600 to-blue-900 flex items-center justify-center px-4 py-12">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-2xl">

        <div class="text-center mb-8">
            <i class="fas fa-user-plus text-blue-600 text-5xl mb-4"></i>
            <h2 class="text-3xl font-bold text-gray-800">Inscription</h2>
            <p class="text-gray-600 mt-2">Créez votre compte</p>
        </div>

        <!-- CHOIX ROLE -->
        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-3">Je suis :</label>
            <div class="grid grid-cols-2 gap-4">
                <button type="button" id="athleteBtn"
                        onclick="selectRole('sportif')"
                        class="border-2 border-blue-600 bg-blue-50 text-blue-600 py-3 rounded-lg font-semibold">
                    <i class="fas fa-running mr-2"></i> Sportif
                </button>

                <button type="button" id="coachBtn"
                        onclick="selectRole('coach')"
                        class="border-2 border-gray-300 text-gray-600 py-3 rounded-lg font-semibold">
                    <i class="fas fa-whistle mr-2"></i> Coach
                </button>
            </div>
        </div>

        <!-- FORMULAIRE -->
        <form method="POST" enctype="multipart/form-data" class="space-y-4">

            <input type="hidden" name="role" id="role" value="sportif">

            <div class="grid md:grid-cols-2 gap-4" id="nom">
                <input type="text" name="nom" placeholder="Nom" required
                       class="w-full border rounded-lg px-4 py-3">
                <input type="text" name="niveau" placeholder="Niveau" id="niveau"
                       class="w-full border rounded-lg px-4 py-3">
            </div>

            <input type="email" name="email" placeholder="Email" required
                   class="w-full border rounded-lg px-4 py-3">

            <input type="tel" name="telephone" placeholder="Téléphone" required
                   class="w-full border rounded-lg px-4 py-3">

            <input type="password" name="password" placeholder="Mot de passe" required
                   class="w-full border rounded-lg px-4 py-3">

            <input type="password" name="confirm_password" placeholder="Confirmer mot de passe" required
                   class="w-full border rounded-lg px-4 py-3">

            <!-- CHAMPS COACH -->
            <div id="coachFields" class="hidden space-y-4">

                <input type="number" name="experience" min="0"
                       placeholder="Années d'expérience"
                       class="w-full border rounded-lg px-4 py-3">

                <textarea name="biographie" rows="4"
                          placeholder="Biographie"
                          class="w-full border rounded-lg px-4 py-3"></textarea>

                <input type="file" name="photo" accept="image/*"
                       class="w-full border rounded-lg px-4 py-3">
            </div>

            <div class="flex items-start">
                <input type="checkbox" required class="mt-1 mr-2">
                <span class="text-sm">J'accepte les <a href="conditions.php" class="text-blue-600">conditions</a></span>
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700">
                Créer mon compte
            </button>
        </form>

        <p class="mt-6 text-center text-gray-600">
            Déjà inscrit ?
            <a href="login.php" class="text-blu e-600 font-medium hover:underline">Connexion</a>
        </p>

        <?php if (!empty($error)): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <?php echo $error; ?>
    </div>
<?php endif; ?>


    </div>
</div>

<!-- JS -->
<script src="./assets/js/index.js"></script>

</body>
</html>
