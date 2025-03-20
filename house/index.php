<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Accueil</title>
    <style>
        /* Styles globaux pour la page d'accueil */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }

        /* Conteneur principal pour centrer le contenu */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #e1e8ed;
        }

        /* Style du contenu principal (accueil) */
        .content {
            text-align: center;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        .content h1 {
            font-size: 2rem;
            color: #333;
        }

        .btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            font-size: 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <h1>Bienvenue à la Maison des Bon</h1>
            <p>Nous sommes ravis de vous accueillir. Pour accéder à l'espace membre, veuillez vous inscrire.</p>
            <a href="login.php" class="btn">Se connecter</a> <!-- Bouton qui redirige vers la page de connexion -->
        </div>
    </div>
</body>
</html>
