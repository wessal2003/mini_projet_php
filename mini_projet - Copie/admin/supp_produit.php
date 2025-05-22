<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['type'] !== 'admin') {
    header("Location: ../connexion.php");
    exit();
}

include('../includes/connexion_bd.php');

// Suppression si ID dans l'URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    mysqli_query($connexion, "DELETE FROM produits WHERE id = $id");
    header("Location: supp_produit.php?msg=supprimé");
    exit();
}

$result = mysqli_query($connexion, "SELECT * FROM produits");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer un produit</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<h2>Liste des produits à supprimer</h2>

<?php if (isset($_GET['msg']) && $_GET['msg'] == "supprimé"): ?>
    <p> Produit supprimé avec succès.</p>
<?php endif; ?>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Prix</th>
        <th>Action</th>
    </tr>
    <?php while ($produit = mysqli_fetch_assoc($result)) : ?>
        <tr>
            <td><?php echo $produit['id']; ?></td>
            <td><?php echo $produit['nom']; ?></td>
            <td><?php echo $produit['prix']; ?> MAD</td>
            <td><a href="supp_produit.php?id=<?php echo $produit['id']; ?>" onclick="return confirm('Confirmer la suppression ?')">❌ Supprimer</a></td>
        </tr>
    <?php endwhile; ?>
</table>

<p><a href="admin.php"> Retour au tableau de bord</a></p>

</body>
</html>
