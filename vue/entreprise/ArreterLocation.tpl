
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Fin de location</title>
    <link rel="stylesheet" href="vue/styleCSS/page/formulaire.css">
</head>  

<html>
    <h1>Régler une facture</h1>
    <div class="formulaire">
    <form action="index.php?controle=entreprise&action=arreterLouer" method="post">
        <div class="search_categories"> 
            <div class="listeD">
            <select name="choixVoiture" required>
                <option value="" disabled selected hidden>Choissisez une voiture</option>
                <?php echo $scriptVoiture ?>
            </select>
            </div>
        </div>
        <div class = "button-end">	 
            <input type="button" id="Bretour" value="Annuler" onclick="history.go(-1)">
            <input type="submit" id="Bvalider" value="Valider">
        </div>
    </div>
    </form>  
</html>
