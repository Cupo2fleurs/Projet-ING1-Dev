<?php
session_start();

// Connexion à la base de données
try {
    $pdo_option = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    $bdd = new PDO('mysql:host=localhost;dbname=utilisateur', 'root', '', $pdo_option);
} catch (Exception $ex) {
    die("Erreur : " . $ex->getMessage());
}

// Vérification de la connexion de l'utilisateur
if (!isset($_SESSION['user_id'])) {
    echo "<p style='color:red;'>Vous devez être connecté.</p>";
    exit();
}

// Traitement du formulaire d'ajout
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $type = $_POST['type'];
    $etat = $_POST['etat'];
    
    $image_url = ''; // Initialisation du chemin de l'image

    // Vérification et traitement de l'upload d'image
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true); // Création du dossier si nécessaire
        }

        $file_name = basename($_FILES['photo']['name']);
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $new_file_name = uniqid('img_') . '.' . $file_ext; // Génération d'un nom unique
        $file_path = $upload_dir . $new_file_name;

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $file_path)) {
            $image_url = $file_path; // Stocke le chemin de l'image
        } else {
            die("Erreur lors de l'upload de l'image.");
        }
    }

    // Champs spécifiques selon le type d'objet
    $temperature = $_POST['temperature'] ?? null;
    $programme = $_POST['programme'] ?? null;
    $duree = $_POST['duree'] ?? null;
    $mode = $_POST['mode'] ?? null;
    $position = $_POST['position'] ?? null;
    $chaine = $_POST['chaine'] ?? null;
    $volume = $_POST['volume'] ?? null;

    // Insertion des données dans la base
    $sql = "INSERT INTO objets (nom, type, etat, image_url, temperature, programme, duree, mode, position, chaine, volume)
            VALUES (:nom, :type, :etat, :image_url, :temperature, :programme, :duree, :mode, :position, :chaine, :volume)";
    
    $stmt = $bdd->prepare($sql);
    $stmt->execute([
        'nom' => $nom,
        'type' => $type,
        'etat' => $etat,
        'image_url' => $image_url, // Chemin stocké en base de données
        'temperature' => $temperature,
        'programme' => $programme,
        'duree' => $duree,
        'mode' => $mode,
        'position' => $position,
        'chaine' => $chaine,
        'volume' => $volume
    ]);

    header("Location: Objadmin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un Objet</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<div class="p-6">
    <a href="Objadmin.php" class="text-blue-500 hover:underline">&#8592; Retour</a>
    <h2 class="text-2xl font-bold mb-4">Créer un Nouvel Objet</h2>
 <div id="app">
        <form method="post" enctype="multipart/form-data" class="space-y-4">
            <label>Nom: <input type="text" name="nom" required class="border p-2 rounded w-full"></label>
            <label>Image: <input type="file" name="photo" accept="image/*" required class="border p-2"></label><br>
            <label>Type:
                <select name="type" v-model="selectedType" class="border p-2 rounded w-full">
                    <option value="chauffage">Chauffage</option>
                    <option value="machine_laver">Machine à laver</option>
                    <option value="four">Four</option>
                    <option value="rideaux">Rideaux</option>
                    <option value="lave_vaisselle">Lave-vaisselle</option>
                    <option value="television">Télévision</option>
                </select>
            </label>
            <label>État:
                <select name="etat" class="border p-2 rounded w-full">
                    <option value="allumé">Allumé</option>
                    <option value="éteint">Éteint</option>
                    <option value="en_cours">En cours</option>
                    <option value="fermé">Fermé</option>
                    <option value="ouvert">Ouvert</option>
                </select>
            </label>
            
            <div v-if="selectedType === 'chauffage'">
                <label>Température: <input type="number" name="temperature" class="border p-2 rounded w-full"></label>
            </div>
            <div v-if="selectedType === 'machine_laver' || selectedType === 'lave_vaisselle'">
                <label>Programme:
                    <select name="programme" class="border p-2 rounded w-full">
                        <option value="Normal">Normal</option>
                        <option value="Intensif">Intensif</option>
                        <option value="Éco">Éco</option>
                        <option value="Rapide">Rapide</option>
                    </select>
                </label>
                <label>Durée: <input type="number" name="duree" class="border p-2 rounded w-full"></label>
            </div>
            <div v-if="selectedType === 'four'">
                <label>Mode:
                    <select name="mode" class="border p-2 rounded w-full">
                        <option value="Convection">Convection</option>
                        <option value="Grill">Grill</option>
                        <option value="Chaleur tournante">Chaleur tournante</option>
                    </select>
                </label>
                <label>Durée: <input type="number" name="duree" class="border p-2 rounded w-full"></label>
            </div>
            <div v-if="selectedType === 'rideaux'">
                <label>Position:
                    <select name="position" class="border p-2 rounded w-full">
                        <option value="ouvert">Ouvert</option>
                        <option value="fermé">Fermé</option>
                    </select>
                </label>
            </div>
            <div v-if="selectedType === 'television'">
                <label>Chaîne: <input type="text" name="chaine" class="border p-2 rounded w-full"></label>
                <label>Volume: <input type="number" name="volume" class="border p-2 rounded w-full"></label>
            </div>

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700">Créer</button>
        </form>
    </div>
</div>

<script>
const { createApp } = Vue;
createApp({
    data() {
        return {
            selectedType: ''
        };
    }
}).mount('#app');
</script>

</body>
</html>
