<?php
session_start();

try {
    $pdo_option = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    $bdd = new PDO('mysql:host=localhost;dbname=utilisateur', 'root', '', $pdo_option);
} catch (Exception $ex) {
    die("Erreur : " . $ex->getMessage());
}

    if(isset($_POST['pseudo'], $_POST['born'], $_POST['sexe'], $_POST['age'], $_POST['grade']) && isset($_FILES['photo'])){
        // Protection contre les failles XSS
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $born = htmlspecialchars($_POST['born']);
        $sexe = htmlspecialchars($_POST['sexe']);
        $age = intval($_POST['age']);
        $grade = htmlspecialchars($_POST['grade']);
        
        $dossier = 'uploads/';
        $nom_fichier = basename($_FILES['photo']['name']);
        $chemin_fichier = $dossier . $nom_fichier;
    
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $chemin_fichier)) {
            $photo = $chemin_fichier;
        } else {
            echo "<p style='color:red;'>Erreur lors de l'upload de l'image.</p>";
            exit();
        }

        // Requête préparée pour éviter les injections SQL
        $requete = $bdd->prepare("INSERT INTO profil (id, pseudo, age, sexe, born, grade, photo) VALUES (0, :pseudo, :age, :sexe, :born, :grade, :photo)");

        if($requete->execute([
            "pseudo" => $pseudo,
            "born" => $born,
            "sexe" => $sexe,
            "age" => $age,
            "grade" => $grade,
            "photo" => $photo
        ])){
            echo "<p style='color:green;'>Inscription réussie !</p>";
        } else {
            echo "<p style='color:red;'>Erreur lors de l'inscription.</p>";
        }
    } else {
        echo "<p style='color:red;'>Tous les champs sont obligatoires !</p>";
    }
?>
