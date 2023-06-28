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
                
                    <h1>Gestion des membres</h1>

                    <?php $queryUsers = $pdo->query("SELECT id_membre FROM membre") ?>

                    
                    <!-- Tableaux des membres -->

                    <h2>Nombre d'utilisateurs en base de données : <?= $queryUsers->rowCount() ?></h2>


                    <div class="table-container">
                        <table>
                            <?php $afficheTousUsers = $pdo->query("SELECT * FROM membre ORDER BY pseudo") ?>

                            <thead>
                                <tr>
                                    <?php for ($i = 0; $i < $afficheTousUsers->columnCount(); $i++) {

                                        $colonne = $afficheTousUsers->getColumnMeta($i);

                                    ?>

                                        <?php if ($colonne['name'] != 'mdp') : ?>
                                            <th><?= $colonne['name'] ?></th>
                                        <?php endif; ?>

                                        <?php

                                        ?>

                                    <?php } ?>
                                    <th colspan="2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($tousUsers = $afficheTousUsers->fetch(PDO::FETCH_ASSOC)) : ?>
                                    <tr>
                                        <?php foreach ($tousUsers as $key => $value) : ?>
                                            <?php if ($key != 'mdp') : ?>
                                                <td><?= $value ?> </td>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        <td><a href='?action=update&id_membre=<?= $tousUsers['id_membre'] ?>'><i class="bi bi-pen-fill"></i></a></td>

                                        <td><a href="?action=delete&id_membre=<?= $tousUsers['id_membre'] ?>"><i class="bi bi-trash-fill" style="font-size: 1.5rem;"></i></a></td>

                                    </tr>
                                <?php endwhile;?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Formulaire de modificaations des membres -->

                    <?php 
                    $actionbutton="?action=add";

                    ?>

                    <div class="modifFormulaire">
                        <a href="<?= $actionbutton;?>" class="espacemembre btnModifFormulaire">
                            <?php if(isset($_GET['action'])): ?>
                                Modifier le tableau
                            
                            <?php else:?>
                                
                            Afficher le tableau
                                

                            
                                
                            <?php endif;?>


                            
                        </a>
                    </div>


                    <div class="inscription">

                    

                        <?php if(isset($_GET['action'])): ?>

                            <h2>Formulaire <?= ($_GET['action'] == "add") ? "d'ajout" : "de modification" ?> des utilisateurs</h2>



                            <?= $erreur ?>

                            <form action="" class="inscriptionForm form" method="POST">
                                <!-- pseudo, mdp,nom, prenom, email -->
                                <div class="champInput">
                                    <label class="" for="pseudo">
                                    Pseudo
                                    </label>
                                    <input class="" type="text" name="pseudo" id="pseudo" placeholder="Votre pseudo" max-length="20" pattern="[a-zA-Z0-9-_.]{3,20}" required>
                                </div>
                                <div class="champInput">
                                    <label class="" for="mdp">
                                    Mot de passe
                                    </label>
                                    <input class="" type="password" name="mdp" id="mdp" placeholder="Votre mot de passe" max-length="20" pattern="[a-zA-Z0-9-_.]{3,20}" required>
                                </div>
                                <div class="champInput">
                                    <label class="" for="nom">
                                    Nom
                                    </label>
                                    <input class="" type="text" name="nom" id="nom" placeholder="Votre nom" required>
                                </div>
                                <div class="champInput">
                                    <label class="" for="prenom">
                                    Prénom
                                    </label>
                                    <input class="" type="text" name="prenom" id="prenom" placeholder="Votre prénom" required>
                                </div>
                                <div class="champInput">
                                    <label class="" for="email">
                                    email
                                    </label>
                                    <input class="" type="email" name="email" id="email" placeholder="Votre email" required>
                                </div>
                                <div class="">
                                    <p>
                                        <div class="">Civilité</div>
                                    </p>
                                    <div class="">
                                        <input class="" type="radio" name="civilite" id="civilite1" value="f">
                                        <label class="" for="civilite1">f</label>
                                    </div>
                                    <div class="">
                                        <input class="" type="radio" name="civilite" id="civilite2" value="m" checked>
                                        <label class="" for="civilite2">m</label>
                                    </div>
                                </div>
                                <div class="champInput">
                                    <button name="buttonInscription" class="buttonFormulaire">Valider</button>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>

                </main>

                
            </div>


    </div>


<?php require_once('includeAdmin/footerAdmin.php') ?>



