<?php
if (!isset($_SESSION)) session_start();
?>

<header class="entete">
    <div class="conteneur-entete">

        <div class="logo">
		    <img src='assets/images/logo.jpeg'>
			<a href="index.php">CEDAR <span>PERFUMES</span></a>
        </div>

        <form method="GET" action="index.php" class="zone-recherche">
            <select name="categorie">
                <option value="">Catégorie</option>
                <option value="Homme">Homme</option>
                <option value="Femme">Femme</option>
                <option value="Mixte">UniSexe</option>
            </select>

            <input type="text" name="recherche" placeholder="Rechercher un parfum..."
                value="<?php if (isset($_GET['recherche'])) echo htmlspecialchars($_GET['recherche']); ?>">

            <button type="submit">🔍</button>
        </form>

        <nav class="menu">
            <a href="index.php">Accueil</a>
            <?php if (isset($_SESSION['id']) && $_SESSION['type'] === 'client'): ?>
                <a href="client/mon_panier.php">🛒 Mon Panier</a>
                <a href="client/profil.php">👤 Mon Profil</a>
                <a href="client/historique_cmds.php">📦 Commandes</a>
                <a href="deconnexion.php">🚪 Déconnexion</a>
            <?php elseif (isset($_SESSION['id']) && $_SESSION['type'] === 'admin'): ?>
                <a href="admin/admin.php">⚙️ Espace Admin</a>
                <a href="deconnexion.php">🚪 Déconnexion</a>
            <?php else: ?>
                <a href="connexion.php">Connexion</a>
                <a href="inscription.php">Inscription</a>
            <?php endif; ?>
        </nav>

    </div>
</header>
