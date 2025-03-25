
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
            // Si le pseudo est vide, on génère un pseudo avec la première lettre du nom et du prénom
            if (empty($user['pseudo'])) {
                $pseudo = ucfirst(strtolower($nom)) . strtoupper(substr($prenom, 0, 1));
                $updatePseudo = $bdd->prepare("UPDATE users SET pseudo = :pseudo WHERE id = :id");
                $updatePseudo->execute(['pseudo' => $pseudo, 'id' => $user['id']]);
            } else {
                $pseudo = $user['pseudo'];
            }
    
            // Si la photo est vide, on met une image par défaut
            if (empty($user['photo'])) {
                $photo = 'uploads/default.jpg';
                $updatePhoto = $bdd->prepare("UPDATE users SET photo = :photo WHERE id = :id");
                $updatePhoto->execute(['photo' => $photo, 'id' => $user['id']]);
            } else {
                $photo = $user['photo'];
            }
                    // Stocker les informations en session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['pseudo'] = $pseudo;
        $_SESSION['photo'] = $photo;
        header("Location: Consultobj.php");
        exit();
    } else {
        echo "Erreur, utilisateur pas dans la base de donnée.";
    }



?>