<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['type'] !== 'client') {
    header("Location: ../connexion.php");
    exit();
}

include('../includes/connexion_bd.php');
$req = mysqli_query($connexion, "SELECT * FROM utilisateurs WHERE id = ".$_SESSION['id']);
$utilisateur = mysqli_fetch_assoc($req);
?>

<h2>Mon profil</h2>
<p><strong>Nom :</strong> <?php echo $utilisateur['nom']; ?></p>
<p><strong>Email :</strong> <?php echo $utilisateur['email']; ?></p>
<p><strong>Type :</strong> <?php echo $utilisateur['type']; ?></p>
<p><a href="../index.php"> Retour au site</a></p>