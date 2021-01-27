<?php

//Création d'une facture
function creationFacture($ide, $idL, $idV, $dateF){
    require_once ('modele/factureBD.php');
    if(($dateF==null)) {
        $IdFacture = creationFact($ide, $idL, $idV);
    }
    else{
        $IdFacture = creationFact($ide, $idL, $idV);
        UpdateFactureDate($IdFacture, $dateF);
    }
}

//Renvoie une différence entre deux date en jours 
function NbJours($debut, $fin) {
    $tDeb = explode("-", $debut);
    $tFin = explode("-", $fin);
    $diff = mktime(0, 0, 0, $tFin[1], $tFin[2], $tFin[0]) - mktime(0, 0, 0, $tDeb[1], $tDeb[2], $tDeb[0]);
    return(($diff / 86400)+1);
}

//Controle pour régler une facture fini
function reglerFactureFini() {
    require_once('modele/factureBD.php');
    $IdFacture = isset($_POST['choixFacture'])?($_POST['choixFacture']):'';
    $ListIdFacture = getFactureNonRégléFini($_SESSION['IdEnt'], date('yy-m-d'));
    if (!empty($ListIdFacture)){
        if (count($_POST)==0 ){
            $scriptFacture='';
            choixFactureFini($_SESSION['IdEnt'],$scriptFacture);
            require ("vue/facture/ChoixFacture.tpl");
        }   
        else {
            $IdFacture = $_POST['choixFacture'];
            $scriptInfoP = calculMontant($IdFacture,$_SESSION['IdEnt']);
            $_SESSION['IdFacture']=$IdFacture;
            $annéeMin = date('yy')+0;
            $annéeMax = $annéeMin +3;
            $msgError ='';
            require ('vue/facture/Paiement.tpl');
        }
    } 
    else {
        require_once('controle/entreprise.php');
        AucuneFactureDispo();
    }
}

//Permet de remplir la liste déroulante de ChoixFacture avec les factures non réglé
function choixFactureFini($ide,&$scriptFacture){
    $scriptFacture="";
    $ListeIdfactures = array();
    require_once ('modele/factureBD.php');
    $ListeIdfactures = getFactureNonRégléFini($ide, date('yy-m-d'));
    $scriptF = '';
    foreach ($ListeIdfactures as $facture){
        //part script
        //afficher le nom de la voiture dans la liste et le nom du loueur
        require_once ('modele/voitureBD.php');
        require_once ('modele/entrepriseBD.php');
        $nomLoueur= getNomLoueur($facture['IdL']);
        $nomVoiture = infoVoiture($facture['IdV']);
        $scriptF= $scriptF.'<option value="'.$facture['IdFacture'].'">'.$nomVoiture['NomVoiture'].' du loueur '.$nomLoueur['nomEnt'].'</option>';
        }
        $scriptFacture =$scriptF;
}


//Permet de remplir la liste déroulante de ChoixFacture avec les factures non réglé
function choixFacture($ide,&$scriptFacture){
    $scriptFacture="";
    $ListeIdfactures = array();
    require_once ('modele/factureBD.php');
    $ListeIdfactures = getFactureNonRéglé($ide);
    $scriptF = '';
    foreach ($ListeIdfactures as $facture){
        //part script
        //afficher le nom de la voiture dans la liste et le nom du loueur
        require_once ('modele/voitureBD.php');
        require_once ('modele/entrepriseBD.php');
        $nomLoueur= getNomLoueur($facture['IdL']);
        $nomVoiture = infoVoiture($facture['IdV']);
        $scriptF= $scriptF.'<option value="'.$facture['IdFacture'].'">'.$nomVoiture['typeVoiture'].' du loueur '.$nomLoueur['nomEnt'].'</option>';
        }
        $scriptFacture =$scriptF;
}


//controle pour payer une location
function payé(){
    if (count($_POST)==0 ){
        require ("vue/facture/Paiement.tpl") ;
    }
    else 
    {
        $IdFacture = $_SESSION['IdFacture'];
        require_once ('modele/factureBD.php');
        require_once ('modele/voitureBD.php');
        $date = date('yy-m-d');
        //SI la date de fin est pas mis on la met
        $dateFact = getDateF($IdFacture);
        if(empty($dateFact['DateF'])){
            updateFactureDate($IdFacture, $date);
            UpdateFactureEtat($IdFacture);
        }
        else
        {
            UpdateFactureEtat($IdFacture);
        }
        setVoitureDispo($_SESSION['IdV']);
        $nexturl = "index.php?controle=entreprise&action=FacturePayé";
		header("Location:" . $nexturl); // On retourne à la page index !!!
    }
}

//permet de réalsier un script contenant le nom de l'entreprise,les informations des factures et des voitures liées a cette derniers
function listFacture(&$scriptRF){
    $fact= array();
    require_once('modele/factureBD.php');
    require_once('modele/entrepriseBD.php');
    require_once('controle/voiture.php');
    $fact= getFactureLoueur($_SESSION['IdEnt']);
    foreach($fact as $f){
        $Entreprises[] = getInfoEntreprise($f['IdE']);
    }
    if(empty($Entreprises)){
        $scriptRF='';
        return false;
    }
    else
    {
    $scriptRF='<div class ="entreprises">';
    foreach($Entreprises as $e){
        $scriptRF="<div class="."entreprise"."><div class=".'NomEntreprise'."> ".$e[0]['nomEnt']."</div>";
        foreach($fact as $f) {
            $scriptRF=$scriptRF."<div class="."Billet".">" ;
            $scriptRF= $scriptRF.afficherVoiture($f['IdV'],false);
            $scriptRF= $scriptRF.afficherFacture($f);       
            $scriptRF= $scriptRF."</div>";
        }
        $scriptRF=$scriptRF."</div>";
    }  
    $scriptRF = $scriptRF."</div>";  
    return true;
    }
}

//permet de réaliser un script contenant l'id de la facture ,la date de début , la date de fin et la valeur de cette derniers
function afficherFacture($fact){
    $script="<div class ="."Facture".">";
    if(strcmp($fact['Etat'], "Regle")==0){
        $script = $script."<div class=\"paye\">";
    }
    else{
        $script = $script."<div class=\"impaye\">";
    }
    $script = $script."<div class="."IdFacture"."> Facture N° ".$fact['IdFacture'].
    "</div></div><div class="."InfoFacture"."><div class="."DateD"."> Début de la location: ".$fact['DateD']."</div>";
    if(empty($fact['DateF'])){
        $script=$script."<div class="."DateF"."> Location en cours</div>";
    }
    else {
        $script=$script."<div class="."DateF"."> Fin de la location: ".$fact['DateF']."</div>";
    }
    if(strcmp($fact['Etat'], "Regle")==0){
        $scriptPrix ="<div class="."Valeur".">Le montant de cette facture est de <div class=\"euro\">".calculMontant($fact['IdFacture'],$_SESSION['IdEnt'])."€ </div></div>";
    }
    else {
        $scriptPrix ="<div class="."Valeur".">Le montant de cette facture en cours sera de minimum <div class=\"euro\">".calculMontant($fact['IdFacture'],$_SESSION['IdEnt'])."€ </div></div>";
    }
    
    $script=$script."<div class="."Etat"."> Cette facture est ".$fact['Etat']."</div>";
    $script = $script.$scriptPrix;
    $script = $script."</div></div>";
    return $script;
}

//fonction qui calcul le prix d'une voiture en fonction du temps que cette derniers a été louer
function calculMontant($Facture,$ide){
    $scriptInfoP="";
    require_once('modele/factureBD.php');
    require_once('modele/voitureBD.php');
    $date = getDateF($Facture);
    $DateD = $date['DateD'];
    $DateF= $date['DateF'];
    if(empty($DateF)){
        $DateF= date('yy-m-d');
    } 
    get_VoituresLouer($ide,$nbV);
    if($nbV>=10) {
        $scriptInfoP= (NbJours($DateD,$DateF)* getPrix($Facture));
        $scriptInfoP= $scriptInfoP - ($scriptInfoP*(10/100));
    }
    else{
        $scriptInfoP = NbJours($DateD,$DateF) * getPrix($Facture);
    }
    return number_format((float) $scriptInfoP, 2, ',', ' ');
}

?>