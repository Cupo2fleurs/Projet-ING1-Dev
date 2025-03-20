<!Doctype html>
<html lang="en">
<head>
    <title> profil </title>
</head>
<body>
    <style>
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
    }
    .gpsexe {
    display: flex;
    align-items: center;
    gap: 10px; /* Espacement entre les éléments */
  }
        
    </style>
<h1>Mon Profil</h1>
<form id="profilForm" method="POST" action="traitement.php" enctype="multipart/form-data">
    <div class="rest">
        <label>Pseudonyme</label>
        <input type="text" id="pseudo" name="pseudo" required>
        <br />
        <label>Age</label>
        <input type="number" id="age" name="age" required>
        <br />
    </div>

    <div class="gpsexe">
        <label>Sexe :</label>
        <input type="radio" id="homme" name="sexe" value="Homme">
        <label for="homme">Homme</label>
        <input type="radio" id="femme" name="sexe" value="Femme">
        <label for="femme">Femme</label>
        <input type="radio" id="autre" name="sexe" value="Autre">
        <label for="autre">Autre</label>
    </div>

    <div class="rest">
        <br />
        <label>Date de naissance</label>
        <input type="date" id="date" name="born" required>
        <br />
        <label>Grade</label>
        <select id="grade" name="grade">
            <option value="Père">Père</option>
            <option value="Mère">Mère</option>
            <option value="Enfant">Enfant</option>
            <option value="GP">Grand-Parents</option>
            <option value="Visit">Visiteur</option>
        </select>
        <br />
        <label>Photo</label>
        <input type="file" id="photo" name="photo" accept="image/*">
        <br />
        <br>
        <input type="submit" value="Valider" name="ok2">
    </div>
</form>

<!-- Zone pour afficher le message -->
<div id="result"></div>
</body>
</html>

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
// Récupérer les infos de l'utilisateur connecté
$id = $_SESSION['user_id'];
$requete = $bdd->prepare("SELECT * FROM users WHERE id = ?");
$requete->execute([$id]);
$user = $requete->fetch();

?>
