<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Service Loueur</title>

    <link rel="stylesheet" href="vue/styleCSS/page/loueur.css">
</head>
<header>
<h1> Bienvenue dans votre Espace Loueur </h1> 
<ul>
  <li>
  

<form id="bprem" action="index.php?controle=entreprise&action=ajoutVoiture" method="post">
<input id="bajouter" type="submit" value="Ajouter une voiture au stock"></form>

  </li>
  <li>

<form action="index.php?controle=entreprise&action=setDispo" method="post">
<input id="brev" type="submit" value="Ajouter une voiture depuis les révisions"></form>

  </li>
  <li>

<form id="bsecond" action="index.php?controle=entreprise&action=retirerStock" method="post">
<input id="bretirer" type="submit" value="Retirer une voiture du stock"> 
</form>

  </li>
  <li>

<form id="blast" action="index.php?controle=entreprise&action=resumeFacture" method="post">
<input id="bfacture"  value=" Afficher l'aperçu des factures de vos clients" type="submit"> 
</form>
  </li>

  <li>
  
<form action="index.php?controle=entreprise&action=Deconnexion" method="post">
<input id="input-Deconnexion" type="submit" value="Déconnexion"></form>
  
  </li>
  
</ul>
</header>
<body>
<div class="Script" id ="ListeVéhicules"> 
<p class="text-center"> Voici votre stock</p>
<?php echo $script1; ?> 
</div> 

<p class="text-center"> Voici les voitures que d'autres entreprises vous loue actuellement</p>
<div class = "Script" id ="LocEnCours"> 
<?php echo $script2; ?> 
</div>

<div class = "Script" id ="ListeRévision"> 
<p class="text-center"> Voici vos voitures en révision</p>
<?php echo $script3; ?> 
</div>

</body>
</html>
