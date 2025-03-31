<?php
session_start();

// Connexion à la base de données
try {
    $pdo_option = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    $bdd = new PDO('mysql:host=localhost;dbname=utilisateur', 'root', '', $pdo_option);
} catch (Exception $ex) {
    die("Erreur : " . $ex->getMessage());
}

// Récupérer l'historique des connexions
$sql = "SELECT users.pseudo, connexions.date_connexion FROM connexions JOIN users ON connexions.user_id = users.id ORDER BY date_connexion DESC";
$stmt = $bdd->prepare($sql);
$stmt->execute();
$connexions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer la liste des utilisateurs
$sql = "SELECT id, pseudo, points FROM users";
$stmt = $bdd->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les statistiques d'utilisation des objets
$sql = "SELECT objets.nom, COUNT(utilisations.id) AS total_utilisations FROM utilisations JOIN objets ON utilisations.objet_id = objets.id GROUP BY objets.nom ORDER BY total_utilisations DESC";
$stmt = $bdd->prepare($sql);
$stmt->execute();
$stats = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-5">
    <div class="container mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Tableau de bord Admin</h1>
        
        <!-- Historique des connexions -->
        <h2 class="text-xl font-semibold mt-4">Historique des connexions</h2>
        <table class="w-full mt-2 border">
            <tr class="bg-gray-200">
                <th class="p-2">Pseudo</th>
                <th class="p-2">Date de connexion</th>
            </tr>
            <?php foreach ($connexions as $connexion): ?>
                <tr>
                    <td class="p-2 border"> <?= htmlspecialchars($connexion['pseudo']) ?> </td>
                    <td class="p-2 border"> <?= htmlspecialchars($connexion['date_connexion']) ?> </td>
                </tr>
            <?php endforeach; ?>
        </table>


        <!-- Ajouter des points aux utilisateurs -->
        <h2 class="text-xl font-semibold mt-4">Gestion des points</h2>
        <form action="update_points.php" method="post">
            <select name="user_id" class="border p-2">
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user['id'] ?>"> <?= htmlspecialchars($user['pseudo']) ?> (<?= $user['points'] ?> points) </option>
                <?php endforeach; ?>
            </select>
            <input type="number" name="points" placeholder="Points" class="border p-2" required>
            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Mettre à jour</button>
        </form>

        <!-- Statistiques d'utilisation des objets -->
        <h2 class="text-xl font-semibold mt-4">Statistiques d'utilisation des objets</h2>
        <table class="w-full mt-2 border">
            <tr class="bg-gray-200">
                <th class="p-2">Objet</th>
                <th class="p-2">Nombre d'utilisations</th>
            </tr>
            <?php foreach ($stats as $stat): ?>
                <tr>
                    <td class="p-2 border"> <?= htmlspecialchars($stat['nom']) ?> </td>
                    <td class="p-2 border"> <?= htmlspecialchars($stat['total_utilisations']) ?> </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <a href="ConsultObj.php" class="bg-green-500 text-white p-2 rounded mt-4 inline-block">Retour à la consultation des objets</a>
</body>
</html>
