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

$user_id = $_SESSION['user_id'];

// Suppression d'un objet
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];

    // Supprimer l'objet
    $sql = "DELETE FROM objets WHERE id = :id";
    $stmt = $bdd->prepare($sql);
    $stmt->execute(['id' => $delete_id]);

    // Ajouter 1 point à l'utilisateur
    $sql = "UPDATE users SET points = points + 1 WHERE id = :user_id";
    $stmt = $bdd->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);

    header("Location: Objadmin.php");
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
    <title>Administration des Objets</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<div style="display: flex; justify-content: space-between; align-items: center; padding: 10px;">  
    <div style="text-align: right; padding: 20px;">
        <a href="Consultobj.php" class="text-2xl font-bold text-blue-500 mb-4">&#8592; Retour</a>
    </div>
    <div style="text-align: left; padding: 20px;">
        <a href="Creaobj.php" class="text-xl font-bold text-green-500 hover:underline">Créer un Objet</a>
    </div>
</div>

<div id="app" class="p-6">
    <center>
        <h2 class="text-2xl font-bold mb-4">Gestion des Objets</h2>
        <input type="text" v-model="search" placeholder="Rechercher un objet..." class="border p-2 rounded w-1/2">
    </center>
    
    <div class="grid grid-cols-3 gap-4 mt-4">
        <div v-for="objet in filteredObjets" :key="objet.id" class="border p-4 rounded-lg shadow-md">
            <img :src="objet.image_url" :alt="objet.nom">
            <h3 class="text-lg font-semibold mt-2">{{ objet.nom }}</h3>
            <p class="text-gray-600">Type: {{ objet.type }}</p>
            <p class="font-bold" :class="{'text-green-600': objet.etat === 'allumé', 'text-red-600': objet.etat === 'éteint'}">État: {{ objet.etat }}</p>
            
            <form method="post" class="mt-2">
                <input type="hidden" name="delete_id" :value="objet.id">
                <button type="submit" class="mt-2 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700 transition">Supprimer (+1pts)</button>
            </form>
        </div>
    </div>
</div>

<script>
const { createApp } = Vue;
createApp({
    data() {
        return {
            search: '',
            objets: <?php echo json_encode($objets); ?>
        };
    },
    computed: {
        filteredObjets() {
            return this.objets.filter(objet => {
                const searchLower = this.search.toLowerCase();
                return Object.values(objet).some(value => 
                    value && value.toString().toLowerCase().includes(searchLower)
                );
            });
        }
    }
}).mount('#app');
</script>
</body>
</html>
