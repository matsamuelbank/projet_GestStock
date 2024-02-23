<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Inventaire</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../javaScript/inventaire.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/inventaire.css">
</head>

<body>
    <?php include('sideBar.php'); ?>

    <div id="page-content-wrapper">
        <div class="container">

            <h1 id="titreInventaire">Inventaire</h1>

            <div id="mere-divForm">
                <div id="divForm">
                    <div id="nomEtQte">
                        <input type="text" name="nomProduit" id="nomProduit" placeholder="nom du produit">
                        <input type="number" name="quantite" id="quantite" placeholder="quantité">
                    </div>
                    <div id="dateexpEtPrixUnitaire">
                        <input type="date" name="dateExp" id="dateExp">
                        <input type="number" placeholder="prix unitaire" name="prixUnitaire" id="prixUnitaire">
                    </div>
                    <div id="inventaireCommentaire">
                        <textarea name="commentaire" id="commentaire" placeholder="commentaire"></textarea>
                    </div>
                    <div>
                        <button id="btnAjouter" style="text-align: center;">Ajouter le produit</button>
                    </div>
                </div>
            </div>

            <h2 id="titreInventaire" style="padding-top : 20px; padding-bottom : 20px;">Produits en stock</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nom du produit</th>
                        <th>Quantité</th>
                        <th>Prix unitaire</th>
                        <th>Commentaire</th>
                        <th>Date d'expiration</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php
                    foreach ($lesProduits as $produit) {
                        echo '
                            <tr>
                            <td><input type="text" value="' . $produit['aNom'] . '" disabled></td>
                            <td><input type="number" value="' . $produit['aQuantite'] . '" disabled></td>
                            <td><input type="number" value="' . $produit['aPrixUnitaire'] . '" disabled></td>
                            <td><input type="text" value="' . $produit['aCommentaire'] . '" disabled></td>
                            <td><input type="date" value="' . $produit['aDateExpiration'] . '" disabled></td>
                          </tr>';
                    }
                    ?>
                </tbody>
            </table>

        </div>
        <input id="idUser" type="hidden" value=<?php echo $user['uId']; ?>>
        
    </div>
</body>

</html>