$(document).ready(function () {
    let isEditing = false;

    $('.add').click(function () {
        if (!isEditing) {
            // Change l'icône du bouton
            $(this).find('i').removeClass('fa-plus').addClass('fa-check');

            // Désactive les champs de saisie
            let parentRow = $(this).closest('tr');
            let disabledInputs = parentRow.find('input:disabled');
            disabledInputs.prop('disabled', false);

            // Passe à l'état d'édition
            isEditing = true;
        } else {
            // Remettre l'icône du bouton
            $(this).find('i').removeClass('fa-check').addClass('fa-plus');

            let parentRow = $(this).closest('tr');
            let enabledInputs = parentRow.find('input:not(:disabled)');
            enabledInputs.prop('disabled', true);

            // On passe à l'état non édité
            isEditing = false;

            var idProduit = parentRow.find('.idProduit').val();
            var quantite = parentRow.find(".quantite").val();
            var commentaire = parentRow.find(".commentaire").val();
            var dateTransaction = parentRow.find(".tDate").val();
            var dateExp = parentRow.find(".dateExp").val();
            let idUser = $("#idUser").val();
            let prixUnitaire = parentRow.find(".prixUnitaire").val();
            let userTransac = parentRow.find(".userTransac").val();

            $.ajax({
                url: '../controleurs/c_gestStock.php?action=ajoutTransaction',
                method: 'POST',
                data: {
                    'idProduit': idProduit,
                    'quantite': quantite,
                    'commentaire': commentaire,
                    'tDate': dateTransaction,
                    'idUser': idUser,
                    'dateExp': dateExp,
                    'prixUnitaire': prixUnitaire,
                    'userTransac' : userTransac
                },
                success: function (reponse) {
                    $('#successMessage').text('Modification enregistrée avec succès!');
                    $('#successModal').modal('show');
                },
                error: function () {
                    $('#errorMessage').text('Une erreur s\'est produite lors de la modification.');
                    $('#errorModal').modal('show');
                }
            });
        }
    });

    $('.remove').click(function () {
        let parentRow = $(this).closest('tr');
        var idProduit = parentRow.find('.idProduit').val();

        $.ajax({
            url: '../controleurs/c_gestStock.php?action=deleteProduit',
            method: 'POST',
            data: {
                'idProduit': idProduit,
            },
            success: function (reponse) {
                $('#successMessage').text('Produit supprimé avec succès!');
                $('#successModal').modal('show');
                parentRow.remove();
            },
            error: function () {
                $('#errorMessage').text('Une erreur s\'est produite lors de la suppression du produit.');
                $('#errorModal').modal('show');
            }
        });
    });
});
