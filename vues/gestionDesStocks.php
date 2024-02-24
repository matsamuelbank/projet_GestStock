<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des stocks</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../javaScript/gestionDesStocks.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/inventaire.css">
    <style>

    </style>
</head>

<body>
    <?php include('sideBar.php'); ?>

    <div id="page-content-wrapper">
        <div class="container">
            <h1 id="titreInventaire" style="padding-top : 20px; padding-bottom : 20px;">Gestion des stocks</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nom du produit</th>
                        <th>Quantité</th>
                        <th>Prix unitaire</th>
                        <th>Commentaire</th>
                        <th>Date d'expiration</th>
                        <th>Date ajout/Retrait</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php
                    foreach ($lesTransactions as $transaction) {
                        echo '
                            <tr>
                                <td><input type="text" class="nomProduit" value="' . $transaction['aNom'] . '" disabled></td>
                                <td><input type="number" class="quantite" value="' . $transaction['tQuantite'] . '" disabled></td>
                                <td><input type="number" class="prixUnitaire" value="' . $transaction['aPrixUnitaire'] . '" disabled></td>
                                <td><input type="text" class="commentaire" value="' . $transaction['tCommentaire'] . '" disabled></td>
                                <td><input type="date" class="dateExp" value="' . $transaction['aDateExpiration'] . '" disabled></td>
                                <td><input type="date" class="tDate" value="' . $transaction['tDate'] . '" disabled></td>
                                <td class="tdBouton"><button class="add"><i class="fa-solid fa-plus"></i></button><button class="remove"><i class="fa-solid fa-trash"></i></button></td>
                                <td><input type="hidden" class="idProduit" value="' . $transaction['aId'] . '" disabled></td>
                                <td><input type="hidden" class="userTransac" value="' . $transaction['uId'] . '" disabled></td>
                            </tr>'
                        ;
                    }
                    ?>
                </tbody>

            </table>
            <input id="idUser" type="hidden" value=<?php echo $user['uId']; ?>>

            <div class="modal" id="successModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Succès</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p id="successMessage"></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="errorModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Erreur</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p id="errorMessage"></p>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

</body>

</html>