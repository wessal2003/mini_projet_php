<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['type'] !== 'admin') {
    header("Location: ../connexion.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - CEDAR PERFUMES</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<h2>Bienvenue, Admin <?php echo $_SESSION['nom']; ?> !</h2>

<h3>🛒 Gestion des Produits</h3>
<ul>
    <li><a href="ajout_produit.php">➕ Ajouter un produit</a></li>
    <li><a href="modif_produit.php">✏️ Modifier un produit</a></li>
    <li><a href="supp_produit.php">🗑️ Supprimer un produit</a></li>
</ul>

<h3>👤 Gestion des Clients</h3>
<ul>
    <li><a href="gestion_clt.php">👥 Visualiser, modifier ou supprimer les clients</a></li>
</ul>

<p><a href="../index.php"> Retour au site</a></p>

</body>
</html>

