<?php 

require_once('../include/init.php');
require_once('../include/fonctions.php');

?>

<aside class="adminAside">
    <ul class="menuAside">
        
        <li class="lienAside"><a href="<?= URL; ?>admin/index.php">Accueil</a></li>
        <li class="lienAside"><a href="<?= URL; ?>admin/gestion_des_membres.php">Gestion des membres</a></li>
        <li class="lienAside"><a href="<?= URL; ?>admin/gestion_des_avis.php">Gestion des avis</a></li>
        <li class="lienAside"><a href="<?= URL; ?>admin/gestion_des_commandes.php">Gestion des commandes</a></li>
        <li class="lienAside"><a href="<?= URL; ?>admin/gestion_des_produits.php">Gestion des produits</a></li>
        <li class="lienAside"><a href="<?= URL; ?>admin/gestion_des_salles.php">Gestion des salles</a></li>
        <li class="lienAside"><a href="<?= URL; ?>admin/statistique.php">Statistique</a></li>
    </ul>
</aside>

