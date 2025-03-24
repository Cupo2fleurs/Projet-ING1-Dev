<?php
session_start();

// Connexion à la base de données
try {
    $pdo_option = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    $bdd = new PDO('mysql:host=localhost;dbname=utilisateur', 'root', '', $pdo_option);
} catch (Exception $ex) {
    die("Erreur : " . $ex->getMessage());
}

// Récupération des utilisateurs
$sql = "SELECT pseudo, age, sexe, born, grade,born, photo FROM users";
$stmt = $bdd->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Profils</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

<div class="flex justify-end">
    <a href="profil.php" class="text-2xl font-bold mb-4 text-blue-600 hover:underline">Modifier mon profil</a>
</div>

<div class="flex justify-end">
    <a href="Consultobj.php" class="text-2xl font-bold mb-4 text-blue-600 hover:underline">Consulter les objets</a>
</div>

<div id="app" class="max-w-6xl mx-auto">
    <center><h2 class="text-3xl font-bold mb-6">Liste des Profils</h2></center>
    
    <div class="grid grid-cols-3 gap-6">
        <profile-card v-for="user in users" :key="user.pseudo" :user="user"></profile-card>
    </div>
</div>

<script>
const { createApp } = Vue;

createApp({
    data() {
        return {
            users: <?php echo json_encode($users); ?>
        };
    }
}).component('profile-card', {
    props: ['user'],
    template: `
        <div class="border p-6 rounded-lg shadow-md bg-white transition transform hover:scale-105">
            <img :src="user.photo" :alt="user.pseudo" class="w-32 h-32 object-cover rounded-full mx-auto">
            <h3 class="text-lg font-semibold mt-4 text-center">@{{ user.pseudo }}</h3>
            <p class="text-gray-600 text-center">{{ user.age }} ans - {{ user.sexe }}</p>
            <p class="text-xs text-gray-500 text-center">Date de naissance : {{ user.born }}</p>
            <p class="font-bold text-blue-600 text-center">{{ user.type_membre }}</p>
        </div>
    `
}).mount('#app');
</script>

</body>
</html>
