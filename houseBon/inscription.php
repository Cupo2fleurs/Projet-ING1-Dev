<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root"; // Ton nom d'utilisateur MySQL
$password = ""; // Ton mot de passe MySQL
$dbname = "utilisateur"; // Le nom de ta base de données

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $mdp = $_POST['mdp'];
    $pseudo = $_POST['pseudo'];
    $age = $_POST['age'];
    $sexe = $_POST['sexe'];
    $grade = 'Visiteur'; // Le grade est fixé à "Visiteur"
    $born = $_POST['born'];

    // Gestion de l'upload de la photo
    $photoPath = 'uploads/default.jpg'; // Par défaut, on met l'image par défaut
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $dossier = 'uploads/';
        $nom_fichier = basename($_FILES['photo']['name']);
        $chemin_fichier = $dossier . $nom_fichier;

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $chemin_fichier)) {
            $photoPath = $chemin_fichier; // Mettre à jour le chemin de la photo
        }
    }

    // Requête SQL pour insérer les données dans la base de données
    $sql = "INSERT INTO users (nom, prenom, mdp, pseudo, age, sexe, grade, born, photo, points)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssissss", $nom, $prenom, $mdp, $pseudo, $age, $sexe, $grade, $born, $photoPath);

    if ($stmt->execute()) {
        // Redirection après l'inscription réussie
        header('Location: redirection.php'); 
        exit;
    } else {
        echo "Erreur: " . $stmt->error;
    }

    // Fermer la connexion
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<style>
    body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }
     #profilForm{
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    }

    .rest input{
        width: 100%;
        max-width: 300px; 
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .rest label{
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;

    }

    h1 {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        font-size:35px;
    }
    .gpsexe {
    display: flex;
    align-items: center;
    gap: 10px; /* Espacement entre les éléments */
  }
</style>
    <a href="Accueil.php" class="text-2xl font-bold text-blue-500 mb-4  hover:underline">&#8592; Retour</a>
    <h1>Inscription</h1>

    <form id="profilForm" method="POST" action="inscription.php" enctype="multipart/form-data">
    <div class="rest">
        <label for="nom">Nom :</label><br>
        <input type="text" id="nom" name="nom" required><br><br>

        <label for="prenom">Prénom :</label><br>
        <input type="text" id="prenom" name="prenom" required><br><br>

        <label for="mdp">Mot de passe :</label><br>
        <input type="password" id="mdp" name="mdp" required><br><br>

        <label for="pseudo">Pseudo :</label><br>
        <input type="text" id="pseudo" name="pseudo"><br><br>

        <label for="age">Âge :</label><br>
        <input type="number" id="age" name="age" min="1" max="150"><br><br>
        </div>
        <div class="gpsexe">
        <label for="sexe">Sexe :</label><br>
        <select id="sexe" name="sexe" required>
            <option value="Homme">Homme</option>
            <option value="Femme">Femme</option>
            <option value="Autre">Autre</option>
        </select><br><br>
</div>
<div class="rest">
        <label for="grade">Grade :</label><br>
        <input type="text" id="grade" name="grade" value="Visiteur" readonly><br><br> <!-- Le grade est fixe à "Visiteur" -->

        <label for="born">Date de naissance :</label><br>
        <input type="date" id="born" name="born"><br><br>

        <label for="photo">Photo :</label><br>
        <input type="file" id="photo" name="photo" accept="image/*"><br><br> <!-- Champ pour télécharger une image -->

        <input type="submit" value="S'inscrire">
</div>
    </form>
</body>
</html>
