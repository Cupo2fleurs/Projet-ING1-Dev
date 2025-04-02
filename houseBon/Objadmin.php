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

    $sql = "DELETE FROM objets WHERE id = :id";
    $stmt = $bdd->prepare($sql);
    $stmt->execute(['id' => $delete_id]);

    $sql = "UPDATE users SET points = points + 1 WHERE id = :user_id";
    $stmt = $bdd->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);

    header("Location: Objadmin.php");
    exit();
}

// Récupération des objets
$stmt = $bdd->prepare("SELECT * FROM objets");
$stmt->execute();
$objets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration des Objets</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #1e1e1e;
            color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        nav {
            background-color: #121212;
            padding: 20px;
            display: flex;
            justify-content: space-between;
        }
        nav a {
            color: #00bcd4;
            font-weight: bold;
            text-decoration: none;
        }
        nav a:hover {
            text-decoration: underline;
        }
        #app {
            padding: 2rem;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }
        .card {
            background-color: #2a2a2a;
            border-radius: 12px;
            padding: 1rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
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
            margin-top: 1rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-align: center;
            font-weight: bold;
            cursor: pointer;
        }
        .btn-red {
            background-color: #f44336;
            color: white;
        }
        .btn-red:hover {
            background-color: #e53935;
        }
        input[type="text"] {
            width: 100%;
            max-width: 400px;
            padding: 0.5rem;
            border-radius: 8px;
            border: none;
            margin-top: 1rem;
        }
        h2 {
            text-align: center;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <nav>
        <a href="Consultobj.php">&#8592; Retour</a>
        <a href="Creaobj.php">+ Créer un Objet</a>
    </nav>

    <div id="app">
        <h2>Gestion des Objets</h2>
        <center>
            <input type="text" v-model="search" placeholder="Rechercher un objet...">
        </center>
        <div class="grid">
            <div v-for="objet in filteredObjets" :key="objet.id" class="card">
                <img :src="objet.image_url" :alt="objet.nom">
                <h3>{{ objet.nom }}</h3>
                <p>Type: {{ objet.type }}</p>
                <p :class="{'text-green-400': objet.etat === 'allumé', 'text-red-400': objet.etat === 'eteint'}">
                    État: {{ objet.etat }}
                </p>
                <form method="post">
                    <input type="hidden" name="delete_id" :value="objet.id">
                    <button type="submit" class="btn btn-red">Supprimer (+1pt)</button>
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
                    objets: <?= json_encode($objets) ?>
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
