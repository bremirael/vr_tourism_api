<?php

$id = $_GET['id'];
$video_link = $_GET['video_link'];

try {
    $pdo = new PDO('mysql:host=localhost;dbname=vr_tourism;charset=utf8', 'vr_tourism', 'Centifoli@44');
} catch (PDOException $e) {
    echo 'erreur : '.$e->getMessage(). 'code'.$e->getCode();
}

try {
    $query = "UPDATE api SET lien_video = '".$video_link ."' WHERE id = ".$id;
    $pdo->exec($query);
} catch (PDOException $e) {
    echo 'erreur'.$e->getMessage();
}


try {
    $query = "SELECT lien_video FROM api WHERE id = ".$id;
    $statement = $pdo->query($query);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    echo $result['lien_video'];
} catch (PDOException $e) {
    echo 'erreur'.$e->getMessage();
}
