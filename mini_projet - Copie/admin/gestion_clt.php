<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['type'] !== 'admin') {
    header("Location: ../connexion.php");
    exit();
}

include('../includes/connexion_bd.php');

// Suppression d'un client si demandé
if (isset($_GET['supprimer'])) {
    $id = intval($_GET['supprimer']);
    mysqli_query($connexion, "DELETE FROM utilisateurs WHERE id = $id AND type = 'client'");
    header("Location: clients.php?msg=supprimé");
    exit();
}

// Récupérer tous les clients
$clients = mysqli_query($connexion, "SELECT * FROM utilisateurs WHERE type = 'client'");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des clients</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<h2>Liste des clients</h2>

<?php if (isset($_GET['msg']) && $_GET['msg'] == 'supprimé'): ?>
    <p style="color:green;">✅ Client supprimé avec succès.</p>
<?php endif; ?>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Email</th>
        <th>Action</th>
    </tr>
    <?php while ($client = mysqli_fetch_assoc($clients)) : ?>
    <tr>
        <td><?php echo $client['id']; ?></td>
        <td><?php echo $client['nom']; ?></td>
        <td><?php echo $client['email']; ?></td>
        <td>
            <a href="modifier_client.php?id=<?php echo $client['id']; ?>">✏️ Modifier</a> |
            <a href="clients.php?supprimer=<?php echo $client['id']; ?>" onclick="return confirm('Supprimer ce client ?')">🗑️ Supprimer</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<p><a href="admin.php"> Retour au tableau de bord</a></p>

</body>
</html>
