<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Gestionnaire des voitures</title>
    <link rel="stylesheet" href="vue/styleCSS/page/SuppressionRevision.css">
</head>

<body>
<h1> Retirer une voiture du stock disponible</h1> 
<form action="index.php?controle=entreprise&action=retirerStock" method="post">

    <div class="Script" id ="ListeVéhicules"> 
        <p class="text-center" id="infoForm"> Voici les voitures que vous pouvez retirer: </p>
        <?php echo $script1; ?> 
    </div> 
    <div class="formulaire">
        <div class="search_categories">
            <div class="listeD">
            <select name="IdV" required>
                <option value="" disabled selected hidden>Choissisez une voiture</option>
                <?php echo $script2 ?>
            </select>
        </div>
    </div>

    <label for="suppr" class="radio"> 
        <span class="radio__input"> 
            <input name="choix" class="hide" id="suppr" type="radio" value="supprimer" checked="checked"> 
            <span class="radio__control"></span>
            </span>
        </span>
        <span class="radio__label">Supprimer définitivement</span>
        </span>
    </label>

    <label for="rev" class="radio"> 
        <span class="radio__input">
            <input class="hide" name="choix" id="rev" type="radio" value="revision"> 
            <span class="radio__control"></span>
        </span>
        <span class="radio__label">Mettre en Révision</span>
    </label>

    <div class="button-end">
      <input type="button" id="Bretour" value="Annuler" onclick="history.go(-1)">
      <input type= "submit" id="Bvalider" value="Valider">
    </div>
  </div>
</div>
</form>
</body>
</html>
