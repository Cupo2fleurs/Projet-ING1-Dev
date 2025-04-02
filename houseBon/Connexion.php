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
            background-color: #1e1e1e;
            color: #f0f0f0;
            margin: 0;
            padding: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #2a2a2a;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.4);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin: 1rem 0 0.5rem;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 0.75rem;
            border: none;
            border-radius: 8px;
            background-color: #3a3a3a;
            color: white;
            font-size: 1rem;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 1.5rem;
        }

        input[type="submit"]:hover {
            background-color: #388e3c;
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
