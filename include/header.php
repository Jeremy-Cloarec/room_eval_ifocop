<?php 

require_once('include/init.php');
require_once('include/fonctions.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="<?php URL ?>css/style.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <a href=" <?= URL ?>index.php">Room</a>
            </div>
            <ul class="ulMenu">
                <li class="deroulant">
                    <a href="#" class="espacemembre">Espace membre</a>
                    <ul class="sous">
                        <li><a href="<?php URL ?>inscription.php">Inscription</a></li>
                        <li><a href="<?php URL ?>connexion.php">Connexion</a></li>
                        <li><a href="<?php URL ?>profil.php">Profil</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>

