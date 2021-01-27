<html>
    <head>
       <meta charset="utf-8">
        <!-- importer le fichier de style -->
        <link rel="stylesheet" href="vue/styleCSS/page/index.css">
    </head>
    <body>
        <div class="formulaire">
        <h2 class="titre">Bienvenue</h2>
            <div class="choix">
                <form action="index.php?controle=entreprise&action=connexion" id="f-c" method="post">
                    <input type ="submit" id="b-connexion" value="se connecter"></form>
                <form action="index.php?controle=entreprise&action=inscription" id="f-i" method="post">
                    <input type ="submit" id="b-inscription" value="s'inscrire"></button></form>    
            </div>
        </div>
</html>