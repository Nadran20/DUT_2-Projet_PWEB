
<!doctype html>
<html lang="fr">

    <head>
        <meta charset="utf-8">

        <link rel="stylesheet" href="vue/styleCSS/page/ChoixVoiture.css">
    </head>

    <body>

        <h1>Reglement Facture</h1>
        <div class="Script" id ="Véhicule"> <?php echo $voitures; ?> </div>

        <form class="formulaire" action="index.php?controle=entreprise&action=arreterLouer" method="post">
            <label class="titre" for="choixFacture">Quelle voiture voulez vous arreter de louer ?</label>
            <div class="search_categories">
                <div class="listeD">
                <select required name="IdV" selected>
                    <option value="" disabled selected hidden>Choissisez une voiture</option>
                    <?php echo $scriptVoiture ?>
                </select>
            </div>
        </div>
            <div class = "button-end">
                <input type="button" id="Bretour" value="Annuler" onclick="history.go(-1)">
                <input type="submit" id="Bvalider" value="Valider">
            </div>
        </form>
    </body>
</html>