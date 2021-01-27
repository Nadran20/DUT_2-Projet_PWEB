<?php
//permet de crée une nouvelle facture en précisant l'entrprise , le loueur et la voiture 
function creationFact($IdEntreprise, $IdLoueur, $IdVoiture){
    require ("connectBD.php") ;
    $date = date('yy-m-d');
    $sql="INSERT INTO facturation(IdE, IdL,IdV, dateD) 
    values ($IdEntreprise,$IdLoueur,$IdVoiture,DATE '$date')";
    try {
        $commande = $pdo->prepare($sql);
        $commande->execute();
        $facture = $commande->fetch(PDO::FETCH_ASSOC); 
        return $pdo->lastInsertId();
    }
    catch (PDOException $e) {
        echo utf8_encode("Echec de l'image : " . $e->getMessage() . "\n");
        die(); // On arrête tout.
    }
}




//renvoie l'id d'une facture avec des parametres precis
function getFacture($IdEntreprise, $IdVoiture){
    require ("connectBD.php"); 
    $sql="SELECT IdFacture FROM `FACTURATION` WHERE IdE= $IdEntreprise and IdV = $IdVoiture and Etat='Non-regle'";
    try {
        $commande = $pdo->prepare($sql);
        $commande->execute();
        $IdFacture = $commande->fetch(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e) {
        echo utf8_encode("Echec de l'image : " . $e->getMessage() . "\n");
        die(); // On arrête tout.
    }
    return $IdFacture['IdFacture'];
}

//renvoie les factures non réglé d'une entreprise
function getFactureNonRéglé($IdE){
    require ("connectBD.php"); 
    $sql="SELECT IdFacture, IdL, IdV FROM FACTURATION where Etat='Non-regle' and IdE = '$IdE' and DateF!='NULL'";
    try {
        $factures = array();
        $commande = $pdo->prepare($sql);
        $commande->execute();
        while ($facture = $commande->fetchAll()) { 
            $factures = $facture; 
        }
            
    }
    catch (PDOException $e) {
        echo utf8_encode("Echec de l'image : " . $e->getMessage() . "\n");
        die(); // On arrête tout.
    }
    return $factures;
}

//renvoie les factures non réglé d'une entreprise
function getFactureNonRégléFini($IdE, $dateA){
    require ("connectBD.php") ; 
    $sql="SELECT IdFacture, IdL, IdV FROM FACTURATION where Etat='Non-regle' and IdE = '$IdE' and DateF<'$dateA'";
    try {
        $factures = array();
        $commande = $pdo->prepare($sql);
        $commande->execute();
        while ($facture = $commande->fetchAll()) { 
            $factures = $facture; 
        }
            
    }
    catch (PDOException $e) {
        echo utf8_encode("Echec de l'image : " . $e->getMessage() . "\n");
        die(); // On arrête tout.
    }
    return $factures;
}

//renvoie la date de début et la date de fin d'une facture.
function getDateF($idf) {
    require ("connectBD.php");
    $sql="SELECT DateD, DateF FROM Facturation where IdFacture=$idf"; 
        try {
            $commande = $pdo->prepare($sql);
            $commande->execute();
            if ($commande->rowCount() > 0) {  
                while ( $DateDF= $commande->fetch()) { 
                    $result['DateD'] =$DateDF['DateD']; 
                    $result['DateF'] =$DateDF['DateF'];
                }
            return $result;
            }
        }
        catch (PDOException $e) {
            echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
            die(); // On arrête tout.
        }
}   



// on défini le champ LocationVoiture sur 'disponible' a partir de l'id d'une facture pour laquelle on récupère l'id de la voiture  
function getVoitureFromFact($IdFacture) {
    require ("connectBD.php");
    $sql="SELECT IdV FROM Facturation WHERE IdFacture = $IdFacture";
    try {
        $commande = $pdo->prepare($sql);
        $commande->bindParam(':IdV', $IdV, PDO::PARAM_STR);
        $commande->execute();
        $retour = $commande->fetch();
        return $retour['IdV'];
    }
    catch (PDOException $e) {
        echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
        die(); // On arrête tout.
    }
}
//renvoi l'intégralité des attributs des factures d'un loueur
function getFactureLoueur($IdL){
    require ("connectBD.php") ; 
    $sql="SELECT * FROM FACTURATION where  IdL = '$IdL'";
    try {
        $factures = array();
        $commande = $pdo->prepare($sql);
        $commande->execute();
        while ($facture = $commande->fetchAll()) { 
            $factures = $facture; 
        }
        return $factures;
    }
    catch (PDOException $e) {
        echo utf8_encode("Echec de l'image : " . $e->getMessage() . "\n");
        die(); // On arrête tout.
    }
} 
 
function UpdateFactureDate($IdFacture, $dateFin) {
    require ("connectBD.php") ; 
    $sql="UPDATE `FACTURATION` SET dateF = '$dateFin'
    WHERE IdFacture= $IdFacture";
    try {
        $commande = $pdo->prepare($sql);
        $commande->execute();
        $facture = $commande->fetch(PDO::FETCH_ASSOC);
        $commande->debugDumpParams();
    }
    catch (PDOException $e) {
        echo utf8_encode("Echec de l'image : " . $e->getMessage() . "\n");
        die(); // On arrête tout.
    }
}

// on défini le champ 'Etat' sur Regle a partir de l'id d'une facture
function UpdateFactureEtat($IdFacture) {
    require ("connectBD.php") ; 
    $sql="UPDATE `FACTURATION` SET Etat='Regle'
    WHERE IdFacture= $IdFacture";
    try {
        $commande = $pdo->prepare($sql);
        $commande->execute();
        $facture = $commande->fetch(PDO::FETCH_ASSOC);
        $commande->debugDumpParams();
    }
    catch (PDOException $e) {
        echo utf8_encode("Echec de l'image : " . $e->getMessage() . "\n");
        die(); // On arrête tout.
    }
}



?>