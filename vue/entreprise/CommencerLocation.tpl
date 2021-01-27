<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <title>Location</title>
  <link rel="stylesheet" href="vue/styleCSS/page/CommencerLocation.css">
</head>

<body>

<h1> Location d'un véhicule </h1> 

<form action="index.php?controle=entreprise&action=louer" method="post">
    <p class="text-center">Voici les véhicules disponibles à la location</p>
    <div class="Script"> <?php echo $voitures; ?> </div>
  
    <div class="formulaire">  
    <p class="titre">Quel voiture souhaitez-vous louer ?</p>
        <div class="search_categories"> 
            <div class="listeD">
            <select name="choixVoiture" required>
                <option value="" disabled selected hidden>Choissisez une voiture</option>
                <?php echo $liste ?>
            </select>
            </div>
        </div>
    <div class="info">
        <label for="df">Date de fin de location<em> (optionnel)</em></label>
        <div class="grid-df"> 
            <input name="df"  min="<?php echo date('yy-m-d') ?>"	type="date" id ="df">
        </div>
        <div class="grid-contrat">
            <input type="checkbox" class ="ckContrat"id="contrat" name="contrat">
            <div class="img-contrat">
                <a href="src/contrat/Contrat-de-location.html" target="_blank">
                    <img id="img-contrat" src="src/contrat /iconContrat.png" alt="Icon contrat"/>
                </a>
            </div>
            <label class="text-contrat" for="contrat">J'ai pris connaissance du contrat de location.</label> 
        </div>
    </div>
        <div class="button-end">
            <input type="button" id="Bretour" value="Annuler" onclick="history.go(-1)">
            <input name="submit" id="Bvalider" type= "submit"  value="Confirmer ">
         </div>
    </div>
</form>
</div>
</body></html>
