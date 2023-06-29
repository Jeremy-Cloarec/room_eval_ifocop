<?php

require_once('../include/init.php');
require_once('../include/fonctions.php');


$title= "Statistiques";

if(!internauteConnecteAdmin()){
    header('location:' . URL . 'connexion.php');
    exit();
}

?>





<?php
require_once('includeAdmin/headerAdmin.php');
?>

    <div class="globalContainer">

            <div class="adminContainer">

                <?php require_once('includeAdmin/navAside.php');?>

                <main class="mainAdmin">
                
                    <h1>Statistiques</h1>

                </main>

            </div>


    </div>


<?php require_once('includeAdmin/footerAdmin.php') ?>



