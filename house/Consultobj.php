<?php
session_start();

try {
    $pdo_option = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    $bdd = new PDO('mysql:host=localhost;dbname=utilisateur', 'root', '', $pdo_option);
} catch (Exception $ex) {
    die("Erreur : " . $ex->getMessage());
}

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo "<p style='color:red;'>Vous devez être connecté.</p>";
    exit();
}

// Récupérer tous les objets de la maison
$query = $bdd->query("SELECT * FROM objets");
$objets = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Maison Connectée</title>
    <style>
        a {
            display: flex;
            flex-direction: column;
            text-align: right;
            color: black;
            font-size: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
        button {
            padding: 5px 10px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<a href="profil.php">Modifier mon profil</a>

<h1>Contrôle des objets de la maison</h1>

<table>
    <tr>
        <th>Objet</th>
        <th>Type</th>
        <th>État</th>
        <th>Paramètres</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($objets as $objet): ?>
    <tr>
        <td><?= htmlspecialchars($objet['nom']) ?></td>
        <td><?= htmlspecialchars($objet['type']) ?></td>
        <td><?= htmlspecialchars($objet['etat']) ?></td>
        <td>
            <?php
            $id = $objet['id'];

            if ($objet['type'] === 'chauffage') {
                $query = $bdd->prepare("SELECT temperature FROM chauffage WHERE id = ?");
                $query->execute([$id]);
                $data = $query->fetch();
                echo "Température: " . $data['temperature'] . "°C";
            } elseif ($objet['type'] === 'machine_laver') {
                $query = $bdd->prepare("SELECT programme, essorage, duree FROM machine_laver WHERE id = ?");
                $query->execute([$id]);
                $data = $query->fetch();
                echo "Mode: " . $data['programme'] . " | Essorage: " . $data['essorage'] . " t/min | Durée: " . $data['duree'] . " min";
            } elseif ($objet['type'] === 'four') {
                $query = $bdd->prepare("SELECT temperature, duree, mode FROM four WHERE id = ?");
                $query->execute([$id]);
                $data = $query->fetch();
                echo "Temp: " . $data['temperature'] . "°C | Mode: " . $data['mode'] . " | Durée: " . $data['duree'] . " min";
            } elseif ($objet['type'] === 'rideaux') {
                echo "Position: " . htmlspecialchars($objet['etat']);
            } elseif ($objet['type'] === 'television') {
                $query = $bdd->prepare("SELECT chaine, volume FROM television WHERE id = ?");
                $query->execute([$id]);
                $data = $query->fetch();
                echo "Chaîne: " . htmlspecialchars($data['chaine']) . " | Volume: " . $data['volume'];
            } elseif ($objet['type'] === 'lave_vaisselle') {
                $query = $bdd->prepare("SELECT programme, duree FROM lave_vaisselle WHERE id = ?");
                $query->execute([$id]);
                $data = $query->fetch();
                echo "Programme: " . htmlspecialchars($data['programme']) . " | Durée: " . $data['duree'] . " min";
            }
            ?>
        </td>
        <td>
            <form action="actions.php" method="POST">
                <input type="hidden" name="id" value="<?= $objet['id'] ?>">
                <button type="submit" name="toggle"><?= $objet['etat'] === 'éteint' ? 'Allumer' : 'Éteindre' ?></button>
                
                <?php if ($objet['type'] === 'rideaux'): ?>
                    <button type="submit" name="toggle_position"><?= $objet['etat'] === 'fermé' ? 'Ouvrir' : 'Fermer' ?></button>
                <?php endif; ?>

                <?php if ($objet['type'] === 'television'): ?>
                    <input type="text" name="chaine" placeholder="Changer de chaîne">
                    <button type="submit" name="change_chaine">OK</button>
                    <input type="number" name="volume" min="0" max="100" value="30">
                    <button type="submit" name="change_volume">OK</button>
                <?php endif; ?>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
