<?php

	$hostname = "localhost";	//ou localhost
	$base= "BDDLocation";
	$loginBD= "root";	//ou "root"
	$passBD="root";
	//$pdo = null;

try {

	$pdo = new PDO ("mysql:server=$hostname; dbname=$base", "$loginBD", "$passBD");
	//die('OK connexion');
}

catch (PDOException $e) {
	die  ("Echec de connexion : " . utf8_encode($e->getMessage()) . "\n");
}

///////////////////////////////////////////
//Voici 2 lignes pour tester la connexion seule, en invoquant ce fichier.
//   Eliminer ces 2 lignes si le test est réussi !

//		$ok = 'connexion ok';
//		die ($ok); 




/********************************************************
Ancienne ecriture plus directe pour mysql mais pas polymorphe
if (! isset ($link)) {


$link = mysqli_connect($hote, $login, $pass) 
		or die ("erreur de connexion :" . mysqli_connect_error() 
		. 'numéro :' . mysqli_connect_errno()); 
mysqli_select_db($link, $bd) 
		or die ("erreur d'accès à la base :" . $bd);
		
}
*/




?>