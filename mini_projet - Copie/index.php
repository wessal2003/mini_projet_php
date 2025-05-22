<?php
session_start();
include('includes/connexion_bd.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - CEDAR PERFUMES</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<?php include('includes/entete.php'); ?>
<main>

<h2></br>Nos Parfums</h2>

<div class="grille-produits">
<?php
$conditions = [];

if (isset($_GET['recherche']) && $_GET['recherche'] != "") {
    $mot_cle = mysqli_real_escape_string($connexion, $_GET['recherche']);
    $conditions[] = "(nom LIKE '%$mot_cle%' OR description LIKE '%$mot_cle%')";
}

if (isset($_GET['categorie']) && $_GET['categorie'] != "") {
    $categorie = mysqli_real_escape_string($connexion, $_GET['categorie']);
    $conditions[] = "categorie = '$categorie'";
}

if (!empty($conditions)) {
    $sql = "SELECT * FROM produits WHERE " . implode(" AND ", $conditions);
} else {
    $sql = "SELECT * FROM produits";
}

$resultat = mysqli_query($connexion, $sql);

if (mysqli_num_rows($resultat) == 0) {
    echo "<p style='text-align:center; font-weight:bold; color:red;'>❌ Aucun produit trouvé pour \"".htmlspecialchars($_GET['recherche'])."\".</p>";
} else {
    while ($produit = mysqli_fetch_assoc($resultat)) {
        echo "<div class='carte-produit'>";
        echo "<img src='assets/images/" . $produit['image'] . "' alt='" . $produit['nom'] . "'>";
        echo "<h3>" . $produit['nom'] . "</h3>";
        echo "<p class='prix'>" . number_format($produit['prix'], 2, ',', ' ') . " MAD</p>";

        if ($produit['stock'] > 0) {
            echo "<p class='stock vert'>🟢 En stock : " . $produit['stock'] . "</p>";
            echo "<div class='actions'>";
            echo "<a href='client/mon_panier.php?id_produit=" . $produit['id'] . "' class='btn-ajouter'>🛒 Acheter</a>";
            echo "<a href='details.php?id=" . $produit['id'] . "' class='btn-details'>ℹ Détails</a>";
            echo "</div>";
        } else {
            echo "<p class='stock rouge'>❌ Rupture de stock</p>";
            echo "<div class='actions'>";
            echo "<a class='btn-ajouter disabled'>Indisponible</a>";
            echo "<a href='details.php?id=" . $produit['id'] . "' class='btn-details'>ℹ Détails</a>";
            echo "</div>";
        }

        echo "</div>"; // .carte-produit
    }
}
?>
</div>

</main>
<?php include('includes/pied.php'); ?>

</body>
</html>
