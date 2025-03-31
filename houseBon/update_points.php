<?php
session_start();

try {
    $bdd = new PDO('mysql:host=localhost;dbname=utilisateur', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $ex) {
    die("Erreur : " . $ex->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = intval($_POST['user_id']);
    $points = intval($_POST['points']);

    $sql = "UPDATE users SET points = points + :points WHERE id = :user_id";
    $stmt = $bdd->prepare($sql);
    $stmt->execute(['points' => $points, 'user_id' => $user_id]);

    header("Location: admin_dashboard.php");
    exit();
}
?>
