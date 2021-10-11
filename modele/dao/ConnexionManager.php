<?php
	/**
	 * Gestionnaire des connexions à la base de données
	 */
	class ConnexionManager
	{
		private static $bdd;

		public static function getInstance()
		{
			if (self::$bdd === null)
			{
				try
				{
					self::$bdd = new PDO('mysql:host=localhost;dbname=glsi_blog;charset=utf8', 'root', '');
				}
				catch (Exception $e)
				{
					echo "Erreur de connexion à la base de données : ".$e->getMessage();
					self::$bdd = null;
				}
			}
			
			return self::$bdd;
		}
	}
?>