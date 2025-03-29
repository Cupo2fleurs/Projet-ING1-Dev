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

// Vérification des points
$sql = "SELECT points FROM users WHERE id = :user_id";
$stmt = $bdd->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$points = $user['points'] ?? 0;

if ($points < 8) {
    echo "<p style='color:red;'>Vous n'avez pas assez de points pour modifier ou supprimer des utilisateurs.</p>";
    exit();
}

// Suppression d'un utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $sql = "DELETE FROM users WHERE id = :id";
    $stmt = $bdd->prepare($sql);
    $stmt->execute(['id' => $delete_id]);
    header("Location: liste_profil.php");
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
    header("Location: liste_profil.php");
    exit();
}

// Récupération de l'utilisateur à modifier
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
</head>
<body>

<a href="liste_profil.php" class="bg-gray-500 text-white px-4 py-2 rounded">⬅ Retour</a>

<h1>Modifier un utilisateur</h1>

<?php if ($edit_user): ?>
    <form method="post">
        <input type="hidden" name="edit_id" value="<?php echo $edit_user['id']; ?>">
        <label>Pseudo:</label>
        <input type="text" name="pseudo" value="<?php echo $edit_user['pseudo']; ?>">
        <label>Âge:</label>
        <input type="number" name="age" value="<?php echo $edit_user['age']; ?>">
        <label>Sexe:</label>
        <input type="text" name="sexe" value="<?php echo $edit_user['sexe']; ?>">
        <label>Grade:</label>
        <input type="text" name="grade" value="<?php echo $edit_user['grade']; ?>">
        <button type="submit">Modifier</button>
    </form>
<?php endif; ?>

</body>
</html>
