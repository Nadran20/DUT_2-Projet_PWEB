<html>
    <head>
        <meta charset="utf-8">
        <!-- importer le fichier de style -->
        <title>Paiement de la facture</title>
        <link rel="stylesheet"  media="screen" type="text/css" href="vue/styleCSS/page/paiement.css" />
    </head>
<h1>Paiement de la facture</h1>
  
<form class="formulaire" action="index.php?controle=facture&action=payé" method="post">
<div class="infoCarte">
  <div class="grid">
  <label>NOM DU TITULAIRE</label>
  <input type="text" pattern="^[a-zA-Z\s]*" placeholder="Nom Prenom" required>
  </div>

  <div class="grid">
  <label for="NumCarte">NUMERO DE CARTE</label>
  <input type="text" minlength="16" maxlength="16" pattern="^[0-9]{16}" placeholder="n° de carte à 16 chiffres" id="NumCarte" name="NumCarte" required>
  </div>

<div class="dateGrid">
  <label id="labelDate" for="DateExpMonth">DATE D'EXPIRATION</label>
  <div class="MonthYear">
  <input type="number" id="month" min= "01" max="12" step="01" value="1" placeholder="mois" id="DateExpMonth" name="DateExpMonth" required>
  <input type="number" id="year" min= "<?php echo $annéeMin ?>" value=<?php echo $annéeMin ?> placeholder="année"  max="<?php echo $annéeMax ?>" id="DateExpYear" name="DateExpYear" required>
</div></div>
<div class="grid">
  <label for="CVV"> CVV </label>
  <input id="CVV" type="password"  maxlength=3 pattern="[0-9]{3}"  id="CVV" name="CVV" required>
</div>
<div class="flex">
  <input type="checkbox" disabled id="save" name="save">
  <label id="joke" for="save">Enregistrer les informations de la carte</label>
</div>
<div class="montant">
  <label id="prix" for="Payer"> Montant à payer: <?php 
  echo $scriptInfoP;?>€ <label>
</div>
<div class="button-end">
  <input id="Bvalider" type="submit" value="Payer">
</div>
</div>
</form>
</html>