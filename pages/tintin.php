<!DOCTYPE html>
<html>
    <head>
        <title>Testeur</title>
        <meta charset="utf_8">
    </head>

    <body>

<?php


// PAGE DE TEST. Cette page permet de tester si l'API fonctionne


// Lien sur l'ancien hébergeur
$data = file_get_contents("http://10.0.2.10/read.php?idTag=12");


// l'API envoie comme réponse du JSON. On décode donc le JSON
$json = json_decode($data, true);



if (!empty($json)) {
    $video = $json['lien_video'];
    $embed = explode('/',$video);
    //On affiche le code de YouTube avec l'URL du player
    echo $video;
    echo '<iframe width="560" height="315" src="https://www.youtube.com/embed/'.$embed[3].'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
} else {
    echo "Aucune vidéo à afficher !";
}

?>

<!--	<iframe width="560" height="315" src="https://www.youtube.com/embed/3s50yYbLkog" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>-->
    </body>
</html>
