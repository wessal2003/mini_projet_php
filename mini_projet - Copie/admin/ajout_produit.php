<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['type'] !== 'admin') {
    header("Location: ../connexion.php");
    exit();
}

include('../includes/connexion_bd.php');

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = mysqli_real_escape_string($connexion, $_POST['nom']);
    $description = mysqli_real_escape_string($connexion, $_POST['description']);
    $prix = floatval($_POST['prix']);
    $categorie = mysqli_real_escape_string($connexion, $_POST['categorie']);
    $image = mysqli_real_escape_string($connexion, $_POST['image']); // nom de fichier image

    $sql = "INSERT INTO produits (nom, description, prix, categorie, image)
            VALUES ('$nom', '$description', $prix, '$categorie', '$image')";

    if (mysqli_query($connexion, $sql)) {
        $message = " Produit ajouté avec succès.";
    } else {
        $message = "Erreur : " . mysqli_error($connexion);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un produit</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<h2>Ajouter un produit</h2>



<form method="POST" action="">
    <label>Nom :</label><br>
    <input type="text" name="nom" required><br><br>

    <label>Description :</label><br>
    <textarea name="description" required></textarea><br><br>

    <label>Prix (MAD) :</label><br>
    <input type="number" name="prix" step="0.01" required><br><br>

    <label>Catégorie :</label><br>
    <input type="text" name="categorie" required><br><br>

    <label>Nom de l'image (ex: parfum1.png) :</label><br>
    <input type="text" name="image" required><br><br>

    <input type="submit" value="Ajouter le produit">
</form>
<?php if ($message != "") echo "<center><p>$message</p></center>"; ?>
<p><a href="admin.php"> Retour au tableau de bord</a></br>
<a href="admin.php"> <u>Retour à l'accueil </u></a>
 </p>

</body>
</html>
