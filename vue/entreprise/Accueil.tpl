<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="vue/styleCSS/page/entreprise.css">
  <title>Service Entreprise</title>
</head>
<header>
<h1> Bienvenue dans votre Espace Entreprise </h1> 
<ul>
  <li>
  
<form action="index.php?controle=entreprise&action=louer" method="post">
<input id="input-louerVoiture" type="submit" value="Louer un véhicule"></form>

  </li>
  <li>

<form action="index.php?controle=entreprise&action=arreterLouer" method="post">
<input id="input-stopLocation" type="submit" value="Arrêter de louer un véhicule"></form>

  </li>
  <li>

<form action="index.php?controle=entreprise&action=reglerFactureE" method="post">
<input id="input-stopLocation" type="submit" value="Payer une facture"></form>

  </li>
  <li>
  
<form action="index.php?controle=entreprise&action=Deconnexion" method="post">
<input id="input-Deconnexion" type="submit" value="Déconnexion"></form>
  
  </li>
</ul>
</header>
<body>

<div class="Script" id ="ListeVéhicules"> 
<?php  echo $script1; ?> 
</div> 
</div>
</body></html>
