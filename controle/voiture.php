<?php
//renvoie le script de l'affichage des voitures grace a la liste d'IdVoiture en paramètre
//Si $AvecId=true on affiche les voitures avec leur Id 
function afficherListeVoitures($listeId, $AvecId){
    $voitures = array();
    $script = '';
    $script = $script."<div class="."Voitures".">";
    foreach($listeId as $idV) {
        $script = $script.afficherVoiture($idV['IdVoiture'], $AvecId);
    }
    $script = $script."</div>";
    return $script;
}
//fonction qui crée un script html affichant l'image,le nom,les caracterisiques d'une voiture passé en id,avecId est un boolean qui permet si true de montrer l'id de la voiture 
function afficherVoiture($IdVoiture, $AvecId){
    require_once ('modele/voitureBD.php');
    $infoVoiture = infoVoiture($IdVoiture);
    $script = '<div class="Voiture"><img class="imgVoiture" src="'
    .$infoVoiture['photo'].'" alt="'
    .$infoVoiture['NomVoiture'].'" /><div class="NomVoiture">'
    .$infoVoiture['NomVoiture'].'';
    if($AvecId) {
        $script = $script. ' n°'.$IdVoiture.'';
    }
    $script = $script.'</div><div class ="CaracVoiture">
    <em><u>Description:</u></em> Véhicule à moteur ' 
    .$infoVoiture['moteur'].' avec une boîte de vitesse '
    .$infoVoiture['vitesse'].'.</div></div>';
    return $script;
}
//permet d'obtenir la liste de tout les voitures
function get_LocationsDispo(&$nbVoiture){
    require_once ('modele/voitureBD.php');
    $Voiture = get_IdLouable($nbVoiture);
    return($Voiture);
}
//si des voitures sont disponibles les affiches sinon envoi un message
function afficherLocations(){
    $ListeLouable = get_LocationsDispo($nbLouable);
    if($nbLouable==0){
        $locations='<div class="my-notify-info">Victime de son succès, notre site n\'\a aucune location à proposer, revenez plus tard !</div>';
    }
    else{
    $locations = afficherListeVoitures($ListeLouable, false);
    }
    require ('vue/voitures/Catalogue.tpl');
}

//on crée un script, une liste déroulante des id des véhicules
function scriptListDeroulIdVoiture($liste) { 
    $script = '';
    foreach($liste as $voiture) {
        $script = $script ."<option value=".$voiture['IdVoiture'].">".$voiture['NomVoiture']." n° ".$voiture['IdVoiture']."</option>";
    }
    return $script;
}

//
function setEnLocation($idv, $ide){
    require_once ('modele/voitureBD.php');
    putAsRented($idv, $ide);
    $nexturl = "index.php?controle=entreprise&action=VoitureLoué";
    header("Location:" . $nexturl); 
}

//fonction de controle qui permet de retirer une voiture du site 
function retirerVoiture(&$script1,&$script2){
    require_once ('modele/voitureBD.php');
    $liste=''; 
    $liste = getVoitureDispoLoueur($_SESSION['IdEnt'], $nbVoiture);
    if($nbVoiture==0){
        return false;
    }
    else {
        $script1 = afficherListeVoitures($liste, true); 
        $script2 = scriptListDeroulIdVoiture($liste);
        return true;
    }
}
//
function revisionToDispo(&$scriptAffichage, &$scriptIdVoiture){
    require_once ('modele/voitureBD.php');
    $IdE = $_SESSION['IdEnt'];
    $nbRevision = getRevision($IdE, $ListeId);
    if($nbRevision >0){
        $scriptAffichage = afficherListeVoitures($ListeId, true);
        $scriptIdVoiture = scriptListDeroulIdVoiture($ListeId);
        return true;
    }
    else {
        return false;
    }

}

//ajout de l'image dans le fichier src du site
function ajouterImage ($target_dir) {
    $target_file = $target_dir . basename($_FILES["fileselect"]["name"]);
    //on initialise la variable update ok
    $uploadOk = 1;
    //on recup l'extention du fichier
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    //on a cliqué sur le bouton qui s'appel submit
    if(isset($_POST["submit"])) {
        //fichier image?
        $check = getimagesize($_FILES["fileselect"]["tmp_name"]);
        if($check !== false) {  
            $uploadOk = 1;
            return false;
        } 
        else 
        {
            $_SESSION['msg'] = "Le fichier n'est pas une image valide.";
            $uploadOk = 0;
            return false;
        }
        if (file_exists($target_file)) {
            $uploadOk=0;
        }
    }    
    // le poid de l'image
    elseif ($_FILES["fileselect"]["size"] > 100000000) 
    {
        $_SESSION['msg'] = "Le fichier selectionné est trop volumineux.";
        $uploadOk = 0;
        return false;
    }
    // les formats autorisés
    elseif($imageFileType != "jpg" &&$imageFileType != "JPG"&& $imageFileType != "png" && $imageFileType != "PNG" && $imageFileType != "jpeg" && $imageFileType != "JPEG" && $imageFileType != "gif" && $imageFileType != "GIF") {
        $_SESSION['msg'] = "Les images doivent etre au format: JPG, JPEG, PNG ou GIF.";
        $uploadOk = 0;
        return false;
    }
    // erreur
    elseif ($uploadOk == 0) {
        $_SESSION['msg']="Erreur! impossible d'ajouter l'image.";
        return false;
    // tt c'est bien passé
    } 
    else 
    {
        if (move_uploaded_file($_FILES["fileselect"]["tmp_name"], $target_file)) {
            $_SESSION['msg'] = "Image ajoutée avec succès.";
                return true;
        } 
        else {
            $_SESSION['msg'] = "Erreur inconnue! Merci de retenter l'ajout plus tard ou de contacter l'administrateur.";
            return false;
        }
        } 
    }

//verifie si une image existe déja , si oui affiche un message
function verifImage($tag) {
    if (file_exists($tag . basename($_FILES["fileselect"]["name"]))) {
        $_SESSION['msg'] = "Attention ! le fichier image existait déjà, il n'a pas été remplacé.";
        return true;    
    }
    else{
        return false; 
    }         
}

//on ajoute une voiture au stock du loueur connecté
function addVoiture(){
    $n= isset($_POST['nomV'])?($_POST['nomV']):'';
    $idE=isset($_SESSION['IdEnt'])?($_SESSION['IdEnt']):'';
    $moteur=isset($_POST['carburant'])?($_POST['carburant']):'';
    $vitesse=isset($_POST['vitesse'])?($_POST['vitesse']):'';  
    $prix=isset($_POST['fPrix'])?($_POST['fPrix']):'';
    if (count($_POST)==0)
        require ("vue/loueur/AjouterLocation.tpl") ;
    else {
        if(!empty($_POST)){ 
            require_once ("modele/voitureBD.php");
            $target_dir = "src/voitures/";
            if(ajouterVoiture($idE, $n, $moteur, $vitesse, $prix,$target_dir)){
                if(verifImage($target_dir)) {
                    $nexturl = "index.php?controle=entreprise&action=ImageWarning";
                    header("Location:" . $nexturl); // On retourne à la page index !!!
                }
                else{
                    if(ajouterImage($target_dir)){
                        $nexturl = "index.php?controle=entreprise&action=ImageOk";
                        header("Location:" . $nexturl); // On retourne à la page index !!!
                    }
                }
            }
            else{        
                $nexturl = "index.php?controle=entreprise&action=erreur";
                header("Location:" . $nexturl); // On retourne à la page index !!!
            }
        } 
        else { 
            $nexturl = "index.php?controle=entreprise&action=erreur";
            header("Location:" . $nexturl); // On retourne à la page index !!!
        }
    }
}
?>