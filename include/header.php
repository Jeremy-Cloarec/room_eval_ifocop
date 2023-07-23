<?php 

require_once('init.php');
require_once('fonctions.php');


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="<?php URL ?>css/style.css">
    <link rel="stylesheet" href="<?php URL ?>css/index.css">
    <link rel="stylesheet" href="<?php URL ?>css/ficheProduit.css">
    <link rel="stylesheet" href="<?php URL ?>css/nav.css">
    

</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <a href=" <?= URL ?>index.php">Room</a>
            </div>
            <ul class="ulMenu">
                
                
                <?php if(internauteConnecteAdmin()):?>
                    <li><a href="<?php URL ?>admin/index.php">Votre espace</a></li>
                    <li><a href="<?php URL ?>profil.php">Profil de <?= $_SESSION['user']['pseudo']?></a></li>
                    <li><a href="<?php URL ?>connexion.php?action=deconnexion">Déconnexion</a></li>
                <?php elseif(internauteConnecte()):?> 
                    <li><a href="<?php URL ?>profil.php">Profil de <?= $_SESSION['user']['pseudo']?></a></li>
                    <li><a href="<?php URL ?>connexion.php?action=deconnexion">Déconnexion</a></li>
                <?php elseif(!internauteConnecte()):?> 
                    <li><a href="<?php URL ?>inscription.php">Inscription</a></li>
                    <li><a href="<?php URL ?>connexion.php">Connexion</a></li>

                <?php endif;?>
            </ul>
        </nav>
    </header>
