<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);

    // Changer l'état de l'objet (Allumer/Éteindre)
    if (isset($_POST['toggle'])) {
        $query = $bdd->prepare("UPDATE objets SET etat = IF(etat = 'éteint', 'allumé', 'éteint') WHERE id = ?");
        $query->execute([$id]);
    }

    // Ouvrir ou fermer les rideaux
    if (isset($_POST['toggle_position'])) {
        $query = $bdd->prepare("UPDATE objets SET etat = IF(etat = 'fermé', 'ouvert', 'fermé') WHERE id = ?");
        $query->execute([$id]);
    }

    // Changer de chaîne TV
    if (isset($_POST['change_chaine']) && !empty($_POST['chaine'])) {
        $query = $bdd->prepare("UPDATE television SET chaine = ? WHERE id = ?");
        $query->execute([$_POST['chaine'], $id]);
    }

    // Modifier le volume TV
    if (isset($_POST['change_volume']) && is_numeric($_POST['volume'])) {
        $query = $bdd->prepare("UPDATE television SET volume = ? WHERE id = ?");
        $query->execute([intval($_POST['volume']), $id]);
    }
}

// Redirection vers la page principale après chaque action
header("Location: Consultobj.php");
exit;
?>


