    <?php
    session_start ();
    date_default_timezone_set('Europe/Paris');

    if ((count($_GET)!=0) && !(isset($_GET['controle']) && isset ($_GET['action'])))
        require ('./vue/message/erreur404.tpl'); //cas d'un appel à index.php avec des paramètres incorrects
    else {
        if (/*!isset($_SESSION['IdEnt'])) || */count($_GET)==0)	{ // action par defaut.... notamment en cas de personne non authentifiée
            include ("vue/utilisateur/Accueil.tpl");
            include ('controle/voiture.php');
            afficherLocations(); 
        }
        else {
            if (isset($_GET['controle']) && isset ($_GET['action'])) {
				$controle = $_GET['controle'];   //cas d'un appel à index.php 
                $action =  $_GET['action'];	//avec les 2 paramètres controle et actio
            }
            require ('./controle/' . $controle . '.php');
            $action(); // On exécute la fonction dont le nom est dans la variable $action
        }
    }
?>