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
$sql = "SELECT id, pseudo, age, sexe, grade, photo FROM users";
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
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
        }

        .top-links {
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding: 10px 20px;
        }

        .container {
            width: 80%;
            max-width: 1000px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            text-align: center;
        }

        .search-bar {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .profile-card {
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            text-align: left;
            transition: transform 0.2s;
        }

        .profile-card:hover {
            transform: scale(1.05);
        }

        .profile-card img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
            margin-right: 15px;
        }

        .profile-info {
            flex: 1;
        }

        .admin-actions {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="top-links">
        <a href="Creaprofil.php" class="text-2xl font-bold mb-4 text-green-600 hover:underline">Modifier mon profil</a>
        <a href="Consultobj.php" class="text-2xl font-bold mb-4 text-blue-600 hover:underline">Consulter les objets</a>
    </div>

    <div id="app" class="container">
        <h1 class="text-2xl font-bold">Liste des Profils</h1>
        <input type="text" v-model="search" placeholder="Rechercher un profil..." class="search-bar">
        <div v-if="filteredProfiles.length" class="grid-container">
            <div v-for="profil in filteredProfiles" :key="profil.id" class="profile-card">
                <img :src="profil.photo" :alt="profil.pseudo">
                <div class="profile-info">
                    <h3>@{{ profil.pseudo }}</h3>
                    <p><strong>Âge:</strong> {{ profil.age }}</p>
                    <p><strong>Sexe:</strong> {{ profil.sexe }}</p>
                    <p><strong>Grade:</strong> {{ profil.grade }}</p>
                </div>
                <?php if ($points >= 8) : ?>
                    <div class="admin-actions">
                        <a :href="'admin_users.php?edit_id=' + profil.id" class="bg-blue-500 text-white px-3 py-1 rounded">Modifier</a>
                        <form method="post" action="admin_users.php" style="display:inline;">
                            <input type="hidden" name="delete_id" :value="profil.id">
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">Supprimer</button>
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
                profiles: <?php echo json_encode($users); ?>
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
