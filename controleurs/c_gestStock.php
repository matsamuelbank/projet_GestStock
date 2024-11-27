<?php
require_once('../models/class.gestStock.php');

class GestionStock
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = PdoGestStock::getPdoGestStock();
    }

    public function filterData($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function accueil()
    {
        $lesProduits =  $this->pdo->getAllProducts();
        include('../vues/inventaire.php');
    }

    public function ajoutArticle($nomProduit, $quantite, $prixUnitaire, $dateExp, $commentaire, $idUtilisateur)
    {
        // Vérifie que les champs obligatoires ne sont pas vides
        if (!empty($nomProduit) && !empty($quantite) && !empty($prixUnitaire) && !empty($dateExp) && !empty($commentaire)) {
            // On obtient l'id du nouvel article inséré
            $tArticleId = $this->pdo->addArticle($nomProduit, $quantite, $prixUnitaire, $dateExp, $commentaire, $idUtilisateur);

            $tDate = date('Y-m-d');
            $tType = 'ENTREE';

            $this->pdo->addTransaction($tArticleId, $quantite, $tDate, $tType, $commentaire, $idUtilisateur);
        }
        // Si un des champs obligatoires est vide, ne rien faire
    }

    public function ajoutTransaction($idArticle, $quantite, $tDate, $commentaire, $idUtilisateur, $dateExp, $prixUnitaire, $userTransac)
    {
        $ancienneQuantite = $this->pdo->getQuantite($idArticle);
        $tType = 'ENTREE'; // Par défaut c'est une entrée

        if ($quantite < $ancienneQuantite) {
            $tType = 'SORTIE'; // Si la nouvelle quantité est inférieure à l'ancienne, c'est une sortie
        } elseif ($quantite > $ancienneQuantite) {
            $tType = 'ENTREE'; // Si la nouvelle quantité est supérieure à l'ancienne, c'est une entrée
        }


        $this->pdo->updateArticle($idArticle, $quantite, $prixUnitaire, $dateExp, $commentaire, $idUtilisateur);
        $this->pdo->updateTransaction($idArticle, $quantite, $tDate, $tType, $commentaire, $idUtilisateur, $userTransac);

        if($quantite >10)
        {
            $this->pdo->removeAlert($idArticle,$quantite);
        }
        else{
            if (!$this->pdo->alertExists($idArticle)) {
                $this->pdo->addAlertProduct($idArticle, $quantite);
            }
        }
    }

    public function deleteProduit($idArticle)
    {
        $this->pdo->supprimerTransactionParArticle($idArticle);
        $this->pdo->supprimerArticle($idArticle);
    }

    public function gestionDesStocks()
    {
        $lesTransactions = $this->pdo->getTransactions();
        include('../vues/gestionDesStocks.php');
    }

    public function suiviDesStocks()
    {
        $lesProduits = $this->pdo->getAllProducts();

        foreach ($lesProduits as $leProduit) {
            $alArticleId = $leProduit['aId'];
            $alSeuil = $leProduit['aQuantite'];

            // Si la quantité est inférieure ou égale à 10, on ajoute une alerte si elle n'existe pas
            if ($leProduit['aQuantite'] <= 10) {
                if (!$this->pdo->alertExists($alArticleId)) {
                    $this->pdo->addAlertProduct($alArticleId, $alSeuil);
                }
            }
           
        }

        $lesAlertes = $this->pdo->getAllAlerts();
        include('../vues/suiviDesStocks.php');
    }
}

$action = new GestionStock();

try {
    if (isset($_REQUEST['action'])) {
        if ($_REQUEST['action'] == 'accueil') {
            $action->accueil();
        }

        if ($_REQUEST['action'] == 'addArticle') {
            if (isset($_POST['nomProduit'], $_POST['quantite'], $_POST['prixUnitaire'], $_POST['commentaire'], $_POST['dateExp'], $_POST['idUser'])) {
                $nomProduit = $action->filterData($_POST['nomProduit']);
                $quantite = $action->filterData($_POST['quantite']);
                $prixUnitaire = $action->filterData($_POST['prixUnitaire']);
                $commentaire = $action->filterData($_POST['commentaire']);
                $dateExp = $_POST['dateExp'];
                $idUtilisateur = $action->filterData($_POST['idUser']);

                $action->ajoutArticle($nomProduit, $quantite, $prixUnitaire, $dateExp, $commentaire, $idUtilisateur);
            }
        }
        if ($_REQUEST['action'] == 'gestionDesStocks') {
            $action->gestionDesStocks();
        }

        if ($_REQUEST['action'] == 'suiviDesStocks') {
            $action->suiviDesStocks();
        }


        if ($_REQUEST['action'] == 'ajoutTransaction') {
            if (isset($_POST['idProduit'], $_POST['quantite'], $_POST['commentaire'], $_POST['tDate'], $_POST['idUser'], $_POST["dateExp"], $_POST["prixUnitaire"], $_POST["userTransac"])) {
                $idArticle = $action->filterData($_POST['idProduit']);
                $quantite = $action->filterData($_POST['quantite']);
                $commentaire = $action->filterData($_POST['commentaire']);
                $tDate = $_POST['tDate'];
                $idUtilisateur = $action->filterData($_POST['idUser']);
                $dateExp = $_POST["dateExp"];
                $prixUnitaire = $action->filterData($_POST["prixUnitaire"]);
                $userTransac = $action->filterData($_POST["userTransac"]);

                $action->ajoutTransaction($idArticle, $quantite, $tDate, $commentaire, $idUtilisateur, $dateExp, $prixUnitaire, $userTransac);
            }
        }

        if ($_REQUEST['action'] == 'deleteProduit') {
            if (isset($_POST['idProduit'])) {
                $idArticle = $action->filterData($_POST['idProduit']);

                $action->deleteProduit($idArticle, $quantite, $tDate, $commentaire, $idUtilisateur, $dateExp, $prixUnitaire);
            }
        }
    }
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
