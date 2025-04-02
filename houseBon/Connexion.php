<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Se connecter</title>
  <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #121212;
      margin: 0;
      padding: 0;
      color: #f0f0f0;
    }
    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background: radial-gradient(circle at top left, #1f1f1f, #121212);
    }
    #inscri {
      background-color: #1e1e1e;
      padding: 2rem;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
      width: 100%;
      max-width: 400px;
    }
    #inscri h2 {
      text-align: center;
      margin-bottom: 1.5rem;
      font-size: 1.8rem;
      color: #00bcd4;
    }
    label {
      display: block;
      font-size: 1rem;
      color: #ccc;
      margin-top: 1rem;
    }
    #inscri input[type="text"],
    #inscri input[type="password"] {
      width: 100%;
      padding: 0.75rem;
      margin-top: 0.5rem;
      background-color: #333;
      color: #fff;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
    }
    #inscri input[type="submit"] {
      background-color: #00bcd4;
      color: white;
      border: none;
      padding: 0.75rem;
      margin-top: 1.5rem;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
      font-size: 1rem;
      transition: background-color 0.3s ease;
      width: 100%;
    }
    #inscri input[type="submit"]:hover {
      background-color: #0097a7;
    }
    .footer {
      position: absolute;
      bottom: 15px;
      text-align: center;
      width: 100%;
      font-size: 0.9rem;
      color: #aaa;
    }
  </style>
</head>
<body>
  <a href="Accueil.php" style="position: absolute; top: 20px; left: 20px; color: #00bcd4; text-decoration: none; font-weight: bold;">&#8592; Accueil</a>
    <div id="app" class="container">
    <form id="inscri" method="POST" action="VerifConnexion.php">
      <h2>Se connecter</h2>
      <label for="nom">Votre Nom</label>
      <input type="text" id="nom" name="nom" required v-model="nom">

      <label for="prenom">Votre Prénom</label>
      <input type="text" id="prenom" name="prenom" required v-model="prenom">

      <label for="mdp">Mot de passe</label>
      <input type="password" id="mdp" name="mdp" required v-model="mdp">

      <input type="submit" value="Valider" name="ok">
    </form>
  </div>

  <div class="footer">
    <p>&copy; 2025 Bon-Home - Tous droits réservés</p>
  </div>

  <script>
    new Vue({
      el: '#app',
      data: {
        nom: '',
        prenom: '',
        mdp: ''
      }
    });
  </script>
</body>
</html>
