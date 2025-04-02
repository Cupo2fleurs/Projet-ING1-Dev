<?php
session_start();

// Connexion à la base de données
try {
    $pdo_option = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    $bdd = new PDO('mysql:host=localhost;dbname=utilisateur', 'root', '', $pdo_option);
} catch (Exception $ex) {
    die("Erreur : " . $ex->getMessage()); // En cas d'erreur de connexion, on affiche un message et on arrête le script
}

// Vérification de la connexion de l'utilisateur
if (!isset($_SESSION['user_id'])) {
    echo "<p style='color:red;'>Vous devez être connecté.</p>";
    exit(); // Arrête l'exécution du script si l'utilisateur n'est pas connecté
}

$user_id = $_SESSION['user_id'];

// Vérification des points de l'utilisateur
$sql = "SELECT points FROM users WHERE id = :user_id";
$stmt = $bdd->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$points = $user['points'] ?? 0;

if ($points < 8) {
    echo "<p style='color:red;'>Vous n'avez pas assez de points pour modifier ou supprimer des utilisateurs.</p>";
    exit(); // Arrête l'exécution du script si l'utilisateur n'a pas assez de points
}

// Suppression d'un utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $sql = "DELETE FROM users WHERE id = :id";
    $stmt = $bdd->prepare($sql);
    $stmt->execute(['id' => $delete_id]);
    header("Location: liste_profil.php"); // Redirige après suppression
    exit();
}

// Modification d'un utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {
    $edit_id = $_POST['edit_id'];
    $pseudo = $_POST['pseudo'];
    $age = $_POST['age'];
    $sexe = $_POST['sexe'];
    $grade = $_POST['grade'];

    $sql = "UPDATE users SET pseudo = :pseudo, age = :age, sexe = :sexe, grade = :grade WHERE id = :id";
    $stmt = $bdd->prepare($sql);
    $stmt->execute([
        'pseudo' => $pseudo,
        'age' => $age,
        'sexe' => $sexe,
        'grade' => $grade,
        'id' => $edit_id
    ]);
    header("Location: liste_profil.php"); // Redirige après modification
    exit();
}

// Récupération des informations d'un utilisateur à modifier
$edit_user = null;
if (isset($_GET['edit_id'])) {
    $sql = "SELECT * FROM users WHERE id = :id";
    $stmt = $bdd->prepare($sql);
    $stmt->execute(['id' => $_GET['edit_id']]);
    $edit_user = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin Utilisateurs</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #1e1e1e;
            color: #f0f0f0;
            margin: 0;
            padding: 2rem;
        }
        a {
            color: #00bcd4;
            font-weight: bold;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        h1 {
            text-align: center;
            color: #00bcd4;
            margin-bottom: 2rem;
        }
        form {
            max-width: 400px;
            margin: auto;
            background-color: #2a2a2a;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
        }
        label {
            display: block;
            margin: 1rem 0 0.25rem;
        }
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 0.5rem;
            border: none;
            border-radius: 8px;
            margin-bottom: 1rem;
            background-color: #444;
            color: #fff;
        }
        button {
            background-color: #4caf50;
            color: white;
            padding: 0.75rem;
            border: none;
            border-radius: 8px;
            width: 100%;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #388e3c;
        }
        p {
            color: red;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>
<a href="liste_profil.php">&#8592; Retour</a>
<h1>Modifier un utilisateur</h1>
<?php if ($edit_user): ?>
    <form method="post">
        <input type="hidden" name="edit_id" value="<?= $edit_user['id']; ?>">
        <label>Pseudo:</label>
        <input type="text" name="pseudo" value="<?= $edit_user['pseudo']; ?>">
        <label>Âge:</label>
        <input type="number" name="age" value="<?= $edit_user['age']; ?>">
        <label>Sexe:</label>
        <input type="text" name="sexe" value="<?= $edit_user['sexe']; ?>">
        <label>Grade:</label>
        <input type="text" name="grade" value="<?= $edit_user['grade']; ?>">
        <button type="submit">Modifier</button>
    </form>
<?php endif; ?>
</body>
</html>
