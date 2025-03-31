<?php
session_start();
try { 
    $pdo_option = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    $bdd = new PDO('mysql:host=localhost;dbname=utilisateur', 'root', '', $pdo_option);
} catch (Exception $ex) {
    die("Erreur :" . $ex->getMessage());  
}

if (isset($_POST['ok'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $mdp = $_POST['mdp'];
}

// Vérifier si l'utilisateur existe dans la BDD
$sql = "SELECT * FROM users WHERE nom = :nom AND prenom = :prenom";
$stmt = $bdd->prepare($sql);
$stmt->execute(['nom' => $nom, 'prenom' => $prenom]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && $mdp === $user['mdp']) { 
    // Si le pseudo est vide, on génère un pseudo
    if (empty($user['pseudo'])) {
        $pseudo = ucfirst(strtolower($nom)) . strtoupper(substr($prenom, 0, 1));
        $updatePseudo = $bdd->prepare("UPDATE users SET pseudo = :pseudo WHERE id = :id");
        $updatePseudo->execute(['pseudo' => $pseudo, 'id' => $user['id']]);
    } else {
        $pseudo = $user['pseudo'];
    }

    // Stocker les informations en session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nom'] = $user['nom'];
    $_SESSION['pseudo'] = $pseudo;
    $_SESSION['photo'] = $photo;

    // Enregistrer la connexion de l'utilisateur
    $sql = "INSERT INTO connexions (user_id) VALUES (:user_id)";
    $stmt = $bdd->prepare($sql);
    $stmt->execute(['user_id' => $user['id']]);

    // Redirection
    header("Location: Consultobj.php");
    exit();
} else {
    echo "Erreur, utilisateur pas dans la base de données.";
}
?>