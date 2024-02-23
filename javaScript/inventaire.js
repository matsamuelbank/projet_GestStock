$(document).ready(function () {
    $("#btnAjouter").click(function () {
        var nomProduit = $("#nomProduit").val();
        var quantite = $("#quantite").val();
        var prixUnitaire = $("#prixUnitaire").val();
        var commentaire = $("#commentaire").val();
        var dateExp = $("#dateExp").val();
        let idUser = $("#idUser").val();
        $.ajax({
            url: '../controleurs/c_gestStock.php?action=addArticle',
            method: 'POST',
            data: {
                'nomProduit': nomProduit,
                'quantite': quantite,
                'prixUnitaire': prixUnitaire,
                'commentaire': commentaire,
                'dateExp': dateExp,
                'idUser': idUser
            },
            success: function (reponse) {
                $("#tableBody").append("<tr><td>" + '<input type="text" value="' + nomProduit + '" disabled>' + "</td><td>" + '<input type="number" value="' + quantite + '" disabled>' + "</td><td>" + '<input type="number" value="' + prixUnitaire + '" disabled>' + "</td><td>" + '<input type="text" value="' + commentaire + '" disabled>' + "</td><td>" + '<input type="date" value="' + dateExp + '" disabled>' + "</td></tr>");
            }
        });
    });
});