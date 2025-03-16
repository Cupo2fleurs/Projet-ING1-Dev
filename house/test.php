<?php
    try{ 
        $pdo_option = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
        $bdd=new PDO('mysql:host=localhost;dbname=house','root','',$pdo_option);

        //echo "Connexion réussie";
    }catch(Exception $ex){
            echo "Erreur :".$ex->getMessage();
    }
    $sql ="SELECT * FROM user";
    $req = $bdd->query($sql);
    while($rep = $req->fetch()){
        echo $rep['prenom'].' '.$rep['nom'].' '.$rep['age'].'<br>';
    }


    if(isset($_POST['ok'])){
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $pseudo = $_POST['pseudo'];
        $age = $_POST['age'];
    }
    // Methode pour s'inscrire

    $requete = $bdd->prepare("INSERT INTO users VALUES (0, :nom, :prenom, :pseudo, :age)");
    $requete->execute(
        array(
            "nom" => $nom,
            "prenom" => $prenom,
            "pseudo" => $pseudo,
            "age" => $age ,
            )
        );
        echo " Inscription réussie !";
        //header("Location: truc.php") Pour rediriger vers un autre
?>



$requete = $bdd->prepare("INSERT INTO users VALUES (0, :nom, :prenom, :pseudo, :age)");
$requete->execute(
    array(
        "nom" => $nom,
        "prenom" => $prenom,
        "pseudo" => $pseudo,
        "age" => $age ,
        )
    );
    echo " Inscription réussie !";
    //header("Location: truc.php") Pour rediriger vers un autre