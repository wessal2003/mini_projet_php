<?php
$hote = "localhost"; 
$utilisateur = "root";
$mot_de_passe = "";
$base_de_donnees = "cedar_perfumes";

// Connexion à la base de données
$connexion = mysqli_connect($hote, $utilisateur, $mot_de_passe, $base_de_donnees);

// Vérification de la connexion
if (!$connexion) {
    die("Échec de la connexion à la base de données : " . mysqli_connect_error());
}
?>
