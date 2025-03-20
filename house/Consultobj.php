<!Doctype html>
<html lang="en">
<head>
</head>
<body>
    <style>
        a {
        display: flex;
        flex-direction: column;
        text-align: right;
        color: black;
        font-size: 30px;
        }
       

    </style>
<a href="profil.php">Modifier mon profil</a>

</body>
</html>

<?php
session_start();

try {
    $pdo_option = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    $bdd = new PDO('mysql:host=localhost;dbname=utilisateur', 'root', '', $pdo_option);
} catch (Exception $ex) {
    die("Erreur : " . $ex->getMessage());
}
if (!isset($_SESSION['user_id'])) {
    echo "<p style='color:red;'>Vous devez être connecté.</p>";
    exit();
}
?>