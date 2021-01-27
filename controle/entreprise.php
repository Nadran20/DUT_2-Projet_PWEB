<?php
//fonction  permet a une entrepise de se connecter 
    function connexion(){
        require_once ('modele/entrepriseBD.php');
        $nom=  isset($_POST['nom'])?($_POST['nom']):'';
        $mdp=  isset($_POST['mdp'])?($_POST['mdp']):'';
        $msg='';

        if  (count($_POST)==0){
            $msg = "";
            require ("vue/utilisateur/connexion.tpl") ;
        }
        else {
            $profil = array();
            if  (!verif_ident($nom,sha1($mdp),$profil)) {
                $msg ="Nom ou Mot de passe incorrect";
                erreurMsg($msg);
                require ("vue/utilisateur/connexion.tpl");
            }
            else { 
                $_SESSION['IdEnt']= $profil['IdEnt'];
                $nexturl = "index.php?controle=entreprise&action=accueil";
				header("Location:" . $nexturl); // On retourne à la page index !!!
            }
        }	
    } 
//fonction qui permet de créer une nouvelle entreprisese grace au tpl inscription.tpl
    function inscription(){
        require_once('modele/entrepriseBD.php');
        $nom = isset($_POST['nom'])?($_POST['nom']):'';
        $mdp = isset($_POST['mdp'])?($_POST['mdp']):'';
        $email = isset($_POST['email'])?($_POST['email']):'';
        $type = isset($_POST['choix'])?($_POST['choix']):'';
        $msg='';
        if  (count($_POST)==0)
            require ('vue/utilisateur/inscription.tpl') ;
        else {
            $profil = array();
            if(filter_var($email, FILTER_VALIDATE_EMAIL)!='false');
                if(!verif_ident_Inscription($nom,$email,$type,$profil)){
                    if(!empty($nom) && !empty($mdp) && !empty($email) && !empty($type)){
                        if (newInscrit($nom,sha1($mdp),$email,$type,$profil)) {
                            $_SESSION['IdEnt']= $profil;
                            $nexturl = "index.php?controle=entreprise&action=accueil";
				            header("Location:" . $nexturl); // On retourne à la page index !!!
                        }
                    }
                    else { 
                        $msg ="Erreur de saisie";
                        erreurMsg($msg);
                        include ('vue/utilisateur/inscription.tpl') ;
                    }
                }
                else {
                    $msg = 'Utilisateur déjà inscrit';
                    erreurMsg($msg);
                    require ('vue/utilisateur/inscription.tpl') ;	
                }
            }
    }	

    //fonction qui engendre la location d'une voiture par l'entreprise //fonction qui permet a une entreprise loueuse de louer un véhicule et de créer une facture 
    function louer(){
        //creation facture
        require_once ('controle/facture.php');
        require_once ('controle/voiture.php');
        $voitures = "";
        $nbLouable = 0;
        $ListeId = get_LocationsDispo($nbLouable);
        if($nbLouable>0) {
            $liste = scriptListDeroulIdVoiture($ListeId);
            $voitures = $voitures.afficherListeVoitures($ListeId, true);
            if(count($_POST)==0){
                require ('vue/entreprise/CommencerLocation.tpl');
            }
            else{
                if (!isset($_POST['contrat'])) 
                {
                    $msg='Vous devez lire et accepter les termes du contrat de location !';
                    warning($msg);
                    require ("vue/entreprise/CommencerLocation.tpl");
                }
                else 
                {
                    $IdV = $_POST['choixVoiture'];
                    require_once ('modele/voitureBD.php');
                    creationFacture($_SESSION['IdEnt'],get_Propriétaire($IdV), $IdV, $_POST['df']);
                    setEnLocation($IdV, $_SESSION['IdEnt']);
                    
                }
            }
        }
        else
        {
            AucuneVoitureDispo();
        }
}
//fonction pour stopper une location 
//fonction qui permet a une entreprise d'arreter de louer un véhicule tout en initiant le payement d'une voiture
    function arreterLouer(){
    $msg ='';
    $nbV = 0;
    require_once ('modele/voitureBD.php');
    $ListeId = get_VoituresLouer($_SESSION['IdEnt'], $nbV);
    if ($nbV == 0) {
        AucuneVoitureEnLocation();
    }
    else {
        require_once ('controle/voiture.php');
        $voitures = "<p class=\"text-center\">Voici les véhicules que vous louez actuellement</p>";
        require_once('modele/voitureBD.php');
        $voitures = $voitures.afficherListeVoitures($ListeId, true);
        $scriptVoiture = scriptListDeroulIdVoiture($ListeId);
        if (count($_POST)==0) { 
            require ("vue/facture/choixVoiture.tpl");
        }
        else
        {   
            require_once ('modele/factureBD.php');
            require_once ('modele/voitureBD.php');
            require_once ('controle/facture.php');
            $_SESSION['IdV'] = $_POST['IdV'];
            $IdL = get_Propriétaire($_SESSION['IdV']);
            $IdFacture = getFacture($_SESSION['IdEnt'], $_SESSION['IdV']);
            $_SESSION['IdFacture'] = $IdFacture;
            $scriptInfoP = calculMontant($IdFacture,$_SESSION['IdEnt']);
            $annéeMin = DATE('yy');
            $annéeMax = $annéeMin +5;
            require ('vue/facture/Paiement.tpl');
        } 
    }
}


    //fonction qui renvoie le bon tpl suivant le type de l'entreprise connecté
    function accueil(){
        if(strcmp(get_Type(), "Entreprise")==0){
            accueilEntreprise();
        }
        if(strcmp(get_Type(), "Loueur")==0){
            accueilLoueur();
        }
    }

    //génération de l'accueil de la page entreprise    
    //fonction permettant d'afficher l'accueil  entreprise pour une entreprise non-loueuse
    function accueilEntreprise(){
        $IdE = $_SESSION['IdEnt'];
        //script1 flotte de véhicule loué auprès des loueurs
        $script1 = '';
        //get les voitures que $_session ident *
        $nbV= 0;
        require_once('modele/voitureBD.php');
        $ListId = get_VoituresLouer($IdE,$nbV);
        require_once ('controle/voiture.php');
        if($nbV>=1){
            $script1 = "<p class=\"text-center\"> Voici la liste des véhicules que vous louez actuellement.</p>".
            afficherListeVoitures($ListId, false);
        }
        elseif($nbV==0){
            $script1 = '<div class="my-notify-info"> Vous ne louez aucune voiture actuellement.</div>';
        }
        require ('vue/entreprise/Accueil.tpl');
    }

    //génération de l'accueil de la page loueur    }
    //fonction permettant d'afficher l'accueil d'une entreprise loueuse
    function accueilLoueur(){
    require_once('modele/entrepriseBD.php');
    $listId1='';
    $nbVdispo =0;
    $listId1 = get_VoituresLoueurDispo($nbVdispo, $_SESSION['IdEnt']);
    require_once ('controle/voiture.php');
    $script1 = ''; 
    if($nbVdispo>=1){
        $script1 = $script1.afficherListeVoitures($listId1, false);
    }
    elseif($nbVdispo==0){
        $script1 = '<div class="my-notify-info"> Votre stock est vide. </div>';
    }
    $listId2 = get_VoituresLoueurNonDispo($nbVnonDispo,$_SESSION['IdEnt']);
    if($nbVnonDispo>=1){

        $script2 = $script2."<div class=\"loue\">".afficherListeVoitures($listId2, false)."</div>";
    }
    elseif($nbVnonDispo==0){
        $script2 = '<div class="my-notify-info"> Personne ne vous loue de véhicule pour le moment.</div>';
    }

    $nbVRevision =0;
    $script3 = '';  
    $listId3 = get_VoitureLoueurRevision($nbVRevision,$_SESSION['IdEnt']);
    if($nbVRevision>=1){
        $script3 = $script3."<div class=\"revision\">".afficherListeVoitures($listId3, false)."</div>";
    }
    elseif($nbVRevision==0){
        $script3 = '<div class="my-notify-info"> Aucune voiture en révision. </div>';
    }

    require ('vue/loueur/Accueil.tpl');
    }

    // fonction qui permet a un loueu de retirer une voiture 
    function retirerStock(){
        require_once ('controle/voiture.php');
        $script1 = '';
        $script2 = '';
        if(!retirerVoiture($script1, $script2)){
            $message ="Vous n'avez aucune voiture, vous ne pouvez pas en retirer de votre stock";
            include('vue/message/erreurMess.tpl');
            accueil();
        }
        else{
            if (count($_POST)==0){
                require ('vue/loueur/SuppressionRevision.tpl');
            }
            else{
                $choix = $_POST['choix'];
                $IdV = $_POST['IdV'];
                if(strcmp($choix, "supprimer")==0){
                    if (unsetVoiture($IdV)) {
                        VoitureSupprimé();
                    }
                }
                elseif(strcmp($choix, "revision")==0){
                    if(setVoitureRevision($IdV)){
                        VoitureEnRevision();
                    }
                }
            }
            
        }
    }
    //fonction pour passer une voiture "en_revision" à disponible
    function setDispo(){
        require_once ('controle/voiture.php');
        $scriptAffichage='';
        $scriptIdVoiture='';
        if(!revisionToDispo($scriptAffichage, $scriptIdVoiture)){
            AucuneVoitureEnRevision();
        }
        else
        { 
            if(count($_POST)==0){
                revisionToDispo($scriptAffichage, $scriptIdVoiture);
                require ('vue/loueur/TerminerRevision.tpl');
            }
            else
            {
            $IdV = $_POST['IdV'];
            setVoitureDispo($IdV);
            VoitureAjoutéAuStock();
            }
        }
    }

    //fonction qui permet d'afficher les résumés factures 
    function ResumeFacture(){
        require_once ('controle/facture.php');
        $scriptRF='';
        if(listFacture($scriptRF)){
            require ('vue/Loueur/Factures.tpl');
        }
        else
        {
            noFacture();
        }
    }

    //fonction qui affiche le tpl permettant d'ajouter une voiture a la location
    function ajoutVoiture(){
        require_once ('controle/voiture.php');
        addVoiture();
    }

    //fonction qui renvoie le type de l'entreprise qui vient de se connecter(Loueur ou entreprise)
    function get_Type(){
        require_once ("modele/entrepriseBD.php");
        $types = get_TypeEntreprise($_SESSION['IdEnt']);
        return $types;
    }

    //fonction qui permet d'afficher les factures avec une date dépasser et qui sont impayé
    function reglerFactureE() {
        require_once('controle/facture.php');
        reglerFactureFini();
    }

    //fonction qui est appelé dans le cas où aucune voiture est en révision
    function AucuneVoitureEnRevision(){
            $message = "Vous n'avez aucune voiture en révision";
            include ('vue/message/erreurMess.tpl');
            accueil();
    }

    //fonction qui est appelé dans le cas où aucune voiture est en location
    function AucuneVoitureEnLocation(){
        $message = "Vous ne louez aucune voiture, vous n'avez donc aucune facture à payer";
        include ('vue/message/erreurMess.tpl');
        accueil();
    }

    //fonction qui est appelé dans le cas où aucune facture est disponible
    function AucuneFactureDispo(){
        $message = "Vous n'avez aucune facture fini à régler";
        include ('vue/message/erreurMess.tpl');
        accueil();
    }

    //fonction qui est appelé dans le cas où aucune voiture est disponible
    function AucuneVoitureDispo(){
        $message = "Aucune voiture n'est disponible à la location pour le moment";
        include ('vue/message/erreurMess.tpl');
        accueil();
    }

    //fonction qui est appelé dans le cas où une voiture vient d'etre louer et qu'elle a bien été mise a jour dans la base de donnée
    function VoitureLoué(){
        $message = "Merci de votre location !";
        include ('vue/message/messageSucces.tpl');
        accueil();
    }
    //fonction de message qui s'affiche aprés avoir arrêter une location avec succes 
    function VoitureLouéFin(){
        $message = "Merci d'avoir loué un véhicule chez nous, à bientot !";
        include ('vue/message/messageSucces.tpl');
        accueil();
    }
    //fonction de message qui s'affiche aprés avoir mis une voiture en révision avec succes 
    function VoitureEnRevision(){
        $message = "en révision";
        include ('vue/message/VoitureBDD.tpl');
        accueil();
    }   
    //fonction de message qui s'affiche aprés avoir supprimer une voiture  avec succes 
    function VoitureSupprimé(){
        $message = "supprimé";
        include ('vue/message/VoitureBDD.tpl');
        accueil();
    }
    //fonction de message qui s'affiche aprés avoir ajouter une voiture avec succes 
    function VoitureAjoutéAuStock(){
        $message = "ajouté au stock";
        include ('vue/message/VoitureBDD.tpl');
        accueil();
    }

    //fonction de message qui s'affiche lors de l'ajout d'une image si l'image est déja présent
    function ImageWarning(){
        $message=$_SESSION['msg'];
        include('vue/message/warning.tpl');
        VoitureAjoutéAuStock();
    } 
    //fonction de message qui s'affiche lors de l'ajout d'une image avec succes
    function ImageOk(){
        $message=$_SESSION['msg'];
        include('vue/message/messageSucces.tpl');
        VoitureAjoutéAuStock();
    }
     //fonction de message qui affiche une notification warning selon la situation
    function warning($msg){
        $message=$msg;
        include('vue/message/warning.tpl');    
    } 
    //fonction de message qui affiche une notification erreur dans un cas non-préciser
    function erreur(){
        include('vue/message/erreur.tpl');
        accueil();     
    } 
    //fonction de message qui s'affiche après le payement réussir d'un paiement 
    function FacturePayé(){
        $message ="payé";
        include('vue/message/FactureBDD.tpl');
        accueil();
    }
    //fonction de message qui s'affiche après la détéction d'une erreur 
    function erreurMsg($msg){
        $message=$msg;
        include('vue/message/erreurMess.tpl');
    }
    //fonction de message qui s'affiche lorsque une entrepise chercher arrêter une location alors que ne possede aucune location
    function noFacture(){
        $message ="Vous n'avez encore loué aucune voiture";
        include('vue/message/erreurMess.tpl');
        accueil();
    }
    //fonction qui permet de nettoyer la variable session et qui ramène a l'acceuil non connecté
    function Deconnexion(){
        unset($_SESSION['IdEnt']);
        $nexturl = "index.php";
		header("Location:" . $nexturl); // On retourne à la page index !!!
    }
?>