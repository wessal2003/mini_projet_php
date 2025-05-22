<?php
include('includes/connexion_bd.php');

if (!isset($_GET['id'])) {
    echo "Parfum non trouvé.";
    exit();
}

$id = intval($_GET['id']);
$req = mysqli_query($connexion, "SELECT * FROM produits WHERE id = $id");
$produit = mysqli_fetch_assoc($req);

if (!$produit) {
    echo "Produit introuvable.";
    exit();
}
?>

<h2><?php echo $produit['nom']; ?></h2>
<img src="assets/images/<?php echo $produit['image']; ?>" width="250"><br><br>
<p><strong>Prix :</strong> <?php echo $produit['prix']; ?> MAD</p>
<p><strong>Catégorie :</strong> <?php echo $produit['categorie']; ?></p>
<p><strong>Description :</strong><br><?php echo nl2br($produit['description']); ?></p>

<br>
<a href="index.php">Retour à l'accueil</a>
