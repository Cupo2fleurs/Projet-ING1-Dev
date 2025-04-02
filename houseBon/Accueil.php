<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Accueil</title>
    
    <!-- Importation de Vue.js -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    
    <style>
        /* Styles généraux du corps de la page */
        body {
            font-family: 'Segoe UI', sans-serif;
            background: url('uploads/maison.jpg') no-repeat center center/cover;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        /* Conteneur principal */
        .container {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 40px;
            border-radius: 16px;
            width: 90%;
            max-width: 500px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        /* Effet d'ombre et de levée au survol */
        .container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.6);
        }

        /* Style des titres */
        h1 {
            font-size: 2rem;
            color: #00bcd4;
            margin-bottom: 10px;
        }

        /* Style des paragraphes */
        p {
            color: #ddd;
            margin-bottom: 20px;
            font-size: 1.1rem;
        }

        /* Style des boutons */
        .btn {
            background-color: #00bcd4;
            color: white;
            padding: 12px 24px;
            font-size: 1rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            margin: 10px;
            transition: background-color 0.3s;
            display: inline-block;
        }

        /* Effet au survol des boutons */
        .btn:hover {
            background-color: #0097a7;
        }

        /* Style du bouton "Free Tour" */
        .free-tour {
            background-color: #4caf50;
            color: white;
            padding: 12px 30px;
            font-size: 1.1rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
            margin-top: 30px;
        }

        /* Effet au survol du bouton "Free Tour" */
        .free-tour:hover {
            background-color: #388e3c;
        }
        
        /* Animation de fondu à l'apparition */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeIn 1s ease-out forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <!-- Conteneur Vue.js -->
    <div id="app" class="container fade-in">
        <h1>{{ welcomeMessage }}</h1>
        <p>{{ description }}</p>
        <a href="Connexion.php" class="btn">{{ loginText }}</a>
        <a href="inscription.php" class="btn">{{ signupText }}</a>
    </div>

    <!-- Bouton Free Tour hors de Vue.js -->
    <a href="freetour.php" class="free-tour">FREE TOUR</a>

    <script>
        // Initialisation de l'application Vue.js
        new Vue({
            el: '#app',
            data: {
                welcomeMessage: 'Bienvenue à la Maison des Bon',
                description: 'Nous sommes ravis de vous accueillir. Pour accéder à l\'espace membre, veuillez vous inscrire.',
                loginText: 'Se connecter',
                signupText: 'S\'inscrire'
            }
        });
    </script>
</body>
</html>
