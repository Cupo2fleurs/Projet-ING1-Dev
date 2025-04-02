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

// Traitement des actions utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['objet_id'], $_POST['view_details'])) {
        $points++;
        $objet_id = $_POST['objet_id'];
        $stmt = $bdd->prepare("UPDATE users SET points = :points WHERE id = :user_id");
        $stmt->execute(['points' => $points, 'user_id' => $user_id]);

        $stmt = $bdd->prepare("UPDATE objets SET consult = NOW() WHERE id = :objet_id");
        $stmt->execute(['objet_id' => $objet_id]);

        $sql = "INSERT INTO utilisations (user_id, objet_id) VALUES (:user_id, :objet_id)";
        $stmt = $bdd->prepare($sql);
        $stmt->execute(['user_id' => $user_id, 'objet_id' => $objet_id]);
    }

    if (isset($_POST['objet_id'], $_POST['modifier_details']) && $points >= 5) {
        $points++;
        $objet_id = $_POST['objet_id'];
        $stmt = $bdd->prepare("UPDATE users SET points = :points WHERE id = :user_id");
        $stmt->execute(['points' => $points, 'user_id' => $user_id]);

        $stmt = $bdd->prepare("UPDATE objets SET consult = NOW() WHERE id = :objet_id");
        $stmt->execute(['objet_id' => $objet_id]);

        $sql = "INSERT INTO utilisations (user_id, objet_id) VALUES (:user_id, :objet_id)";
        $stmt = $bdd->prepare($sql);
        $stmt->execute(['user_id' => $user_id, 'objet_id' => $objet_id]);

        $params = ['id' => $objet_id, 'etat' => $_POST['etat'] ?? null];
        $updates = ['etat = :etat'];

        foreach (['temperature', 'programme', 'duree', 'mode', 'chaine', 'volume', 'position','connectivite','consomation'] as $field) {
            if (!empty($_POST[$field])) {
                $updates[] = "$field = :$field";
                $params[$field] = $_POST[$field];
            }
        }

        $sql = "UPDATE objets SET " . implode(", ", $updates) . " WHERE id = :id";
        $stmt = $bdd->prepare($sql);
        $stmt->execute($params);

        header("Location: ConsultObj.php");
        exit();
    }
}

$stmt = $bdd->query("SELECT * FROM objets");
$objets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Consultation des Objets</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.js"></script>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #1e1e1e;
            color: #f0f0f0;
        }
        nav {
            background-color: #121212;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav a {
            color: #00bcd4;
            margin: 0 1rem;
            text-decoration: none;
            font-weight: bold;
        }
        nav a:hover {
            text-decoration: underline;
        }
        #app {
            padding: 2rem;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        .card {
            background-color: #2a2a2a;
            border-radius: 12px;
            padding: 1rem;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card img {
            max-width: 100%;
            border-radius: 8px;
        }
        .btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-align: center;
            margin-top: 0.5rem;
            font-weight: bold;
        }
        .btn-blue {
            background-color: #00bcd4;
            color: white;
        }
        .btn-green {
            background-color: #4caf50;
            color: white;
        }
        .btn-red {
            background-color: #f44336;
            color: white;
        }
        .btn:hover {
            opacity: 0.8;
        }
        select, input[type="text"], input[type="number"] {
            width: 100%;
            padding: 0.4rem;
            margin: 0.3rem 0;
            border-radius: 5px;
            border: none;
        }
    </style>
</head>
<body>
<nav>
    <div>
        <a href="Creaprofil.php">Modifier mon profil</a>
        <a href="liste_profil.php">Liste des profils</a>
    </div>
    <div>
        <?php if ($points >= 5): ?>
            <a href="Objadmin.php">Créer/Supprimer Objet</a>
        <?php endif; ?>
        <?php if ($points >= 8): ?>
            <a href="admin_dashboard.php">Admin Dashboard</a>
        <?php endif; ?>
        <a href="freetour.php">Free Tour</a>
    </div>
    <div>
        <a href="deconnexion.php">Déconnexion</a>
    </div>
</nav>

<div id="app">
    <center>
        <h2 class="text-2xl font-bold mb-4">Liste des Objets</h2>
        <p class="text-lg font-semibold">Vos points : <span style="color: #00bcd4">{{ points }}</span></p>
        <input type="text" v-model="search" placeholder="Rechercher un objet..." class="border p-2 rounded w-1/2">
    </center>

    <div class="grid mt-6">
        <div v-for="objet in filteredObjets" :key="objet.id" class="card">
            <img :src="objet.image_url" :alt="objet.nom">
            <h3 class="text-lg font-semibold mt-2">{{ objet.nom }}</h3>
            <p>Type: {{ objet.type }}</p>
            <p :class="{'text-green-400': objet.etat === 'allumé', 'text-red-400': objet.etat === 'éteint'}">État: {{ objet.etat }}</p>

            <button @click="toggleDetails(objet)" class="btn btn-blue">
                {{ objet.showDetails ? 'Masquer détails' : 'Voir détails' }}
            </button>

            <div v-if="objet.showDetails" class="mt-3">
    <form method="post">
        <input type="hidden" name="objet_id" :value="objet.id">
        <input type="hidden" name="view_details" value="1">
        <p v-if="objet.type === 'chauffage'">Température: {{ objet.temperature }}°C <br>Consulté le: {{ objet.consult }} <br>Connectivité: {{ objet.connectivite }}, Consomation: {{ objet.consomation }}kWh</p>
        <p v-if="objet.type === 'television'">Chaîne: {{ objet.chaine }}, Volume: {{ objet.volume }} <br> Consulté le: {{ objet.consult }}<br>Connectivité: {{ objet.connectivite }}, Consomation: {{ objet.consomation }}kWh</p>
        <p v-if="objet.type === 'machine_laver'">Programme: {{ objet.programme }}, Durée: {{ objet.duree }}min <br> Consulté le: {{ objet.consult }}<br>Connectivité: {{ objet.connectivite }}, Consomation: {{ objet.consomation }}kWh</p>
        <p v-if="objet.type === 'lave_vaisselle'">Programme: {{ objet.programme }}, Durée: {{ objet.duree }}min <br> Consulté le: {{ objet.consult }}<br>Connectivité: {{ objet.connectivite }}, Consomation: {{ objet.consomation }}kWh</p>
        <p v-if="objet.type === 'four'">Mode: {{ objet.mode }}, Durée: {{ objet.duree }}min<br> Consulté le: {{ objet.consult }}<br>Connectivité: {{ objet.connectivite }}, Consomation: {{ objet.consomation }}kWh</p>
        <p v-if="objet.type === 'rideaux'">Position: {{ objet.position }}<br> Consulté le: {{ objet.consult }}<br>Connectivité: {{ objet.connectivite }}, Consomation: {{ objet.consomation }}kWh</p>
        <p v-if="objet.type === 'lumiere'">Connectivité: {{ objet.connectivite }}, Consomation: {{ objet.consomation }}kWh</p>
        <button type="submit" class="btn btn-green">Valider la consultation (+1pt)</button>
    </form>

    <form v-if="points >= 5" method="post" class="mt-3">
        <input type="hidden" name="objet_id" :value="objet.id">
        <input type="hidden" name="modifier_details" value="1">

        <label>État:</label>
        <select name="etat">
            <option value="allumé">Allumé</option>
            <option value="éteint">Éteint</option>
        </select>

        <div v-if="objet.type === 'chauffage'">
            <label>Température:</label>
            <input type="number" name="temperature" :value="objet.temperature">
        </div>

        <div v-if="objet.type === 'television'">
            <label>Chaîne:</label>
            <input type="text" name="chaine" :value="objet.chaine">
            <label>Volume:</label>
            <input type="number" name="volume" :value="objet.volume">
        </div>

        <div v-if="objet.type === 'machine_laver' || objet.type === 'lave_vaisselle'">
            <label>Programme:</label>
            <select name="programme">
                <option value="Normale">Normale</option>
                <option value="Intensif">Intensif</option>
                <option value="Eco">Eco</option>
                <option value="Rapide">Rapide</option>
            </select>
            <label>Durée:</label>
            <input type="text" name="duree" :value="objet.duree">
        </div>

        <div v-if="objet.type === 'four'">
            <label>Mode:</label>
            <select name="mode">
                <option value="Convection">Convection</option>
                <option value="Grill">Grill</option>
                <option value="Chaleur_tournante">Chaleur tournante</option>
            </select>
            <label>Durée:</label>
            <input type="text" name="duree" :value="objet.duree">
        </div>

        <div v-if="objet.type === 'rideaux'">
            <label>Position:</label>
            <select name="position">
                <option value="Ouvert">Ouvert</option>
                <option value="Ferme">Fermé</option>
            </select>
        </div>

        <button type="submit" class="btn btn-red">Modifier les détails (+1pt)</button>
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
            objets: <?= json_encode($objets) ?>
        };
    },
    computed: {
        filteredObjets() {
            return this.objets.filter(objet => {const searchLower = this.search.toLowerCase();
                return Object.values(objet).some(value => value && value.toString().toLowerCase().includes(searchLower));
            });
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