<?php

//Connexion BDD

$pdo = new PDO('mysql:host=localhost;dbname=room', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 
'SET NAMES utf8'));

//Session start
session_start();

//Constante contenant le chemin physique du projet

define('RACINE_SITE', $_SERVER['DOCUMENT_ROOT'] . 'room_eval_ifocop/');

//Constante définisssant l'URL

define('URL', "http://localhost/room_eval_ifocop/");

//Initialisation de variables

$erreur = "";
$erreur_index = "";
$validate = "";
$validate_index = "";
$content = "";

//Boucle qui protège les données envoyées par la méthode POST

foreach($_POST as $key => $value){
    $_POST[$key] = htmlspecialchars(trim($value));
    }

//Boucle qui protège les données envoyées par la méthode GET

foreach($_GET as $key => $value){
    $_GET[$key] = htmlspecialchars(trim($value));
    }

require_once('fonctions.php');






