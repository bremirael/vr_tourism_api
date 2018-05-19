<?php

/**
 * Class User
 * description : Représentation sous forme d'une classe de la table API
 */
class User
{
    // Récupére la connection pdo
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Récupère le password en base de données.
     * On pourra la comparé avec la valeur inscrite dans le formulaire
     * @param $username
     * @return mixed
     */
    public function passwordVerifyConnection($username)
    {
        try {
            $query = "SELECT password FROM user WHERE username = '".$username."'";
            $statement = $this->pdo->query($query);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result['password'];
        } catch (PDOException $e) {
            echo "Utilisateur incorrect";
        }
    }
}