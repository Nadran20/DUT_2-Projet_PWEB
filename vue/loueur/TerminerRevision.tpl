
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Retour d'une voiture</title>
    <link rel="stylesheet" href="vue/styleCSS/page/TerminerRevision.css">
</head>
<body>
<h1>Réintégrer une voiture au stock sortant de révision</h1>
<div class="revision"><?php echo $scriptAffichage ?></div>
<form class="formulaire" action="index.php?controle=entreprise&action=setDispo" method="post">
    <label class="titre" for="voiture">Veuillez choisir la voiture qui sort de révision</label>
    <div class="search_categories">
        <div class="listeD">
            <select id="listeVoiture" required name="IdV">
            <option value="" disabled selected hidden>Choisissez une voiture</option>
                <?php echo $scriptIdVoiture ?>
            </select>
        </div>
    </div>
    <div class="button-end">
        <input type="button" id="Bretour" value="Annuler" onclick="history.go(-1)">
        <input type= "submit" id="Bvalider" value="Valider">
    </div>
</form>
</body>
</html>