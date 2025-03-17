
<?php
session_start();
try{ 
    $pdo_option = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    $bdd=new PDO('mysql:host=localhost;dbname=utilisateur','root','',$pdo_option);

    //echo "Connexion réussie";
}catch(Exception $ex){
        die("Erreur :".$ex->getMessage());  
}

if(isset($_POST['ok'])){
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $mdp = $_POST['mdp'];
}


// Vérifier si l'utilisateur existe dans la BDD
$sql = "SELECT * FROM users WHERE nom = :nom AND prenom = :prenom";
$stmt = $bdd->prepare($sql);
$stmt->execute(['nom' => $nom, 'prenom' => $prenom]); 
$user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérification du mot de passe hashé
    if ($user && $mdp === $user['mdp']) { 
        // Stocker les informations en session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['prenom'] = $user['prenom'];
        echo "Connexion réussie !";
        header("Location: profil.php");
    } else {
        echo "Erreur, utilisateur pas dans la base de donnée.";
    }


    
?>