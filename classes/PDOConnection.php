<?php

/**
 * Class PDOConnection
 * Description : Connecteur Mysql
 */
class PDOConnection extends PDO
{
	public function __construct()
    {
        $bdd = self::getParameters();
        parent::__construct($bdd['dsn'], $bdd['login'], $bdd['mdp']);
	}

    /**
     * Fonction privée qui récupère les informations de connexion à la base de données
     * Les informations se trouvent dans un fichier bdd.ini
     * @return array|bool|string
     */
	private static function getParameters()
	{
	    // Recupère le fichier de config
        $filename = 'config/bdd.ini';

        if (file_exists($filename)) {
			$ini_array = parse_ini_file($filename);
			return $ini_array;	
		} else {
			return "erreur veuillez contacter la hotline";
		}	
		
	}

}
