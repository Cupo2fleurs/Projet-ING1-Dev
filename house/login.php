<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        #inscri {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        #inscri input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .btn {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .btn-green {
            background-color: #28a745;
        }
        .btn-green:hover {
            background-color: #218838;
        }
        .btn-container {
            display: flex;
            justify-content: flex-start;
            margin-top: 20px;
        }
        .error-message {
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div id="app" class="container">
        <h2>Inscription</h2>

        <form id="inscri" @submit.prevent="submitForm">
            <label for="nom">Votre Nom</label>
            <input type="text" id="nom" v-model="nom" :class="{'input-error': errors.nom}" required>
            <div v-if="errors.nom" class="error-message">{{ errors.nom }}</div>
            
            <label for="prenom">Votre Prénom</label>
            <input type="text" id="prenom" v-model="prenom" :class="{'input-error': errors.prenom}" required>
            <div v-if="errors.prenom" class="error-message">{{ errors.prenom }}</div>

            <label for="mdp">Mot de passe</label>
            <input type="password" id="mdp" v-model="mdp" :class="{'input-error': errors.mdp}" required>
            <div v-if="errors.mdp" class="error-message">{{ errors.mdp }}</div>

            <input type="submit" value="Valider" class="btn">
        </form>
        
        <div class="btn-container">
            <button class="btn btn-green" @click="navigateTo('objets')">Voir les objets</button>
        </div>
    </div>

    <script>
        new Vue({
            el: '#app',
            data: {
                nom: '',
                prenom: '',
                mdp: '',
                errors: {}
            },
            methods: {
                submitForm() {
                    this.errors = {}; // Reset errors
                    let valid = true;
                    if (this.nom === '') {
                        this.errors.nom = 'Le nom est requis.';
                        valid = false;
                    }
                    if (this.prenom === '') {
                        this.errors.prenom = 'Le prénom est requis.';
                        valid = false;
                    }
                    if (this.mdp === '') {
                        this.errors.mdp = 'Le mot de passe est requis.';
                        valid = false;
                    }

                    if (valid) {
                        // Redirection vers le profil.php
                        window.location.href = 'Consultobj.php';
                    }
                },
                navigateTo(page) {
                    if (page === 'objets') {
                        window.location.href = 'objets.html';
                    }
                }
            }
        });
    </script>
</body>
</html>
