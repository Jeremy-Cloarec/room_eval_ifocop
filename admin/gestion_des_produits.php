<?php

require_once('../include/init.php');
require_once('../include/fonctions.php');


$title= "Admin de " . $_SESSION['user']['pseudo'];

?>





<?php
require_once('includeAdmin/headerAdmin.php');
?>

    <div class="globalContainer">

            <div class="adminContainer">

                <?php require_once('includeAdmin/navAside.php');?>

                <main class="mainAdmin">
                
                    <h1>Gestion des produits</h1>

                </main>

            </div>


    </div>


<?php require_once('includeAdmin/footerAdmin.php') ?>



