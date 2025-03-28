<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se connecter</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <style>
        /* Styles globaux pour la page */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }

        /* Conteneur principal pour centrer le formulaire */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #e1e8ed;
        }

        /* Style du formulaire */
        #inscri {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        #inscri h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.5rem;
            color: #333;
        }

        label {
            font-size: 1rem;
            color: #555;
            margin-bottom: 5px;
        }

        #inscri input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 1rem;
        }

        #inscri input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #inscri input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .footer {
            position: absolute;
            bottom: 20px;
            text-align: center;
            width: 100%;
            font-size: 0.9rem;
            color: #888;
        }
    </style>
</head>
<body>
    <div id="app" class="container">
        <form id="inscri" method="POST" action="verif.php">
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
