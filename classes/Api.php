<?php

/**
 * Class Api
 * description : Représentation sous forme d'une classe de la table API
 */
class Api
{
    // Récupére la connection pdo
    private $pdo;

    public function __construct($pdo) 
    {
        $this->pdo = $pdo;
    }

    /**
     * Permet de recueillir les informations de la table API.
     * @return mixed
     */
    public function read()
    {
 
        // select all query
        $query = "SELECT * FROM api";
     

        $statement = $this->pdo->query($query);
     
        // execute query
        $statement->execute();
     
        return $statement;
    }

    /**
     * Permet de lire la table api en fonction de l'id TAG passé en paramètre.
     * Cette fonction est utilisé par l'application mobile pour récupérer les données vidéos
     * @param $tag
     * @return mixed
     */
    public function readByIdTag($tag)
    {
        try {
            $query = "SELECT * FROM api WHERE id_scanner = ".$tag;
            $statement = $this->pdo->query($query);
            $statement->execute();
            return $statement;
        } catch (PDOException $e) {
            echo "Id tag inexistant";
        }

    }

    /**
     * Fonction utilisé pour les appels Ajax dans le backoffice.
     * Permet d'afficher les lien video en fonction de la video choisie et de l'id du lien passé en paramètre
     * @param $i
     * @return mixed
     */
    public function getVideoLink($i)
    {
        try {
            $query = "SELECT lien_video FROM api WHERE id = ".$i;
            $statement = $this->pdo->query($query);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result['lien_video'];
        } catch (PDOException $e) {
            echo 'erreur'.$e->getMessage();
        }
    }

    /**
     * Fonction  qui compte le nombre de lien video qu'il y a dans la table.
     * Utile pour éviter de surcharger la page d'index.
     * @return mixed
     */
    public function countVideoLink()
    {
        try {
            $query = "SELECT lien_video FROM api";
            $nb_link = $this->pdo->query($query);
            $nb_link->execute();
            return $count = $nb_link->rowCount();
        } catch (PDOException $e) {
            echo 'erreur'.$e->getMessage();
        }
    }

}