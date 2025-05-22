<?php
session_start();
session_unset();  // Vide toutes les variables de session
session_destroy();  // Supprime la session

header("Location: connexion.php");
exit();
