<?php
//renvoie les informations nécessaires à l'affichage d'une voiture
function infoVoiture($idv){
    require ("connectBD.php") ; 
    $sql="SELECT NomVoiture, photo, CaractVoiture, valeur FROM VOITURE WHERE IdVoiture=:idv";
    try {
        $commande = $pdo->prepare($sql);
        $commande->bindParam(':idv', $idv, PDO::PARAM_INT);
        $commande->execute();
        $voiture = $commande->fetch(PDO::FETCH_ASSOC);
        $carac = $voiture['CaractVoiture'];
        $carDec = json_decode($carac);
        $voiture['moteur'] = $carDec->moteur;
        $voiture['vitesse'] = $carDec->vitesse;
    }
    catch (PDOException $e) {
        echo utf8_encode("Echec de l'image : " . $e->getMessage() . "\n");
        die(); // On arrête tout.
    }
    return $voiture;
}

//renvoie le prix d'une voiture présente dans une facture, grace à l'id de cette facture
function getPrix($IdFacture){
    require ("connectBD.php");
    $sql="SELECT valeur FROM Voiture where IdVoiture =(SELECT IdV FROM Facturation WHERE IdFacture=:idfact)"; 
    try {
        $commande = $pdo->prepare($sql);
        $commande->bindParam(':idfact', $IdFacture, PDO::PARAM_INT);
        $commande->execute();
        $voiture=$commande->fetch();
    }
    catch (PDOException $e) 
    {
        echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
        die(); // On arrête tout.
    }
    return $voiture['valeur'];
}

//fonction qui renvoie le proprio de la voiture, dont l'id est passé en paramètre
function get_Propriétaire($IdVoiture){
    require ("connectBD.php");
    $sql="SELECT IdL FROM VOITURE WHERE IdVoiture=:idv";
    try {
        $commande = $pdo->prepare($sql);
        $commande->bindParam(':idv', $IdVoiture, PDO::PARAM_INT);
        $commande->execute();
        $locataire = $commande->fetch(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e) {
        echo utf8_encode("Echec de l'image : " . $e->getMessage() . "\n");
        die(); // On arrête tout.
    }
    return $locataire['IdL'];
}

//renvoie le nombre de voiture louable, affecte par référence la liste des Id des voitures louables
function get_IdLouable(&$nbVoiture){
    require ("connectBD.php");
    $sql="SELECT NomVoiture, IdVoiture FROM VOITURE WHERE LocationVoiture = 'Disponible'";
    try {
        $VoitureLouable ='';
        $commande = $pdo->prepare($sql);
        $commande->execute();
        while($voiture = $commande->fetch()){
            $VoitureLouable[] = $voiture;
        }
        $nbVoiture = $commande->rowcount();
        return $VoitureLouable;
    }
    catch (PDOException $e) {
        echo utf8_encode("Echec de l'image : " . $e->getMessage() . "\n");
        die(); // On arrête tout.
    }
}

//défini comme "loué" une voiture en mettant l'id de l'entreprise qui l'a loue dans le champ 'LocationVoiture'
function putAsRented($IdVoiture, $IdEntreprise){
    require ("connectBD.php") ; 
    $sql="UPDATE `Voiture` SET LocationVoiture =:ide
    WHERE IdVoiture=:idv";
    try {
        $commande = $pdo->prepare($sql);        
        $commande->bindParam(':ide', $IdEntreprise, PDO::PARAM_INT);
        $commande->bindParam(':idv', $IdVoiture, PDO::PARAM_INT);
        $commande->execute();
    }
    catch (PDOException $e) {
        echo utf8_encode("Echec de l'update : " . $e->getMessage() . "\n");
        die(); // On arrête tout.
    }
}

//ajout d'une voiture au stock
function ajouterVoiture ($IdEntreprise, $nomV, $moteur, $vitesse, $prix, $target_dir){
    $json_ = array('moteur' => $moteur, 'vitesse' => $vitesse);
    $carac="";
    $carac = json_encode($json_);
    require ("connectBD.php") ; 
    $url=$target_dir.$_FILES["fileselect"]["name"];
    $sql="INSERT INTO Voiture (IdL, NomVoiture, CaractVoiture,LocationVoiture, Photo, Valeur) VALUES  
    ($IdEntreprise, '$nomV', '$carac','Disponible','$url', $prix)";
    try {
        $commande = $pdo->prepare($sql);
        $commande->execute();
        if ($commande->rowCount() > 0) {  
            return true;
        }
        else {
            return false;
        }	
    }
    catch (PDOException $e){
        echo utf8_encode("Echec de insert: " . $e->getMessage() . "\n");
        die(); // On arrête tout.
    }
}  


    
//Renvoie la liste des voitures du loueur en paramètre, affecte le nombre de voiture du loueur par référence
function get_VoituresLouer($IdEntreprise,&$nbVoiture) {
    require ("connectBD.php");
    $sql="SELECT NomVoiture, IdVoiture FROM VOITURE WHERE LocationVoiture =:ide" ;
    try {
        $VoitureLouable = '';
        $commande = $pdo->prepare($sql);
        $commande->bindParam(':ide', $IdEntreprise, PDO::PARAM_INT);
        $commande->execute();
        while($voiture = $commande->fetch()){
            $VoitureLouable[] = $voiture;
        }
        $nbVoiture = $commande->rowcount();
        return $VoitureLouable;
    }
    catch (PDOException $e) {
        echo utf8_encode("Echec du select : " . $e->getMessage() . "\n");
        die(); // On arrête tout.
    }
}

//on renvoie la liste des voitures disponible du loueur (id) passé en paramètre
function getVoitureDispoLoueur($IdE, &$nbVoiture){
    require ('connectBD.php');
    $script="";
    $sql="SELECT IdVoiture, NomVoiture FROM Voiture where LocationVoiture='disponible' and IdL =:ide";
    try { 
        $liste=array();   
        $commande = $pdo->prepare($sql);    
        $commande->bindParam(':ide', $IdE, PDO::PARAM_INT);
        $commande->execute(); 
        while($voiture = $commande->fetch()) {
            $liste[] = $voiture;
        }
        $nbVoiture = $commande->rowcount();
        return $liste;
    }
    catch (PDOException $e) {
        echo utf8_encode("Echec du select : " . $e->getMessage() . "\n");
        die(); // On arrête tout.
    }
}

//on supprime de la base la voiture passé en paramètre (id)
function unsetVoiture($IdV) {
    require ("connectBD.php");
    $sql="DELETE FROM `voiture` WHERE `IdVoiture` = :IdV";
    try {
        $commande = $pdo->prepare($sql);
        $commande->bindParam(':IdV', $IdV, PDO::PARAM_STR);
        $commande->execute();
        if ($commande->rowCount() > 0) {  
            return true;
        }
        else {
            return false;
        }	
    }
    catch (PDOException $e) {
        echo utf8_encode("Echec de delete : " . $e->getMessage() . "\n");
        die(); // On arrête tout.
    }
}


//on met en réparation (change le champ locationVoiture)  la voiture en paramètre (id)
function setVoitureRevision($IdV){
    require ("connectBD.php");
    $sql="UPDATE `voiture` SET `LocationVoiture` = 'En_revision' WHERE `voiture`.`IdVoiture` = $IdV";
    try {
        $commande = $pdo->prepare($sql);
        $commande->bindParam(':IdV', $IdV, PDO::PARAM_STR);
        $commande->execute();

        if ($commande->rowCount() > 0) {
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
//on met en disponible (change le champ locationVoiture)  la voiture en paramètre (id)
function setVoitureDispo($IdV) {
    require ("connectBD.php");
    $sql="UPDATE `voiture` SET LocationVoiture = 'Disponible' WHERE IdVoiture = $IdV";
    try {
        $commande = $pdo->prepare($sql);
        $commande->bindParam(':IdV', $IdV, PDO::PARAM_STR);
        $commande->execute();
        $commande->debugDumpParams();
        if ($commande->rowCount() > 0) {  
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
//on renvoie la liste des voitures en réparation du loueur (id) passé en paramètre
function getRevision($IdEntreprise, &$retour){
    require ("connectBD.php");
    $sql="SELECT NomVoiture, IdVoiture FROM `Voiture` WHERE IdL=$IdEntreprise and LocationVoiture = 'En_revision'";
    try {
        $commande = $pdo->prepare($sql);
        $commande->execute();
        while($id = $commande->fetch()){
            $retour[] = $id;
        }
        return $commande->rowCount();
    }
    catch (PDOException $e) {
        echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
        die(); // On arrête tout.
    }
}

?>