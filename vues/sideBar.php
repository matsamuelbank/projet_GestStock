<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
} else {
    $user = $_SESSION['user'];
}

?>
<div id="wrapper" style="display: flex;">
    <div class="bg-light border-right" id="sidebar-wrapper" style="min-width: 250px; height: 100vh;">
        <div class="sidebar-heading">GestStock</div> <br>
        <div class="list-group list-group-flush my-10">
            <p class="list-group-item list-group-item-action bg-light scrollto"> <?php echo "Bonjour, " . $user['uPrenom'] . " " . $user['uNom']; ?></p>
            <a href="c_gestStock.php?action=accueil" class="list-group-item list-group-item-action bg-light scrollto">Inventaire</a>
            <a href="c_gestStock.php?action=suiviDesStocks" class="list-group-item list-group-item-action bg-light scrollto">Suivi des stocks</a>
            <a href="c_gestStock.php?action=gestionDesStocks" class="list-group-item list-group-item-action bg-light scrollto">Gestion des stocks</a>
            <a href="c_deconnexion.php" class="list-group-item list-group-item-action bg-light scrollto">Déconnexion</a>
        </div>
    </div>
</div>