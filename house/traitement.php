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
    if(isset($_POST['ok2'])){
        // Protection contre les failles XSS
        $id = $_SESSION['user_id'];
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $born = htmlspecialchars($_POST['born']);
        $sexe = htmlspecialchars($_POST['sexe']);
        $age = intval($_POST['age']);
        $grade = htmlspecialchars($_POST['grade']);

        $photo = $user['photo'] ?? 'default.jpg';    // A modifier pas sur que ça marche
        $dossier = 'uploads/';
        $nom_fichier = basename($_FILES['photo']['name']);
        $chemin_fichier = $dossier . $nom_fichier;
    
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $chemin_fichier)) {
            $photo = $chemin_fichier;
        
            // Mise à jour de la base de données avec le chemin de l'image
            $stmt = $bdd->prepare("UPDATE users SET photo = :photo WHERE id = :id");
            $stmt->bindParam(':photo', $photo);
            $stmt->bindParam(':id', $_SESSION['user_id']);
            $stmt->execute();

        // Requête préparée pour éviter les injections SQL
        $requete = $bdd->prepare("UPDATE users SET pseudo = ?, age = ?, sexe = ?, born = ?, grade = ?, photo = ? WHERE id = ?");
    
        if ($requete->execute([$pseudo, $age, $sexe, $born, $grade, $photo, $id])) {
            echo '<script>location.href="Consultobj.php";</script>';
        }
            exit();
        } else {
            echo "<p style='color:red;'>Erreur lors de la mise à jour.</p>";
        }
    } else {
        echo "<p style='color:red;'>Tous les champs sont obligatoires !</p>";
    }
?>
