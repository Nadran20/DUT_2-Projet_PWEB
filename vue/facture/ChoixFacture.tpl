
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="vue/styleCSS/page/ChoixFacture.css">
    <title>Quel facture souhaitez vous régler ?</title>
</head>

<html>
    <h1>Reglement Facture</h1>
    <form class="formulaire" action="index.php?controle=facture&action=reglerFactureFini" method="post">
        <label class="titre" for="choixFacture">Veulliez choisir une facture à régler</label><br>
        <div class="search_categories">
            <div class="listeD">
        <select name="choixFacture">
            <option value="" disabled selected hidden>Choisisez une facture</option>
            <?php echo $scriptFacture ?>
        </select><br>
            </div>
        </div>
        <div class = "button-end">
            <input type="button" id="Bretour" value="Annuler" onclick="history.go(-1)">
            <input type="submit" id="Bvalider" value="Valider">
        </div>
    </form>
</html>