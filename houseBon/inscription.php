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
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #121212;
      margin: 0;
      padding: 2rem;
      color: #f0f0f0;
    }
    a {
      color: #00bcd4;
      text-decoration: none;
      font-weight: bold;
    }
    a:hover {
      text-decoration: underline;
    }
    h1 {
      text-align: center;
      margin-bottom: 2rem;
      color: #00bcd4;
    }
    form {
      max-width: 600px;
      margin: auto;
      background-color: #1e1e1e;
      padding: 2rem;
      border-radius: 16px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
    }
    label {
      display: block;
      margin: 1rem 0 0.25rem;
    }
    input[type="text"],
    input[type="number"],
    input[type="date"],
    input[type="password"],
    input[type="file"],
    select {
      width: 100%;
      padding: 0.75rem;
      margin-bottom: 1rem;
      border: none;
      border-radius: 8px;
      background-color: #333;
      color: white;
    }
    input[type="submit"] {
      background-color: #4caf50;
      color: white;
      padding: 0.75rem;
      border: none;
      border-radius: 8px;
      width: 100%;
      cursor: pointer;
      font-weight: bold;
      transition: background-color 0.3s;
    }
    input[type="submit"]:hover {
      background-color: #388e3c;
    }
    .gpsexe {
      display: flex;
      justify-content: space-between;
      gap: 10px;
    }
    .gpsexe select {
      flex: 1;
    }
  </style>
</head>
<body>
  <a href="Accueil.php">&#8592; Retour</a>
  <h1>Inscription</h1>
  <form id="profilForm" method="POST" action="inscription.php" enctype="multipart/form-data">
    <label for="nom">Nom :</label>
    <input type="text" id="nom" name="nom" required>

    <label for="prenom">Prénom :</label>
    <input type="text" id="prenom" name="prenom" required>

    <label for="mdp">Mot de passe :</label>
    <input type="password" id="mdp" name="mdp" required>

    <label for="pseudo">Pseudo :</label>
    <input type="text" id="pseudo" name="pseudo">

    <label for="age">Âge :</label>
    <input type="number" id="age" name="age" min="1" max="150">

    <label for="sexe">Sexe :</label>
    <select id="sexe" name="sexe" required>
      <option value="Homme">Homme</option>
      <option value="Femme">Femme</option>
      <option value="Autre">Autre</option>
    </select>

    <label for="grade">Grade :</label>
    <input type="text" id="grade" name="grade" value="Visiteur" readonly>

    <label for="born">Date de naissance :</label>
    <input type="date" id="born" name="born">

    <label for="photo">Photo :</label>
    <input type="file" id="photo" name="photo" accept="image/*">

    <input type="submit" value="S'inscrire">
  </form>
</body>
</html>
