<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['type'] !== 'client') {
    header("Location: ../connexion.php");
    exit();
}

include('../includes/connexion_bd.php');

$req = mysqli_query($connexion, "SELECT * FROM commandes WHERE id_utilisateur = ".$_SESSION['id']." ORDER BY date_commande DESC");
?>

<h2>Historique de mes commandes</h2>

<?php while ($cmd = mysqli_fetch_assoc($req)) : ?>
    <h3>Commande n°<?php echo $cmd['id']; ?> - <?php echo $cmd['date_commande']; ?> - <?php echo $cmd['mode_paiement']; ?></h3>
    <ul>
    <?php
    $lignes = mysqli_query($connexion, "SELECT * FROM lignes_commandes lc JOIN produits p ON lc.id_produit = p.id WHERE id_commande = ".$cmd['id']);
    while ($ligne = mysqli_fetch_assoc($lignes)) {
        echo "<li>".$ligne['nom']." x ".$ligne['quantite']." => ".$ligne['prix_unitaire']." MAD</li>";
    }
    ?>
    </ul>
    <hr>
<?php endwhile; ?>
<p><a href="../index.php"> Retour au site</a></p>
