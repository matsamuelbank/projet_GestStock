<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi des stocks</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../javaScript/suiviDesStocks.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/inventaire.css">

</head>

<body>
    <?php include('sideBar.php'); ?>

    <div id="page-content-wrapper">
        <div class="container">
            <h1 id="titreInventaire">Alerte stocks en baisse</h1>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nom du produit</th>
                        <th>Quantité</th>
                        <th>Prix unitaire</th>
                        <th>Date d'expiration</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php
                    if ($lesAlertes == NULL) {
                        echo '<h1 id="titreInventaire" style="{margin-top: 100px;}">Aucune baisse pour le moment</h1>';
                    }
                    else {
                        foreach ($lesAlertes as $lalerte) {
                            echo '
                                <tr class="alert alert-danger">
                                    <td><input type="text" class="nomProduit" value="' . $lalerte['aNom'] . '" disabled></td>
                                    <td><input type="number" class="quantite" value="' . $lalerte['aQuantite'] . '" disabled></td>
                                    <td><input type="number" class="prixUnitaire" value="' . $lalerte['aPrixUnitaire'] . '" disabled></td>
                                    <td><input type="date" class="dateExp" value="' . $lalerte['aDateExpiration'] . '" disabled></td>
                                    <p hidden class="idProduit">"' . $lalerte['alArticleId'] . '"</p>
                                </tr>'
                            ;
                        }
                    }
                    ?>
                </tbody>
            </table>



        </div>
    </div>
</body>

</html>