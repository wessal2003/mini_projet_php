<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['type'] !== 'client') {
    header("Location: ../connexion.php");
    exit();
}

include('../includes/connexion_bd.php');
// Ajouter un produit au panier si id_produit est passé dans l'URL
if (isset($_GET['id_produit'])) {
    $id_produit = intval($_GET['id_produit']);
    $id_user = $_SESSION['id'];

    // Vérifie si le produit est déjà dans le panier
    $verif = mysqli_query($connexion, "SELECT * FROM panier WHERE id_produit = $id_produit AND id_utilisateur = $id_user");

    if (mysqli_num_rows($verif) > 0) {
        // Si oui → on augmente la quantité
        mysqli_query($connexion, "UPDATE panier SET quantite = quantite + 1 WHERE id_produit = $id_produit AND id_utilisateur = $id_user");
    } else {
        // Sinon → on ajoute une nouvelle ligne
        mysqli_query($connexion, "INSERT INTO panier (id_utilisateur, id_produit, quantite) VALUES ($id_user, $id_produit, 1)");
    }

    // Redirection propre
    header("Location: mon_panier.php");
    exit();
}

// Supprimer un produit
if (isset($_GET['supprimer'])) {
    $id = intval($_GET['supprimer']);
    mysqli_query($connexion, "DELETE FROM panier WHERE id = $id AND id_utilisateur = ".$_SESSION['id']);
}

// Ajouter ou modifier quantité
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST['quantite'] as $id_panier => $qt) {
        $qt = intval($qt);
        mysqli_query($connexion, "UPDATE panier SET quantite = $qt WHERE id = $id_panier AND id_utilisateur = ".$_SESSION['id']);
    }
}

// Affichage panier
$sql = "SELECT p.id, p.nom, p.prix, p.image, pa.id AS id_panier, pa.quantite
        FROM panier pa
        JOIN produits p ON p.id = pa.id_produit
        WHERE pa.id_utilisateur = " . $_SESSION['id'];
$res = mysqli_query($connexion, $sql);
?>

<h2>Mon panier</h2>

<form method="POST" action="">
<table border="1" cellpadding="10">
    <tr>
        <th>Produit</th>
        <th>Prix unitaire</th>
        <th>Quantité</th>
        <th>Total</th>
        <th>Action</th>
    </tr>
    <?php $total = 0; while ($row = mysqli_fetch_assoc($res)) : 
        $sous_total = $row['prix'] * $row['quantite'];
        $total += $sous_total;
    ?>
    <tr>
        <td><?php echo $row['nom']; ?></td>
        <td><?php echo $row['prix']; ?> MAD</td>
        <td><input type="number" name="quantite[<?php echo $row['id_panier']; ?>]" value="<?php echo $row['quantite']; ?>" min="1"></td>
        <td><?php echo $sous_total; ?> MAD</td>
        <td><a href="mon_panier.php?supprimer=<?php echo $row['id_panier']; ?>">Supprimer</a></td>
    </tr>
    <?php endwhile; ?>
</table>
<br>
<input type="submit" value="Mettre à jour les quantités">
</form>

<h3>Total : <?php echo $total; ?> MAD</h3>
<a href="commande.php"> Valider la commande</a>
<p><a href="../index.php"> Retour au site</a></p>