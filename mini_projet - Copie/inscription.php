<?php
include('includes/connexion_bd.php');

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = mysqli_real_escape_string($connexion, htmlspecialchars($_POST['nom']));
    $email = mysqli_real_escape_string($connexion, htmlspecialchars($_POST['email']));
    $mot_de_passe = mysqli_real_escape_string($connexion, htmlspecialchars($_POST['mot_de_passe']));
   

    // Vérifie si l'email existe déjà
    $verif = "SELECT * FROM utilisateurs WHERE email = '$email'";
    $resultat = mysqli_query($connexion, $verif);

    if (mysqli_num_rows($resultat) > 0) {
        $message = " Cet email est déjà utilisé.";
    } else {
        $sql = "INSERT INTO utilisateurs (nom, email, mot_de_passe, type)
                VALUES ('$nom', '$email', '$mot_de_passe', 'client')";
        if (mysqli_query($connexion, $sql)) {
            $message = " Inscription réussie ! Vous pouvez maintenant vous connecter.";
        } else {
            $message = " Erreur lors de l'inscription : " . mysqli_error($connexion);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - CEDAR PERFUMES</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h2>Créer un compte</h2>
    <?php if ($message != "") echo "<p>$message</p>"; ?>
    <form method="POST" action="">
        <label>Nom :</label><br>
        <input type="text" name="nom" required><br><br>

        <label>Email :</label><br>
        <input type="email" name="email" required><br><br>

        <label>Mot de passe :</label><br>
        <input type="password" name="mot_de_passe" required><br><br>

        <input type="submit" value="S'inscrire">
    </form>
    <p>Déjà un compte ? <a href="connexion.php">Se connecter</a></p>
</body>
</html>
