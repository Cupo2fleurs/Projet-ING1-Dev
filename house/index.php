<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Accueil</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
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
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .content:hover {
            transform: translateY(-10px);
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
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
            margin: 10px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .message {
            margin-top: 20px;
            font-size: 1.2rem;
            color: #333;
        }
    </style>
</head>
<body>

    <div id="app" class="container">
        <div class="content">
            <h1>{{ welcomeMessage }}</h1>
            <p>{{ description }}</p>
            <a href="login.php" class="btn">{{ loginText }}</a>
            <a href="inscription.php" class="btn">{{ signupText }}</a>

            <div class="message" v-if="showMessage">
                <p>Nous sommes heureux de vous avoir parmi nous!</p>
            </div>
        </div>
    </div>

    <script>
        new Vue({
            el: '#app',
            data: {
                welcomeMessage: 'Bienvenue à la Maison des Bon',
                description: 'Nous sommes ravis de vous accueillir. Pour accéder à l\'espace membre, veuillez vous inscrire.',
                loginText: 'Se connecter',
                signupText: 'S\'inscrire',
                showMessage: false
            },
            mounted() {
                this.showMessage = true;
                setTimeout(() => {
                    this.showMessage = false;
                }, 5000); // Message disparaît après 5 secondes
            }
        });
    </script>

</body>
</html>
