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
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #1e1e1e;
            color: #f0f0f0;
            margin: 0;
            padding: 2rem;
        }
        .container {
            background-color: #2a2a2a;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
            max-width: 1000px;
            margin: auto;
        }
        h1, h2 {
            color: #00bcd4;
            margin-bottom: 1rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        th, td {
            padding: 0.75rem;
            border: 1px solid #444;
            text-align: left;
        }
        th {
            background-color: #3a3a3a;
            color: #ffffff;
        }
        tr:nth-child(even) {
            background-color: #1e1e1e;
        }
        tr:hover {
            background-color: #333;
        }
        select, input[type="number"] {
            padding: 0.5rem;
            border-radius: 8px;
            border: none;
            margin-right: 1rem;
        }
        button {
            background-color: #00bcd4;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0097a7;
        }
        .btn-return {
            display: inline-block;
            margin-top: 2rem;
            background-color: #4caf50;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .btn-return:hover {
            background-color: #388e3c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tableau de bord Admin</h1>

        <h2>Historique des connexions</h2>
        <table>
            <tr>
                <th>Pseudo</th>
                <th>Date de connexion</th>
            </tr>
            <?php foreach ($connexions as $connexion): ?>
                <tr>
                    <td><?= htmlspecialchars($connexion['pseudo']) ?></td>
                    <td><?= htmlspecialchars($connexion['date_connexion']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h2>Gestion des points</h2>
        <form action="update_points.php" method="post">
            <select name="user_id">
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user['id'] ?>"> <?= htmlspecialchars($user['pseudo']) ?> (<?= $user['points'] ?> pts)</option>
                <?php endforeach; ?>
            </select>
            <input type="number" name="points" placeholder="Points" required>
            <button type="submit">Mettre à jour</button>
        </form>

        <h2>Statistiques d'utilisation des objets</h2>
        <table>
            <tr>
                <th>Objet</th>
                <th>Nombre d'utilisations</th>
            </tr>
            <?php foreach ($stats as $stat): ?>
                <tr>
                    <td><?= htmlspecialchars($stat['nom']) ?></td>
                    <td><?= htmlspecialchars($stat['total_utilisations']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <a href="ConsultObj.php" class="btn-return">Retour à la consultation des objets</a>
    </div>
</body>
</html>
