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

// Récupération des points de l'utilisateur
$stmt = $bdd->prepare("SELECT points FROM users WHERE id = :user_id");
$stmt->execute(['user_id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$points = $user['points'] ?? 0;

// Mise à jour des points après consultation des détails ou modification
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['objet_id']) && isset($_POST['view_details'])) {
    $points++;
    $objet_id = $_POST['objet_id'];
    $stmt = $bdd->prepare("UPDATE users SET points = :points WHERE id = :user_id");
    $stmt->execute(['points' => $points, 'user_id' => $user_id]);
    // Enregistrer Consultation objet
    $stmt = $bdd->prepare("UPDATE objets SET consult = NOW() WHERE id = :objet_id");
    $stmt->execute(['objet_id' => $objet_id]);

     // Enregistrer l'utilisation
     $sql = "INSERT INTO utilisations (user_id, objet_id) VALUES (:user_id, :objet_id)";
     $stmt = $bdd->prepare($sql);
     $stmt->execute(['user_id' => $user_id, 'objet_id' => $_POST['objet_id']]);
}

// Mise à jour des points et des objets si l'utilisateur a 3 points ou plus
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['objet_id']) && isset($_POST['modifier_details']) && $points >= 5) {
    $points++; // Ajout de 1 point pour la modification des détails
    $objet_id = $_POST['objet_id'];
    $stmt = $bdd->prepare("UPDATE users SET points = :points WHERE id = :user_id");
    $stmt->execute(['points' => $points, 'user_id' => $user_id]);
    
    $stmt = $bdd->prepare("UPDATE objets SET consult = NOW() WHERE id = :objet_id");
    $stmt->execute(['objet_id' => $objet_id]);

    // Enregistrer l'utilisation
    $sql = "INSERT INTO utilisations (user_id, objet_id) VALUES (:user_id, :objet_id)";
    $stmt = $bdd->prepare($sql);
    $stmt->execute(['user_id' => $user_id, 'objet_id' => $_POST['objet_id']]);

    $objet_id = $_POST['objet_id'];
    $nouvel_etat = $_POST['etat'] ?? null;
    $nouvelle_temperature = $_POST['temperature'] ?? null;
    $nouveau_programme = $_POST['programme'] ?? null;
    $nouvelle_duree = $_POST['duree'] ?? null;
    $nouveau_mode = $_POST['mode'] ?? null;
    $nouvelle_chaine = $_POST['chaine'] ?? null;
    $nouveau_volume = $_POST['volume'] ?? null;
    $nouvelle_position = $_POST['position'] ?? null;

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
    if ($nouvelle_position !== null) {
        $sql .= ", position = :position";
        $params['position'] = $nouvelle_position;
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

<!-- Barre de navigation horizontale -->
<nav class="bg-blue-500 p-4">
<div style="display: flex; justify-content: space-between; padding: 10px;">  
<div style="text-align: left;">
    <a href="Creaprofil.php" class="text-2xl font-bold  text-green-500 hover:underline">Modifier mon profil</a></br>
<a href="liste_profil.php" class="text-2xl font-bold text-green-500 hover:underline">Liste des profils</a>
</div>
<div style="text-align: center; padding-right: 50px;">
<?php if ($points >= 5): ?>
            <a href="Objadmin.php" class="text-white text-xl font-bold hover:underline">Créer/Supprimer Objet</a></br>
        <?php endif; ?>
        <?php if ($points >= 8): ?>
            <a href="admin_dashboard.php" class="text-white text-xl font-bold hover:underline">Admin Dashboard</a></br>
        <?php endif; ?>
    <a href="freetour.php" class="text-white text-xl font-bold hover:underline">Free Tour</a>
</div>
<div style="text-align: right;">
    <a href="deconnexion.php" class="text-2xl font-bold text-red-500 hover:underline">Déconnexion</a>
</div>
</div>
</nav>

<div id="app" class="p-6">
    <center>
        <h2 class="text-2xl font-bold mb-4">Liste des Objets</h2>
        <p class="text-lg font-semibold">Vos points : <span class="text-blue-600">{{ points }}</span></p>
        <input type="text" v-model="search" placeholder="Rechercher un objet..." class="border p-2 rounded w-1/2">
    </center>
    
    <div class="grid grid-cols-3 gap-4 mt-4">
        <div v-for="objet in filteredObjets" :key="objet.id" class="border p-4 rounded-lg shadow-md">
            <img :src="objet.image_url" :alt="objet.nom">
            <h3 class="text-lg font-semibold mt-2">{{ objet.nom }}</h3>
            <p class="text-gray-600">Type: {{ objet.type }}</p>
            <p class="font-bold" :class="{'text-green-600': objet.etat === 'allumé', 'text-red-600': objet.etat === 'éteint'}">État: {{ objet.etat }}</p>

            <button @click="toggleDetails(objet)" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                {{ objet.showDetails ? 'Masquer détails' : 'Voir détails' }}
            </button>

            <div v-if="objet.showDetails" class="mt-3">
                <form method="post">
                    <input type="hidden" name="objet_id" :value="objet.id">
                    <input type="hidden" name="view_details" value="1">

                    <p v-if="objet.type === 'chauffage'">Température: {{ objet.temperature }}, Consulté le:{{ objet.consult}}</p>
                    <p v-if="objet.type === 'television'">Chaîne: {{ objet.chaine }}, Volume: {{ objet.volume }}, Consulté le:{{ objet.consult}}</p>
                    <p v-if="objet.type === 'machine_laver'">Programme: {{ objet.programme }},   Durée: {{ objet.duree }}, Consulté le:{{ objet.consult}}</p>
                    <p v-if="objet.type === 'lave_vaisselle'">Programme: {{ objet.programme }}, Durée: {{ objet.duree }}, Consulté le:{{ objet.consult}}</p>
                    <p v-if="objet.type === 'four'">Mode: {{ objet.mode }}, Durée: {{ objet.duree }}, Consulté le:{{ objet.consult}}</p>
                    <p v-if="objet.type === 'rideaux'">Position: {{ objet.position }}, Consulté le:{{ objet.consult}}</p>

                    <button type="submit" class="mt-2 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                        Valider la consultation (+1pt)
                    </button>
                </form>

                <form v-if="points >= 5" method="post" class="mt-2">
                    <input type="hidden" name="objet_id" :value="objet.id">
                    <input type="hidden" name="modifier_details" value="1">
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
                    <div v-if="objet.type === 'machine_laver'">
                    <label class="block text-sm font-medium">Programme:</label>
                    <select name="programme" class="border p-1 rounded w-full">
                        <option value="Normale">Normale</option>
                        <option value="Intensif">Intensif</option>
                        <option value="Eco">Eco</option>
                        <option value="Rapide">Rapide</option>
                    </select>
                        <label class="block text-sm font-medium">Durée:</label>
                        <input type="duree" name="duree" :value="objet.duree" class="border p-1 rounded w-full">
                    </div>
                    <div v-if="objet.type === 'lave_vaisselle'">
                    <label class="block text-sm font-medium">Programme:</label>
                    <select name="programme" class="border p-1 rounded w-full">
                        <option value="Normale">Normale</option>
                        <option value="Intensif">Intensif</option>
                        <option value="Eco">Eco</option>
                        <option value="Rapide">Rapide</option>
                    </select>
                        <label class="block text-sm font-medium">Durée:</label>
                        <input type="duree" name="duree" :value="objet.duree" class="border p-1 rounded w-full">
                    </div>
                    <div v-if="objet.type === 'four'">
                    <label class="block text-sm font-medium">Mode:</label>
                    <select name="mode" class="border p-1 rounded w-full">
                        <option value="Convection">Convection</option>
                        <option value="Grill">Grill</option>
                        <option value="Chaleur_tournante">Chaleur tournante</option>
                    </select>
                        <label class="block text-sm font-medium">Durée:</label>
                        <input type="duree" name="duree" :value="objet.duree" class="border p-1 rounded w-full">
                    </div>
                    <div v-if="objet.type === 'rideaux'">
                    <label class="block text-sm font-medium">Position:</label>
                    <select name="position" class="border p-1 rounded w-full">
                        <option value="Ouvert">Ouvert</option>
                        <option value="Ferme">Fermé</option>
                    </select>
                    </div>
                    <button type="submit" class="mt-2 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                        Modifier les détails (+1pt)
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
const { createApp } = Vue;
createApp({
    data() {
        return {
            search: '',
            points: <?= $points ?>,
            objets: <?php echo json_encode($objets); ?>
        };
    },
    computed: {
        filteredObjets() {
            return this.objets.filter(objet => objet.nom.toLowerCase().includes(this.search.toLowerCase()));
        }
    },
    methods: {
        toggleDetails(objet) {
            objet.showDetails = !objet.showDetails;
        }
    }
}).mount('#app');
</script>

</body>
</html>
