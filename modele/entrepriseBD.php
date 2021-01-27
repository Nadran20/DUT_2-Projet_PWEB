<?php
        

    function actualiser(&$factures){
        require ("connectBD.php") ;
        $date = date('yy-m-d');
        $sql="SELECT IdFacture FROM FACTURATION WHERE DateF>$date and Etat = 'Non-regle'";
        try {
            $commande = $pdo->prepare($sql);
            $commande->execute();
            while ($facture = $commande->fetchAll()) { 
                $factures[] = $facture['IdFacture']; 
            }
        }
        catch (PDOException $e) {
            echo utf8_encode("Echec de l'image : " . $e->getMessage() . "\n");
            die(); // On arrête tout.
        }
    }

    function getNomLoueur($IdE){
        require ("connectBD.php");
        $sql="SELECT nomEnt FROM Entreprise  where IdEnt= $IdE";
        try{
            $commande = $pdo->prepare($sql);
            $commande->execute();
            
            $nomLoueur = $commande->fetch();
        }
        catch (PDOException $e) 
        {
            echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
            die();
        }
        return $nomLoueur;
    }

    function get_VoituresLoueur(&$véhicules, &$nbVoiture, $IdEntreprise){
        require ("connectBD.php");
        $sql="SELECT NomVoiture, IdVoiture FROM VOITURE  where IdEnt= $IdEntreprise";
        try{
            $commande = $pdo->prepare($sql);
            $commande->execute();
            $nbVoiture = $commande->rowCount();
            if ($commande->rowCount() > 0) {  
                while ($voiture = $commande->fetch()) { 
                    $véhicules[] = $voiture[0]; 
                }
        }
    }
        catch (PDOException $e) 
        {
            echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
            die();
        }
    }

    function get_VoituresLoueurDispo(&$nbVoiture, $IdEntreprise){
        require ("connectBD.php");
        $sql="SELECT NomVoiture, IdVoiture FROM VOITURE  where IdL= $IdEntreprise and LocationVoiture='Disponible'";
        try{
            $voitures ='';
            $commande = $pdo->prepare($sql);
            $commande->execute();
            $nbVoiture = $commande->rowCount();
            if ($commande->rowCount() > 0) {  
                while ($voiture = $commande->fetch()) { 
                    $voitures[] = $voiture; 
                }
                return $voitures;
            }
        }
        catch (PDOException $e) 
        {
            echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
            die();
        }
    }

    function get_VoitureLoueurRevision(&$nbRevision,$IdEntreprise){
        require ("connectBD.php");
        $sql="SELECT NomVoiture, IdVoiture FROM VOITURE  where IdL=$IdEntreprise and LocationVoiture='En_revision'";
        try{
            $voitures ='';
            $commande = $pdo->prepare($sql);
            $commande->execute();
            $nbRevision = $commande->rowCount();
            if ($commande->rowCount() > 0) {  
                while ($voiture = $commande->fetch()) { 
                    $voitures[] = $voiture; 
                }
                return $voitures;
            }
        }
        catch (PDOException $e) 
        {
            echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
            die();
        }
    }

    function get_VoituresLoueurNonDispo(&$nbVoiture, $IdEntreprise){
        require ("connectBD.php");
        $sql="SELECT NomVoiture, IdVoiture FROM VOITURE  where IdL = $IdEntreprise and LocationVoiture!='Disponible' and LocationVoiture!='En_revision'";
        try{
            $voitures = array();
            $commande = $pdo->prepare($sql);
            $commande->execute();
            $nbVoiture = $commande->rowCount();
            if ($commande->rowCount() > 0) {  
                while ($voiture = $commande->fetch()) { 
                    $voitures[] = $voiture; 
                }
                return $voitures;
            }
        }
        catch (PDOException $e) 
        {
            echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
            die();
        }
    }



    function get_TypeEntreprise($IdEnt){
        require ("connectBD.php");
        $sql="SELECT typeEnt FROM entreprise  where IdEnt=$IdEnt";
        try{
            $commande = $pdo->prepare($sql);
            $commande->execute();
            $types = $commande->fetch();
            return $types[0];
        }
        catch (PDOException $e) {
            echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
            die();
        }
    }

    function has_factures(&$factures, $IdEnt) {
        require ("connectBD.php");
        $sql="SELECT IdV, dateF FROM FACTURATION  where IdE=$IdEnt"; 
        try 
            {
            $commande = $pdo->prepare($sql);
            $commande->execute();
            if ($commande->rowCount() > 0) {  
                while ($facture = $commande->fetch()) { 
                    $factures[] = $facture; 
                }
            return true;
            }
            return false;
        }
        catch (PDOException $e) 
        {
                echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
                die(); // On arrête tout.
        }
    }

    function get_Loueurs(&$Liste){
        require ("connectBD.php");
        $sql="SELECT IdEnt FROM entreprise  where typeEnt = 'Loueur'";
        try{
            $commande = $pdo->prepare($sql);
            $commande->execute();
            if ($commande->rowCount() > 0) {  
                while($loueur = $commande->fetch()){
                $Liste[] = $loueur['IdEnt'];
                }
            return true;
            }
            else {
                return false;
            }
        }
        catch (PDOException $e) {
            echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
            die();
        }
    }

    function verif_ident($nom,$mdp, &$profil) {
        //connexion au serveur de BD -> voir fichier connect.php
        //requete select en BD  -> voir fin cours PDO -> requete paramétrée
        require ("connectBD.php");
        $sql="SELECT * FROM entreprise  where nomEnt=:nom and mdpEnt=:mdp"; 
        try {
            $commande = $pdo->prepare($sql);
            $commande->bindParam(':nom', $nom, PDO::PARAM_STR);
            $commande->bindParam(':mdp', $mdp, PDO::PARAM_INT);
            $commande->execute();
            
            //$commande->debugDumpParams(); //affiche la requete préparée
            //die ('RowCount ' . $commande->rowCount() . '<br/>');
            
            if ($commande->rowCount() > 0) {  //compte le nb d'enregistrement
                $profil = $commande->fetch(PDO::FETCH_ASSOC); //svg du profil
                return true;
            }
            else {
                return false;
            }
        }
        catch (PDOException $e) {
            echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
            die(); // On arrête tout.
        }
    //	return true; //ou false; suivant le cas
    }

    
    function verif_ident_Inscription($nom,$email,$type,&$profil) {
	//connexion au serveur de BD -> voir fichier connect.php
	//requete select en BD  -> voir fin cours PDO -> requete paramétrée
	require ("connectBD.php");
	$sql="SELECT * FROM entreprise  where nomEnt=:nom and mailEnt=:email and typeEnt=:type";  
	
	try {
		$commande = $pdo->prepare($sql);
        $commande->bindParam(':nom', $nom, PDO::PARAM_STR);
        $commande->bindParam(':type', $type, PDO::PARAM_STR);
		$commande->bindParam(':email', $email, PDO::PARAM_STR);
		$commande->execute();
		
		/*
		$commande->debugDumpParams(); //affiche la requete préparée
		die ('RowCount ' . $commande->rowCount() . '<br/>');
		*/

		if ($commande->rowCount() > 0) {  //compte le nb d'enregistrement
			$profil = $commande->fetch(PDO::FETCH_ASSOC); //svg du profil
			
			return true;
		}
		else {
			return false;
		}
	}
	
	catch (PDOException $e) {
		echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
		die(); // On arrête tout.
	}
//	return true; //ou false; suivant le cas
}

    function newInscrit($nom,$mdp,$email,$type,&$profil) {
	//connexion au serveur de BD -> voir fichier connect.php
	//requete select en BD  -> voir fin cours PDO -> requete paramétrée
	require ("connectBD.php");
	$sql="INSERT INTO entreprise(nomEnt, mdpEnt, mailEnt, typeEnt) VALUES(:nom, :mdp, :email, :type)";
	
	try {
		$commande = $pdo->prepare($sql);
		$commande->bindParam(':nom', $nom, PDO::PARAM_STR);
        $commande->bindParam(':mdp', $mdp, PDO::PARAM_STR);
        $commande->bindParam(':email', $email, PDO::PARAM_STR);
        $commande->bindParam(':type', $type, PDO::PARAM_STR);
		$commande->execute();
		
		/*$commande->debugDumpParams(); //affiche la requete préparée
        die ('RowCount ' . $commande->rowCount() . '<br/>');
        */
		
		if ($commande->rowCount() > 0) {  //compte le nb d'enregistrement
            $profil = $pdo->lastInsertId();
			return true;
		}
		else {
			return false;
		}	
    }
    catch (PDOException $e) {
		echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
		die(); // On arrête tout.
    }
}





function getInfoEntreprise($IdE){
    require ("connectBD.php");
	$sql="SELECT * FROM `ENTREPRISE` WHERE IdEnt = $IdE";
	try {
		$commande = $pdo->prepare($sql);$commande->execute();
		if ($commande->rowCount() > 0) {  //compte le nb d'enregistrement
            $info = $commande->fetchAll(); 
            return $info;
        }
    }
    catch (PDOException $e) {
		echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
		die(); // On arrête tout.
    }
}
?>