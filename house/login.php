<!Doctype html>
<html lang="en">
<head>
    <title> inscription </title>
</head>
<body>
    <style>
        #inscri {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    }

    #inscri input {
        width: 100%;
        max-width: 300px; 
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
        
    </style>
<form id="inscri" method="POST" action="verif.php">
    <label>Votre Nom</label>
    <input type="text" id="nom" name="nom" required>
    <br />
    <label>Votre Prenom</label>
    <input type="text" id="prenom" name="prenom" required>
    <br />
    <label>Mot de passe</label>
    <input type="text" id="mdp" name="mdp" required>
    <br />
    <input type="submit" value="Valider" name="ok">
</form>

</body>
</html>
