<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['type'] !== 'client') {
    header("Location: ../connexion.php");
    exit();
}

include('../includes/connexion_bd.php');

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$adresse = isset($_POST['adresse']) ? mysqli_real_escape_string($connexion, $_POST['adresse']) : null;
$ville = isset($_POST['ville']) ? mysqli_real_escape_string($connexion, $_POST['ville']) : null;
$telephone = isset($_POST['telephone']) ? mysqli_real_escape_string($connexion, $_POST['telephone']) : null;

$numero_carte = isset($_POST['numero_carte']) ? mysqli_real_escape_string($connexion, $_POST['numero_carte']) : null;
$nom_carte = isset($_POST['nom_carte']) ? mysqli_real_escape_string($connexion, $_POST['nom_carte']) : null;
$expiration_carte = isset($_POST['expiration_carte']) ? mysqli_real_escape_string($connexion, $_POST['expiration_carte']) : null;
$cvv = isset($_POST['cvv']) ? mysqli_real_escape_string($connexion, $_POST['cvv']) : null;

    $paiement = mysqli_real_escape_string($connexion, $_POST['paiement']);
    $id_user = $_SESSION['id'];

    mysqli_query($connexion, "INSERT INTO commandes (id_utilisateur, mode_paiement) VALUES ($id_user, '$paiement')");
    $id_commande = mysqli_insert_id($connexion);

    $req = mysqli_query($connexion, "SELECT * FROM panier WHERE id_utilisateur = $id_user");
    while ($panier = mysqli_fetch_assoc($req)) {
        $prod = mysqli_fetch_assoc(mysqli_query($connexion, "SELECT * FROM produits WHERE id = ".$panier['id_produit']));
        $prix = $prod['prix'];
        $qt = $panier['quantite'];
        mysqli_query($connexion, "INSERT INTO commandes 
(id_utilisateur, mode_paiement, adresse, ville, telephone, numero_carte, nom_carte, expiration_carte, cvv)
VALUES 
($id_user, '$paiement', '$adresse', '$ville', '$telephone', '$numero_carte', '$nom_carte', '$expiration_carte', '$cvv')");

    

mysqli_query($connexion, "UPDATE produits SET stock = stock - $qt WHERE id = ".$prod['id']);
	}
    mysqli_query($connexion, "DELETE FROM panier WHERE id_utilisateur = $id_user");
    $message = " Commande validée avec succès !";
}
?>

<h2>Valider ma commande</h2>
<?php if ($message != "") echo "<p>$message</p>"; ?>

<!--<form method="POST" action="">
    <label>Moyen de paiement :</label><br>
    <select name="paiement" required>
        <option value="livraison">Paiement à la livraison</option>
        <option value="carte">Carte bancaire</option>
    </select><br><br>
    <input type="submit" value="Confirmer la commande">
</form>
<p><a href="../index.php"> Retour au site</a></p>-->
<form method="POST" action="">
    <label>Moyen de paiement :</label><br>
    <select name="paiement" id="paiement-select" required onchange="afficherChampsPaiement()">
        <option value="">-- Choisir --</option>
        <option value="livraison">Paiement à la livraison</option>
        <option value="carte">Carte bancaire</option>
    </select><br><br>

    <div id="livraison" style="display:none;">
        <label>Adresse :</label><br>
        <input type="text" name="adresse"><br><br>

        <label>Ville :</label><br>
        <input type="text" name="ville"><br><br>

        <label>Téléphone :</label><br>
        <input type="text" name="telephone"><br><br>
    </div>

    <div id="carte" style="display:none;">
        <label>Numéro de carte :</label><br>
        <input type="text" name="numero_carte"><br><br>

        <label>Nom sur la carte :</label><br>
        <input type="text" name="nom_carte"><br><br>

        <label>Date d’expiration :</label><br>
        <input type="text" name="expiration_carte" placeholder="MM/AA"><br><br>

        <label>CVV :</label><br>
        <input type="text" name="cvv"><br><br>
    </div>

    <input type="submit" value="Confirmer la commande">
</form>

<script>
function afficherChampsPaiement() {
    var select = document.getElementById("paiement-select");
    document.getElementById("livraison").style.display = select.value === "livraison" ? "block" : "none";
    document.getElementById("carte").style.display = select.value === "carte" ? "block" : "none";
}
</script>
