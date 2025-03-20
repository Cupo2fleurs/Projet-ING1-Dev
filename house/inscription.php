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
    $grade = 'Visiteur'; // Le grade est fixé à "Visiteur" et ne change pas
    $born = $_POST['born'];

    // Gestion de l'upload de la photo
    $photo = $_FILES['photo']; // On récupère le fichier photo
    $photoPath = '';
    if ($photo['error'] === UPLOAD_ERR_OK) {
        $photoPath = 'uploads/' . basename($photo['name']); // Définir le chemin du fichier
        move_uploaded_file($photo['tmp_name'], $photoPath); // Déplacer le fichier dans le dossier "uploads"
    }

    // Requête SQL pour insérer les données dans la base de données
    $sql = "INSERT INTO users (nom, prenom, mdp, pseudo, age, sexe, grade, born, photo)
            VALUES ('$nom', '$prenom', '$mdp', '$pseudo', '$age', '$sexe', '$grade', '$born', '$photoPath')";

    if ($conn->query($sql) === TRUE) {
        // Redirection vers la page redirection après l'inscription réussie
        header('Location: redirection.php'); 
        exit; // Terminer le script après la redirection
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }

    // Fermer la connexion
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    <h1>Inscription</h1>

    <form method="POST" action="inscription.php" enctype="multipart/form-data">
        <label for="nom">Nom :</label><br>
        <input type="text" id="nom" name="nom" required><br><br>

        <label for="prenom">Prénom :</label><br>
        <input type="text" id="prenom" name="prenom" required><br><br>

        <label for="mdp">Mot de passe :</label><br>
        <input type="password" id="mdp" name="mdp" required><br><br>

        <label for="pseudo">Pseudo :</label><br>
        <input type="text" id="pseudo" name="pseudo" required><br><br>

        <label for="age">Âge :</label><br>
        <input type="number" id="age" name="age" min="1" max="150" required><br><br>

        <label for="sexe">Sexe :</label><br>
        <select id="sexe" name="sexe" required>
            <option value="Homme">Homme</option>
            <option value="Femme">Femme</option>
            <option value="Autre">Autre</option>
        </select><br><br>

        <label for="grade">Grade :</label><br>
        <input type="text" id="grade" name="grade" value="Visiteur" readonly><br><br> <!-- Le grade est fixe à "Visiteur" -->

        <label for="born">Date de naissance :</label><br>
        <input type="date" id="born" name="born" required><br><br>

        <label for="photo">Photo :</label><br>
        <input type="file" id="photo" name="photo" accept="image/*" required><br><br> <!-- Champ pour télécharger une image -->

        <input type="submit" value="S'inscrire">
    </form>
</body>
</html>
