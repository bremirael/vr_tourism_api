<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once 'classes/PDOConnection.php';
include_once 'classes/Api.php';
 

if (isset($_GET['idTag'])) {
    $idTag = $_GET['idTag'];
}


//$array = PDOConnection::getParameters();

//var_dump($array);



$pdo = new PDOConnection();


// Récupération de la table API
$api = new Api($pdo);


// query api

if (isset($_GET['idTag'])) {
    $statement = $api->readByIdTag($idTag);
    $num = $statement->rowCount();
} else {
    $statement = $api->read();
    $num = $statement->rowCount();
}



// Si il y a au moins un enregistrement
if($num > 0){


    //$api_arr = null;

    while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
        // Permet de transformer les valeurs en variable
        extract($row);

        $api_item=array(
            //"id" => $id,
            //"id_scanner" => $id_scanner,
            "lien_video" => $lien_video
        );

        //array_push($api_arr, $api_item);
    }

    echo json_encode($api_item);
} else {
    echo json_encode(
        array("message" => "Lien vidéo introuvable")
    );
}
?>
