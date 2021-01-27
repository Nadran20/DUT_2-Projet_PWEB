
<!doctype html>
<html>
<head>
<link rel="stylesheet" href="vue/styleCSS/page/AjoutLocation.css">
<title> Ajout d'une voiture </title>
</head>
<body>
    <h1>Descriptif voiture</h1>
    <form action="index.php?controle=entreprise&action=ajoutVoiture" method="post" enctype="multipart/form-data">

    
    <p class="text-center" id="infoForm">Saisissez les champs</p>
<div class="formulaire">
<p class="titre"> Formulaire d'ajout<p>
    <div class="NomV">
        <div class="champs">
            <label id="LabNom" for="nom">Nom de la voiture</label>
            <input class="inputNom" type="text" placeholder="Nom de votre vehicule" name="nomV" id="Nom" required>
        </div>
    </div>
    <div class="carac">
        <p  id="lvit">Boîte de vitesses</p>
            <label for="auto" class="radio"> 
                <span class="radio__label">Automatique</span>
                <span class="radio__input"> 
                    <input name="vitesse" class="hide" value="automatique" id="auto" type="radio" required> 
                    <span class="radio__control"></span>
                </span>
            </label>
            <label for="manu" class="radio"> 
                <span class="radio__label">Manuelle</span>
                <span class="radio__input">
                    <input name="vitesse" class="hide" id="manu" type="radio"value="manuelle" required> 
                    <span class="radio__control"></span>
                </span>
            </label>
    </div>
    <div class="carac">
        <p  id="lcar">Carburant</p>
            <label for="esse" class="radio"> 
                <span class="radio__label">Essence</span>
                <span class="radio__input"> 
                    <input name="carburant" class="hide" id="esse" type="radio" value ="essence" required> 
                    <span class="radio__control"></span>
                </span>
            </label>
            <label for="dies" class="radio"> 
                <span class="radio__label">Diesel</span>
                <span class="radio__input"> 
                    <input name="carburant" class="hide" id="dies" type="radio" required value="diesel"> 
                    <span class="radio__control"></span>
                </span>
            </label>
    </div>    
    <div class="Dprix">
        <div class="champs">
            <label  for="fPrix" >Prix (par jour)</label>
            <div class="inputPrix input-icon">
                <i>€</i>
                <input class="inPrix" pattern=[0-9]* maxlength="6" placeholder="0.00" type="text" id="fPrix" name="fPrix" required>
            </div>   
        </div>    
    </div>
    <div class="container">
        <div class="button-wrap">
            <label class="button" for="upload">Déposez l'image ici</label>
            <input  type="file" id="upload" accept="image/*" name="fileselect" required>
        </div>
    </div>
    <div class = "button-end">	
        <input  id="Bretour" type="button" value="Annuler" onclick="history.go(-1)">
        <input  id='Bvalider' type="submit" value="Ajouter">
    </div>
</form>
</div>
</body>
</html>