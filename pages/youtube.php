<?php

// Récupération de l'id dans l'URL
$id = $_GET['id'];

/**
 *  On utilise pas l'objet PDOConnection , ni API.
 *  On réinvoque la connexion Mysql
 */
try {
    $pdo = new PDO('mysql:host=localhost;dbname=vr_tourism;charset=utf8', 'vr_tourism', 'Centifoli@44');
} catch (PDOException $e) {
    echo 'erreur : '.$e->getMessage(). 'code'.$e->getCode();
}

try {
    $query = "SELECT lien_video FROM api WHERE id = ".$id;
    $statement = $pdo->query($query);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $lien = $result['lien_video'];
} catch (PDOException $e) {
    echo 'erreur'.$e->getMessage();
}

$embed = explode('/', $lien);

// Affiche le lien vidéo
echo '
    <iframe width="560" height="315" src="https://www.youtube.com/embed/'.$embed[3].'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
<br>';