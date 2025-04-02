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
    $consomation = $_POST['consomation'] ?? null;
    $connectivite = $_POST['connectivite'] ?? null;

    // Insertion des données dans la base
    $sql = "INSERT INTO objets (nom, type, etat, image_url, temperature, programme, duree, mode, position, chaine, volume, consomation, connectivite)
            VALUES (:nom, :type, :etat, :image_url, :temperature, :programme, :duree, :mode, :position, :chaine, :volume, :consomation, :connectivite)";
    
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
        'volume' => $volume,
        'consomation' => $consomation,
        'connectivite' => $connectivite
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
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #1e1e1e;
            color: #f0f0f0;
            margin: 0;
            padding: 2rem;
        }
        a {
            color: #00bcd4;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        h2 {
            text-align: center;
            margin-bottom: 2rem;
        }
        form {
            max-width: 600px;
            margin: auto;
            background-color: #2a2a2a;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.4);
        }
        label {
            display: block;
            margin-bottom: 1rem;
        }
        input[type="text"],
        input[type="number"],
        input[type="file"],
        select {
            width: 100%;
            padding: 0.5rem;
            border: none;
            border-radius: 8px;
            margin-top: 0.5rem;
        }
        button {
            background-color: #4caf50;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #388e3c;
        }
    </style>
</head>
<body>
<a href="Objadmin.php">&#8592; Retour</a>
<h2>Créer un Nouvel Objet</h2>
<div id="app">
    <form method="post" enctype="multipart/form-data">
        <label>Nom:
            <input type="text" name="nom" required>
        </label>
        <label>Image:
            <input type="file" name="photo" accept="image/*" required>
        </label>
        <label>Type:
            <select name="type" v-model="selectedType">
                <option value="chauffage">Chauffage</option>
                <option value="machine_laver">Machine à laver</option>
                <option value="four">Four</option>
                <option value="rideaux">Rideaux</option>
                <option value="lave_vaisselle">Lave-vaisselle</option>
                <option value="television">Télévision</option>
                <option value="lumiere">Lumière</option>
            </select>
        </label>
        <label>État:
            <select name="etat">
                <option value="allumé">Allumé</option>
                <option value="éteint">Éteint</option>
            </select>
        </label>
        <label>Connectivité:
            <select name="connectivite">
                <option value="Wifi">Wifi</option>
                <option value="Ethernet">Ethernet</option>
                <option value="Bluetooth">Bluetooth</option>
                <option value="NON">Aucune</option>
            </select>
        </label>
        <label>Consommation:
            <input type="number" name="consomation">
        </label>

        <div v-if="selectedType === 'chauffage'">
            <label>Température:
                <input type="number" name="temperature">
            </label>
        </div>

        <div v-if="selectedType === 'machine_laver' || selectedType === 'lave_vaisselle'">
            <label>Programme:
                <select name="programme">
                    <option value="Normal">Normal</option>
                    <option value="Intensif">Intensif</option>
                    <option value="Éco">Éco</option>
                    <option value="Rapide">Rapide</option>
                </select>
            </label>
            <label>Durée:
                <input type="number" name="duree">
            </label>
        </div>

        <div v-if="selectedType === 'four'">
            <label>Mode:
                <select name="mode">
                    <option value="Convection">Convection</option>
                    <option value="Grill">Grill</option>
                    <option value="Chaleur_tournante">Chaleur tournante</option>
                </select>
            </label>
            <label>Durée:
                <input type="number" name="duree">
            </label>
        </div>

        <div v-if="selectedType === 'rideaux'">
            <label>Position:
                <select name="position">
                    <option value="Ouvert">Ouvert</option>
                    <option value="Ferme">Fermé</option>
                </select>
            </label>
        </div>

        <div v-if="selectedType === 'television'">
            <label>Chaîne:
                <input type="text" name="chaine">
            </label>
            <label>Volume:
                <input type="number" name="volume">
            </label>
        </div>

        <button type="submit">Créer</button>
    </form>
</div>
<script>
const { createApp } = Vue;
createApp({
    data() {
        return {
            selectedType: ''  // Permet de gérer dynamiquement les champs affichés
        };
    }
}).mount('#app');
</script>
</body>
</html>
