<?php
//page avec les menus de base

//creation de la session
	session_start();
?>
	<head>
		<link href="img/Pokeball.png" rel="shortcut icon">
		<link rel="stylesheet" href="style.css" media="all"/>
		<title>Pokemon Placement</title>
	</head>

<!-- presentation de la page html -->
	<header>
		<center><img src="img/Pokemon.png" alt="image" style="width:300px; height:100px;"/></center>
	</header>
		
	<div id="page">
		<div id="menu">
			<a class="accueil" href="index.php"><img id="home" src="img/Home.png" alt="image">Page d'accueil</a>

	<?php
				include('connexion.php');					
	?>

		</div><br>

		<?php
				//erreur d'authentification : manque mot de passe pour se connecter
					if(isset($_SESSION['erreur']) && $_SESSION['erreur'] == 5){
						echo "<strong style = 'color:red; padding-left:30%;'>Mot de passe manquant !</strong><br><br>";
					} 

				//erreur de mot de passe
					if(isset($_SESSION['erreur']) && $_SESSION['erreur'] == 6){
						echo "<strong style = 'color:red; padding-left:30%;'>Mot de passe incorrect !</strong><br><br>";
					}

				//erreur d'authentification : manque email pour se connecter
					if(isset($_SESSION['erreur']) && $_SESSION['erreur'] == 7){
						echo "<strong style = 'color:red; padding-left:30%;'>Email manquant !</strong><br><br>";
					} 
		?>
