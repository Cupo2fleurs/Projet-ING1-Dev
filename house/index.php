<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Accueil</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('uploads/maison.jpg') no-repeat center center/cover;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            padding: 40px;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            margin-top: 15vh;
        }

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

        .free-tour {
            background-color: #28a745;
            color: white;
            padding: 12px 25px;
            font-size: 1.2rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
            margin-top: 20px;
        }

        .free-tour:hover {
            background-color: #218838;
            
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
        </div>
    </div>
    
    <a href="freetour.php" class="free-tour">FREE TOUR</a>

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
                    this.showMessage = false;  // <---------- Corriger le timer inutile 
                }, 5000);
            }
        });
    </script>

</body>
</html>
