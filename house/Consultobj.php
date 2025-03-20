<!Doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation des Objets</title>
    <style>
        a {
            display: flex;
            flex-direction: column;
            text-align: right;
            color: black;
            font-size: 30px;
        }

        .objets-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .objet-card {
            border: 1px solid #ddd;
            padding: 15px;
            width: 200px;
            text-align: center;
            border-radius: 8px;
        }

        .objet-card img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }

        .objet-card h3 {
            font-size: 20px;
            margin-top: 10px;
        }

        .etat {
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>

<a href="profil.php">Modifier mon profil</a>

<?php
session_start();

try {
    $pdo_option = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    $bdd = new PDO('mysql:host=localhost;dbname=utilisateur', 'root', '', $pdo_option);
} catch (Exception $ex) {
    die("Erreur : " . $ex->getMessage());
}

if (!isset($_SESSION['user_id'])) {
    echo "<p style='color:red;'>Vous devez être connecté.</p>";
    exit();
}

// Récupérer les objets de la base de données
$sql = "SELECT * FROM objets";
$stmt = $bdd->prepare($sql);
$stmt->execute();
$objets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Liste des Objets</h2>

<div class="objets-container">
    <?php foreach ($objets as $objet): ?>
        <div class="objet-card">
            <img src="<?php echo $objet['image_url']; ?>" alt="<?php echo htmlspecialchars($objet['nom']); ?>">
            <h3><?php echo htmlspecialchars($objet['nom']); ?></h3>
            <p>Type: <?php echo htmlspecialchars($objet['type']); ?></p>
            <p class="etat">État: <?php echo htmlspecialchars($objet['etat']); ?></p>
            <p>Date d'ajout: <?php echo $objet['date_ajout']; ?></p>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
