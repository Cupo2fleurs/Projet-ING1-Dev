<?php
session_start();

try {
    $bdd_users = new PDO('mysql:host=localhost;dbname=users;charset=utf8', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    $bdd_objets = new PDO('mysql:host=localhost;dbname=objets;charset=utf8', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Récupération des utilisateurs et objets
$users = $bdd_users->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
$objets = $bdd_objets->query("SELECT * FROM objets")->fetchAll(PDO::FETCH_ASSOC);

?>

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo "<p style='color:red;'>Vous devez être connecté pour modifier votre profil.</p>";
    exit();
}

// Vérifier si le formulaire a été soumis
if (isset($_POST['ok2'])) {
    $id = $_SESSION['user_id'];
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $born = htmlspecialchars($_POST['born']);
    $sexe = htmlspecialchars($_POST['sexe']);
    $age = intval($_POST['age']);
    $grade = htmlspecialchars($_POST['grade']);

        // Récupérer l'ancienne photo
    $sql = "SELECT photo FROM users WHERE id = ?";
    $requete = $bdd->prepare($sql);
    $requete->execute([$id]);
    $ancienProfil = $requete->fetch(PDO::FETCH_ASSOC);

    // Supprimer l'ancienne photo si elle existe et que ce n'est pas l'image par défaut
    if ($ancienProfil && !empty($ancienProfil['photo']) && file_exists($ancienProfil['photo']) && $ancienProfil['photo'] !== 'uploads/default.jpg') {
        unlink($ancienProfil['photo']); // Supprime l'ancienne photo, sauf si c'est l'image par défaut
    }
    

    
    // Vérifier si une photo a été uploadée
    $photo = null;
    if (!empty($_FILES['photo']['name'])) {
        $dossier = 'uploads/';
        $nom_fichier = basename($_FILES['photo']['name']);
        $chemin_fichier = $dossier . $nom_fichier;

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $chemin_fichier)) {
            $photo = $chemin_fichier;
        } else {
            echo "<p style='color:red;'>Erreur lors de l'upload de l'image.</p>";
            exit();
        }
    }

    

    // Construire la requête SQL dynamiquement
    $sql = "UPDATE users SET pseudo = ?, age = ?, sexe = ?, born = ?, grade = ?";
    $params = [$pseudo, $age, $sexe, $born, $grade];

    if ($photo) {
        $sql .= ", photo = ?";
        $params[] = $photo;
    }

    $sql .= " WHERE id = ?";
    $params[] = $id;

    // Exécuter la mise à jour
    $requete = $bdd->prepare($sql);
    if ($requete->execute($params)) {
        echo '<script>location.href="Consultobj.php";</script>';
    } else {
        echo "<p style='color:red;'>Erreur lors de la mise à jour.</p>";
    }
} else {
    echo "<p style='color:red;'>Tous les champs sont obligatoires !</p>";
}
?>
