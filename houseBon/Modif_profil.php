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

$id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $born = htmlspecialchars($_POST['born']);
    $sexe = htmlspecialchars($_POST['sexe']);
    $age = intval($_POST['age']);
    $grade = htmlspecialchars($_POST['grade']);
    
    // Récupérer l'ancienne photo
    $sql = "SELECT photo, points FROM users WHERE id = ?";
    $requete = $bdd->prepare($sql);
    $requete->execute([$id]);
    $ancienProfil = $requete->fetch(PDO::FETCH_ASSOC);

    // Par défaut, garder l'ancienne photo
    $photo = $ancienProfil['photo'];

    // Vérifier si une nouvelle photo est uploadée
    if (!empty($_FILES['photo']['name'])) {
        $dossier = 'uploads/';
        $nom_fichier = basename($_FILES['photo']['name']);
        $chemin_fichier = $dossier . $nom_fichier;

        // Si l'upload réussit, remplacer l'ancienne photo
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $chemin_fichier)) {
            // Supprimer l'ancienne photo si ce n'est pas l'image par défaut
            if (!empty($ancienProfil['photo']) && file_exists($ancienProfil['photo']) && $ancienProfil['photo'] !== 'uploads/default.jpg') {
                unlink($ancienProfil['photo']);
            }
            $photo = $chemin_fichier; // Mettre à jour la variable photo
        } else {
            echo "<p style='color:red;'>Erreur lors de l'upload de l'image.</p>";
            exit();
        }
    }

    // Construire la requête SQL
    $sql = "UPDATE users SET pseudo = ?, age = ?, sexe = ?, born = ?, grade = ?";
    $params = [$pseudo, $age, $sexe, $born, $grade];

    // Ajouter la mise à jour de la photo seulement si elle a changé
    if (!empty($_FILES['photo']['name'])) {
        $sql .= ", photo = ?";
        $params[] = $photo;
    }

    $sql .= " WHERE id = ?";
    $params[] = $id;

    // Exécuter la mise à jour
    $requete = $bdd->prepare($sql);
    $requete->execute($params);
    
    // Ajouter 1 point à l'utilisateur pour avoir modifié son profil
    $new_points = $ancienProfil['points'] + 1;
    $stmt = $bdd->prepare("UPDATE users SET points = ? WHERE id = ?");
    $stmt->execute([$new_points, $id]);
    
    echo '<script>location.href="ConsultObj.php";</script>';
    exit();
} else {
    echo "<p style='color:red;'>Tous les champs sont obligatoires !</p>";
}
?>
