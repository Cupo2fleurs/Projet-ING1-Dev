<?php
session_start();
$isConnected = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Free Tour</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #1e1e1e;
            color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #121212;
            padding: 20px;
            text-align: center;
        }
        header h2 {
            font-size: 1.8rem;
            color: #00bcd4;
            margin: 0;
        }
        .nav-link {
            display: block;
            text-align: center;
            margin: 10px;
        }
        .nav-link a {
            color: #4caf50;
            font-weight: bold;
            text-decoration: none;
        }
        .nav-link a:hover {
            text-decoration: underline;
        }
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 50px;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }
        .slideshow-container {
            flex: 1 1 45%;
            background: #2a2a2a;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            text-align: center;
        }
        .slideshow-container img {
            max-width: 100%;
            border-radius: 8px;
        }
        .caption {
            margin-top: 10px;
            color: #ccc;
            font-size: 1.1rem;
        }
        .text-content {
            flex: 1 1 45%;
            font-size: 1.1rem;
            line-height: 1.6;
            color: #ddd;
        }
        @media (max-width: 768px) {
            .row {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <header>
        <h2>Chez les Bon, qu'est-ce qui se passe ?</h2>
        <div class="nav-link">
        <?php if ($isConnected): ?>
            <a href="Consultobj.php" class="text-xl font-bold text-blue-500 hover:underline">Retour aux objets</a>
        <?php else: ?>
            <a href="Accueil.php" class="text-xl font-bold text-blue-500 hover:underline">Retour page d'accueil</a>
        <?php endif; ?>
        </div>
    </header>

    <div id="app" class="container">
        <div class="row">
            <div class="slideshow-container">
                <img :src="images[currentIndex]" alt="Diaporama">
                <p class="caption">{{ captions[currentIndex] }}</p>
            </div>
            <div class="text-content">
            <p>Voici une petite présentation de notre site internet qui permet d'utiliser de façon simple et automatique les différents appareils de la maison.
                    <br>Avec un système de création et de modification de profil pour avoir la classe dans la maison.
                    <br>Un système de niveaux qui donne accès à tout un panel de fonctionnalités supplémentaires allant de la modification ou la création d'objet jusqu'au module Administrateurs du site.
                    Pratique pour automatiser sa petite maison.
                </p>
            </div>
        </div>

        <div class="row">
            <div class="text-content">
            <p>"Aujourd’hui, journée bien remplie ! Jean est parti tôt au travail, café en main, prêt à affronter une montagne de dossiers.
                    <br> Bella, elle, a déposé les enfants à l’école avant d’aller faire quelques courses pour la maison.
                    <br> De son côté, otis a passé son après-midi à réviser son exposé d’histoire pendant que Jeanne et Michelle, préparaient un bon gâteau aux pommes pour le goûter.
                    <br> En fin d’après-midi, Carl, le voisin, est passé dire bonjour et donner un coup de main pour bricoler la clôture du jardin.
                    <br><br> Une belle journée bien animée !"</p>
            </div>
            <div class="slideshow-container">
                <img :src="smallImages[smallCurrentIndex]" alt="Diaporama">
                <p class="caption">{{ smallCaptions[smallCurrentIndex] }}</p>
            </div>
        </div>
    </div>

    <script>
        new Vue({
            el: '#app',
            data: {
                images: [
                    'uploads/1.png',
                    'uploads/2.png',
                    'uploads/3.png'
                ],
                captions: [
                    'Le site possède une gestion des objets connectés dans toute la maison ;)',
                    'Une visualisation des profils de tous les utilisateurs !',
                    'Un système de point pour accéder à plus de fonctionnalités dans la maison.'
                ],
                smallImages: [
                    'uploads/A.png',
                    'uploads/B.png',
                    'uploads/C.png'
                ],
                smallCaptions: [
                    'Température de la journée :)',
                    'Nouveauté dans la famille, Smile nous rejoint YOUPIIII !!!!',
                    'Rénovation de la salle de bain'
                ],
                currentIndex: 0,
                smallCurrentIndex: 0
            },
            mounted() {
                this.startSlideshow();
            },
            methods: {
                startSlideshow() {
                    setInterval(() => {
                        this.currentIndex = (this.currentIndex + 1) % this.images.length;
                        this.smallCurrentIndex = (this.smallCurrentIndex + 1) % this.smallImages.length;
                    }, 3000);
                }
            }
        });
    </script>
</body>
</html>
