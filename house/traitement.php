<?php
session_start();

try {
    $pdo_option = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    $bdd = new PDO('mysql:host=localhost;dbname=utilisateur', 'root', '', $pdo_option);
} catch (Exception $ex) {
    die("Erreur : " . $ex->getMessage());
}

if (!isset($_SESSION['user_id'])) {
    echo "<p style='color:red;'>Vous devez être connecté pour modifier votre profil.</p>";
    exit();
}

// Récupérer l'id de l'utilisateur connecté
$id = $_SESSION['user_id'];

// Vérification si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $pseudo = $_POST['pseudo'];
    $age = $_POST['age'];
    $sexe = $_POST['sexe'];
    $born = $_POST['born'];
    $grade = $_POST['grade'];

    // Gérer l'upload de la photo
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $photo_path = 'uploads/' . $_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path);
    } else {
        $photo_path = null;
    }

    // Mise à jour des informations de l'utilisateur
    $requete = $bdd->prepare("UPDATE users SET pseudo = ?, age = ?, sexe = ?, born = ?, grade = ?, photo = ? WHERE id = ?");
    $requete->execute([$pseudo, $age, $sexe, $born, $grade, $photo_path, $id]);

    // Ajouter 1 point à l'utilisateur pour avoir modifié son profil
    $stmt = $bdd->prepare("SELECT points FROM users WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $new_points = $user['points'] + 1;

    // Mise à jour des points dans la base de données
    $stmt = $bdd->prepare("UPDATE users SET points = :points WHERE id = :id");
    $stmt->execute(['points' => $new_points, 'id' => $id]);

    // Redirection vers la page de consultation des objets après modification
    header("Location: ConsultObj.php");
    exit();
}
?>
