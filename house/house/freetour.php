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
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
        }

        .container {
            display: flex;
            flex-direction: column;
            width: 90%;
            max-width: 1200px;
            margin-top: 50px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            margin-bottom: 50px;
        }

        .slideshow-container {
            position: relative;
            width: 45%;
            max-width: 600px;
            overflow: hidden;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 20px;
        }

        .text-content {
            width: 45%;
            font-size: 1.2rem;
            color: #333;
            text-align: justify;
        }

        .slides {
            width: 100%;
        }

        .caption {
            margin-top: 10px;
            font-size: 1.2rem;
            color: #333;
        }
    </style>
</head>
<body>

    <h2 class="text-2xl font-bold mb-4">Chez les Bon, qu'est-ce qui se passe ?</h2>
    <div style="text-align: center; padding-left: 20px;">
        <?php if ($isConnected): ?>
            <a href="Consultobj.php" class="text-xl font-bold text-blue-500 hover:underline">Retour aux objets</a>
        <?php else: ?>
            <a href="index.php" class="text-xl font-bold text-blue-500 hover:underline">Retour page d'accueil</a>
        <?php endif; ?>
    </div>
    <div id="app" class="container">
        <div class="row">
            <div class="slideshow-container">
                <img :src="images[currentIndex]" class="slides" alt="Diaporama">
                <p class="caption">{{ captions[currentIndex] }}</p>
            </div>
            <div class="text-content">
                <p>Voici une petite présentation de notre site internet qui permet d'utiliser de façon simple et automatique les différents appareils de la maison</p>
            </div>
        </div>

        <div class="row">
            <div class="text-content">
                <p>Aujourd'hui, petite journée chacun est allé à son travail, Otis est revenu avec un 16.5/20 en Mathématiques puis est allé au Judo.</p>
            </div>
            <div class="slideshow-container">
                <img :src="smallImages[smallCurrentIndex]" class="slides" alt="Diaporama">
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
                    'Un système de point pour pouvoir avoir accès à plus de fonctionnalités dans la maison (Ajout de nouveaux objets) '
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
