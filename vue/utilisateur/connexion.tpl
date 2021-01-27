<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <title>Connexion</title>
  <link rel="stylesheet" href="vue/styleCSS/page/connexion.css">
</head>

<body>
<form action="index.php?controle=entreprise&action=connexion" method="post">
<div class="formulaire">
  <h2 class="titre"> Connexion</h2> 
  <div class ="contenu">
    <div class="nom">
        <label for="nom">     Nom de l'entreprise   </label>  
        <input name="nom" placeholder="Nom de l'entreprise" type="text" 
        value= "<?php echo($nom); ?>" id = "nom"/>
    </div>
    <div class ="mdp">
      <label for="mdp">       Mot de passe    </label>
      <input  name="mdp" placeholder="Mot de passe" type="password" minlength="4"
        value= "<?php echo($mdp); ?>" id = "mdp" />
    </div>	 
    <div class = "button-end">
        <input type="button" id="Bretour" value="Retour" onclick="history.go(-1)">	 
        <input type= "submit"  id="Bvalider" value="Connexion">
      </div>
    </div>
  </div>
</div>
</form>
</body></html>
