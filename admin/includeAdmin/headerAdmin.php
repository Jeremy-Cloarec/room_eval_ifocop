<?php 

require_once('../include/init.php');
require_once('../include/fonctions.php');

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="<?= URL ?>admin/css_admin/style_admin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <a href=" <?= URL ?>admin/index.php">Bonjour <strong><?= $_SESSION['user']['pseudo']?></strong>,<br/><span class="spanBienvenu">Vous êtes dans votre espace admin</span></a>
            </div>
            <ul class="ulMenu">
                <li class="deroulant">
                    <a href="<?= URL ?>index.php" class="espacemembre">Revenir au site</a>
                    <!-- <ul class="sous">
                        <li><a href="index.php">Acceuil</a></li>
                    </ul> -->
                </li>
            </ul>
        </nav>
    </header>

