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

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Profil</title>
  <script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.js"></script>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #1e1e1e;
      color: #f0f0f0;
      margin: 0;
      padding: 2rem;
    }
    h1 {
      text-align: center;
      color: #00bcd4;
      margin-bottom: 2rem;
    }
    a {
      display: block;
      color: #00bcd4;
      text-decoration: none;
      font-weight: bold;
      margin-bottom: 2rem;
    }
    a:hover {
      text-decoration: underline;
    }
    form {
      max-width: 600px;
      margin: auto;
      background-color: #2a2a2a;
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
    input[type="file"],
    select {
      width: 100%;
      padding: 0.75rem;
      margin-bottom: 1rem;
      border: none;
      border-radius: 8px;
      background-color: #444;
      color: white;
    }
    .gpsexe {
      display: flex;
      justify-content: space-between;
      gap: 10px;
      margin-bottom: 1.5rem;
    }
    .gpsexe label {
      margin: 0;
      font-weight: normal;
    }
    .gpsexe input[type="radio"] {
      margin-right: 5px;
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
    #result {
      margin-top: 2rem;
      text-align: center;
    }
  </style>
</head>
<body>
  <a href="Consultobj.php">&#8592; Retour</a>
  <h1>Mon Profil</h1>
  <form id="profilForm" method="POST" action="Modif_profil.php" enctype="multipart/form-data">
    <label for="pseudo">Pseudonyme</label>
    <input type="text" id="pseudo" name="pseudo" required>

    <label for="age">Age</label>
    <input type="number" id="age" name="age" required>

    <div class="gpsexe">
      <label><input type="radio" id="homme" name="sexe" value="Homme"> Homme</label>
      <label><input type="radio" id="femme" name="sexe" value="Femme"> Femme</label>
      <label><input type="radio" id="autre" name="sexe" value="Autre"> Autre</label>
    </div>

    <label for="date">Date de naissance</label>
    <input type="date" id="date" name="born" required>

    <label for="grade">Grade</label>
    <select id="grade" name="grade">
      <option value="Père">Père</option>
      <option value="Mère">Mère</option>
      <option value="Enfant">Enfant</option>
      <option value="GP">Grand-Parents</option>
      <option value="Visit">Visiteur</option>
    </select>

    <label for="photo">Photo</label>
    <input type="file" id="photo" name="photo" accept="image/*">

    <input type="submit" value="Valider (+1pt)" name="ok2">
  </form>
  <div id="result"></div>
</body>
</html>

