<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['type'] !== 'admin') {
    header("Location: ../connexion.php");
    exit();
}

include('../includes/connexion_bd.php');
$message = "";

// Si formulaire soumis (mise à jour)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modifier'])) {
    $id = intval($_POST['id']);
    $nom = mysqli_real_escape_string($connexion, $_POST['nom']);
    $description = mysqli_real_escape_string($connexion, $_POST['description']);
    $prix = floatval($_POST['prix']);
    $categorie = mysqli_real_escape_string($connexion, $_POST['categorie']);
    $image = mysqli_real_escape_string($connexion, $_POST['image']);
    $stock = intval($_POST['stock']);

    $sql = "UPDATE produits SET nom='$nom', description='$description', prix=$prix, categorie='$categorie', image='$image', stock=$stock WHERE id=$id";

    if (mysqli_query($connexion, $sql)) {
        $message = "✅ Produit modifié avec succès.";
    } else {
        $message = "❌ Erreur : " . mysqli_error($connexion);
    }
}

// Si un produit est sélectionné → afficher formulaire
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $req = mysqli_query($connexion, "SELECT * FROM produits WHERE id = $id");
    $produit = mysqli_fetch_assoc($req);
}

// Sinon → afficher la liste des produits
else {
    $produits = mysqli_query($connexion, "SELECT * FROM produits");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un produit</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<h2>Modifier un produit</h2>

<?php if (isset($produit)): ?>
<form method="POST" action="">
    <input type="hidden" name="id" value="<?php echo $produit['id']; ?>">

    <label>Nom :</label><br>
    <input type="text" name="nom" value="<?php echo $produit['nom']; ?>" required><br><br>

    <label>Description :</label><br>
    <textarea name="description" required><?php echo $produit['description']; ?></textarea><br><br>

    <label>Prix :</label><br>
    <input type="number" name="prix" step="0.01" value="<?php echo $produit['prix']; ?>" required><br><br>

    <label>Catégorie :</label><br>
    <input type="text" name="categorie" value="<?php echo $produit['categorie']; ?>" required><br><br>

    <label>Image (nom fichier) :</label><br>
    <input type="text" name="image" value="<?php echo $produit['image']; ?>" required><br><br>

    <label>Stock :</label><br>
    <input type="number" name="stock" value="<?php echo $produit['stock']; ?>" required><br><br>

    <input type="submit" name="modifier" value="Enregistrer les modifications">
</form>

<?php if ($message != "") echo "<p>$message</p>"; ?>

<?php else: ?>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Prix</th>
        <th>Action</th>
    </tr>
    <?php while ($p = mysqli_fetch_assoc($produits)) : ?>
    <tr>
        <td><?php echo $p['id']; ?></td>
        <td><?php echo $p['nom']; ?></td>
        <td><?php echo $p['prix']; ?> MAD</td>
        <td><a href="modif_produit.php?id=<?php echo $p['id']; ?>">✏️ Modifier</a></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php endif; ?>

<p><a href="admin.php">Retour au tableau de bord</a></p>

</body>
</html>
