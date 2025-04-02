<?php
session_start();

// Connexion à la base de données
try {
    $pdo_option = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    $bdd = new PDO('mysql:host=localhost;dbname=utilisateur', 'root', '', $pdo_option);
} catch (Exception $ex) {
    die("Erreur : " . $ex->getMessage());
}

// Vérification de la connexion
if (!isset($_SESSION['user_id'])) {
    echo "<p style='color:red;'>Vous devez être connecté.</p>";
    exit();
}

$user_id = $_SESSION['user_id'];

// Récupération des points de l'utilisateur
$sql = "SELECT points FROM users WHERE id = :user_id";
$stmt = $bdd->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$points = $user['points'] ?? 0;

// Récupération des utilisateurs
$sql = "SELECT id, pseudo, age, sexe, grade, photo, points FROM users";
$stmt = $bdd->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Profils</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #1e1e1e;
            color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .top-links {
            display: flex;
            justify-content: space-between;
            padding: 1rem 2rem;
            background-color: #121212;
        }
        .top-links a {
            color: #00bcd4;
            font-weight: bold;
            text-decoration: none;
        }
        .top-links a:hover {
            text-decoration: underline;
        }
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: #2a2a2a;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
        }
        h1 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #00bcd4;
        }
        .search-bar {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 2rem;
            border-radius: 8px;
            border: none;
            font-size: 1rem;
        }
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }
        .profile-card {
            background-color: #3a3a3a;
            padding: 1.5rem;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease;
        }
        .profile-card:hover {
            transform: translateY(-5px);
        }
        .profile-card img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 1rem;
        }
        .profile-info h3 {
            margin: 0.5rem 0;
            color: #ffffff;
        }
        .profile-info p {
            margin: 0.25rem 0;
            color: #cccccc;
            font-size: 0.95rem;
        }
        .admin-actions {
            margin-top: 1rem;
        }
        .admin-actions a,
        .admin-actions button {
            background-color: #00bcd4;
            text-decoration:none;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 8px;
            margin: 0.25rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .admin-actions button {
            background-color: #f44336;
            height:38px;
            font-size:15px;
        }
        .admin-actions a:hover {
            background-color: #0097a7;
        }
        .admin-actions button:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <div class="top-links">
        <a href="Creaprofil.php">Modifier mon profil</a>
        <a href="Consultobj.php">Consulter les objets</a>
    </div>
    <div id="app" class="container">
        <h1>Liste des Profils</h1>
        <input type="text" v-model="search" placeholder="Rechercher un profil..." class="search-bar">
        <div v-if="filteredProfiles.length" class="grid-container">
            <div v-for="profil in filteredProfiles" :key="profil.id" class="profile-card">
                <img :src="profil.photo" :alt="profil.pseudo">
                <div class="profile-info">
                    <h3>@{{ profil.pseudo }}</h3>
                    <p><strong>Âge:</strong> {{ profil.age }}</p>
                    <p><strong>Sexe:</strong> {{ profil.sexe }}</p>
                    <p><strong>Rôle:</strong> {{ profil.grade }}</p>
                    <p><strong>Niveau:</strong> {{ profil.points }}</p>
                </div>
                <?php if ($points >= 8) : ?>
                    <div class="admin-actions">
                        <a :href="'admin_users.php?edit_id=' + profil.id">Modifier</a>
                        <form method="post" action="admin_users.php" style="display:inline;">
                            <input type="hidden" name="delete_id" :value="profil.id">
                            <button type="submit">Supprimer</button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <p v-else>Aucun profil ne correspond à votre recherche.</p>
    </div>
    <script>
        new Vue({
            el: '#app',
            data: {
                search: '',
                profiles: <?= json_encode($users) ?>
            },
            computed: {
                filteredProfiles() {
                    return this.profiles.filter(profil => {
                        return Object.values(profil).some(value =>
                            String(value).toLowerCase().includes(this.search.toLowerCase())
                        );
                    });
                }
            }
        });
    </script>
</body>
</html>
