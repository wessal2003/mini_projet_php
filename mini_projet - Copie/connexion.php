<?php
session_start();
include('includes/connexion_bd.php');

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($connexion, htmlspecialchars($_POST['email']));
    $mot_de_passe = mysqli_real_escape_string($connexion, htmlspecialchars($_POST['mot_de_passe']));

    $sql = "SELECT * FROM utilisateurs WHERE email = '$email'";
    $resultat = mysqli_query($connexion, $sql);

    if (mysqli_num_rows($resultat) == 1) {
        $utilisateur = mysqli_fetch_assoc($resultat);

        if ($mot_de_passe === $utilisateur['mot_de_passe']) {
            $_SESSION['id'] = $utilisateur['id'];
            $_SESSION['nom'] = $utilisateur['nom'];
            $_SESSION['type'] = $utilisateur['type'];

            if ($utilisateur['type'] == 'admin') {
                header("Location: admin/admin.php");
                exit();
            } else {
                header("Location: index.php");
                exit();
            }
        } else {
            $message = " Mot de passe incorrect.";
        }
    } else {
        $message = " Email non trouvé.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - CEDAR PERFUMES</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h2>Connexion</h2>
    <?php if ($message != "") echo "<p>$message</p>"; ?>
    <form method="POST" action="">
        <label>Email :</label><br>
        <input type="email" name="email" required><br><br>

        <label>Mot de passe :</label><br>
        <input type="password" name="mot_de_passe" required><br><br>

        <input type="submit" value="Se connecter">
    </form>
    <p>Pas encore inscrit ? <a href="inscription.php">Créer un compte</a></br>
	<i> <a href="index.php">Retour à l'accueil </a></i></p>
</body>
</html>
