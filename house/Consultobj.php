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

// Mise à jour des objets lors d'une soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['objet_id'])) {
    $objet_id = $_POST['objet_id'];
    $nouvel_etat = $_POST['etat'] ?? null;
    $nouvelle_temperature = $_POST['temperature'] ?? null;
    $nouveau_programme = $_POST['programme'] ?? null;
    $nouvelle_duree = $_POST['duree'] ?? null;
    $nouveau_mode = $_POST['mode'] ?? null;
    $nouvelle_chaine = $_POST['chaine'] ?? null;
    $nouveau_volume = $_POST['volume'] ?? null;

    $sql = "UPDATE objets SET etat = :etat";
    $params = ['etat' => $nouvel_etat, 'id' => $objet_id];

    if ($nouvelle_temperature !== null) {
        $sql .= ", temperature = :temperature";
        $params['temperature'] = $nouvelle_temperature;
    }
    if ($nouveau_programme !== null) {
        $sql .= ", programme = :programme";
        $params['programme'] = $nouveau_programme;
    }
    if ($nouvelle_duree !== null) {
        $sql .= ", duree = :duree";
        $params['duree'] = $nouvelle_duree;
    }
    if ($nouveau_mode !== null) {
        $sql .= ", mode = :mode";
        $params['mode'] = $nouveau_mode;
    }
    if ($nouvelle_chaine !== null) {
        $sql .= ", chaine = :chaine";
        $params['chaine'] = $nouvelle_chaine;
    }
    if ($nouveau_volume !== null) {
        $sql .= ", volume = :volume";
        $params['volume'] = $nouveau_volume;
    }

    $sql .= " WHERE id = :id";
    $stmt = $bdd->prepare($sql);
    $stmt->execute($params);

    header("Location: ConsultObj.php");
    exit();
}

// Récupération des objets
$sql = "SELECT * FROM objets";
$stmt = $bdd->prepare($sql);
$stmt->execute();
$objets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Consultation des Objets</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<a href="profil.php">Modifier mon profil</a>
<div id="app" class="p-6">
    <h2 class="text-2xl font-bold mb-4">Liste des Objets</h2>
    <div class="grid grid-cols-3 gap-4">
        <div v-for="objet in objets" :key="objet.id" class="border p-4 rounded-lg shadow-md">
            <img :src="objet.image_url" :alt="objet.nom" class="w-full h-32 object-cover rounded-md">
            <h3 class="text-lg font-semibold mt-2">{{ objet.nom }}</h3>
            <p class="text-gray-600">Type: {{ objet.type }}</p>
            <p class="font-bold" :class="{'text-green-600': objet.etat === 'allumé', 'text-red-600': objet.etat === 'éteint'}">État: {{ objet.etat }}</p>
            
            <form method="post" class="mt-2">
                <input type="hidden" name="objet_id" :value="objet.id">
                
                <label class="block text-sm font-medium">État:</label>
                <select name="etat" class="border p-1 rounded w-full">
                    <option value="allumé">Allumé</option>
                    <option value="éteint">Éteint</option>
                    <option value="en_cours">En cours</option>
                </select>
                
                <div v-if="objet.type === 'chauffage'">
                    <label class="block text-sm font-medium">Température:</label>
                    <input type="number" name="temperature" :value="objet.temperature" class="border p-1 rounded w-full">
                </div>
                
                <div v-if="objet.type === 'television'">
                    <label class="block text-sm font-medium">Chaîne:</label>
                    <input type="text" name="chaine" :value="objet.chaine" class="border p-1 rounded w-full">
                    <label class="block text-sm font-medium">Volume:</label>
                    <input type="number" name="volume" :value="objet.volume" class="border p-1 rounded w-full">
                </div>
                
                <button type="submit" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Mettre à jour</button>
            </form>
        </div>
    </div>
</div>

<script>
const { createApp } = Vue;
createApp({
    data() {
        return {
            objets: <?php echo json_encode($objets); ?>
        };
    }
}).mount('#app');
</script>
</body>
</html>
