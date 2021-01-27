
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="vue/styleCSS/page/inscription.css">
</head>

<body>
<form action="index.php?controle=entreprise&action=inscription" method="post">
<div class="formulaire">
    <h2 class="titre"> Inscription </h2>
    <div class ="contenu">
        <div class="nom">
            <label for="nom">     Nom de l'entreprise   </label>  
            <input name="nom" type="text" minlength="4" placeholder="Nom" value="<?php echo($nom); ?>" required>
        </div>  
        <div class="email">                                                                            
            <label for="email">     Email de l'entreprise   </label>
            <input name="email" placeholder="Email de l'entreprise" type="text"  value="<?php echo($email) ?>" required>
        </div>
        <div class ="mdp">
            <label for="mdp">       Mot de passe    </label>
            <input  name="mdp" placeholder="Mot de passe" type="password" minlength="4"
            value= "<?php echo($mdp); ?>" id = "mdp" required>
        </div>	
        <div class="choix">
            <label for="inLo" class="radio"> 
            <span class="radio__label">Entreprise</span>
                <span class="radio__input"> 
                    <input name="choix" class="option" id="inLo" type="radio" value="Entreprise" checked="checked"> 
                    <span class="radio__control"></span>
                    </span>
                </span>
                
                </span>
            </label>

            <label for="inEn" class="radio"> 
            <span class="radio__label">Loueur</span>
                <span class="radio__input">
                    <input class="option" name="choix" id="inEn" type="radio" value="Loueur"> 
                    <span class="radio__control"></span>
                    </span>
            </label>
        </div>
        <div class="button-end">	 
            <input type="button" id="Bretour" value="Retour" onclick="history.go(-1)">	 
            <input type= "submit"  id="Bvalider" value="Inscription">
        </div>
    </div>
</div>
</form>
</body>
</html>