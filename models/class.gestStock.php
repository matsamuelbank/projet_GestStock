<?php

/** Classe d'acces aux donnees. 
 */

class PdoGestStock
{
    private static $serveur = 'mysql:host=localhost';
    private static $bdd = 'dbname=geststock';
    private static $user = 'root';
    private static $mdp = 'root';
    private static $monPdo;
    private static $monPdoGsb = null;

    private function __construct()
    {
        PdoGestStock::$monPdo = new PDO(PdoGestStock::$serveur . ';' . PdoGestStock::$bdd, PdoGestStock::$user, PdoGestStock::$mdp);
        //PdoGsb::$monPdo->query("SET CHARACTER SET utf8");SET client_encoding = 'UTF8'; 
    }

    public function _destruct()
    {
        PdoGestStock::$monPdo = null;
    }

    public  static function getPdoGestStock()
    {
        if (PdoGestStock::$monPdoGsb == null) {
            PdoGestStock::$monPdoGsb = new PdoGestStock();
        }
        return PdoGestStock::$monPdoGsb;
    }


    public function rechercherUtilisateur($login)
    {
        $req = "SELECT * FROM utilisateurs WHERE uLogin = :login;";

        $stmt = PdoGestStock::$monPdo->prepare($req);
        $stmt->bindParam(':login', $login, PDO::PARAM_STR);

        if (!$stmt->execute()) {
            afficherErreurSQL("Problème lors de la recherche de l'utilisateur.", $req, PdoGestStock::$monPdo->errorInfo());
        }
        $infoUser = $stmt->fetch();
        return $infoUser;
    }

    public function getCommentaires($idFilm)
    {
        $req = "SELECT commentaire.coText, utilisateur.uPseudo, notation.note, commentaire.coIdFilm
        FROM commentaire 
        INNER JOIN utilisateur ON utilisateur.uId = commentaire.coIdUtilisateur
        INNER JOIN notation ON utilisateur.uId = notation.nIdUtilisateur AND commentaire.coIdFilm = notation.nIdFilm
        WHERE commentaire.coIdFilm =:idFilm";

        $stmt = PdoGestStock::$monPdo->prepare($req);
        $stmt->bindParam(':idFilm', $idFilm);

        if (!$stmt->execute()) {
            afficherErreurSQL("Problème lors de la récupération des commentaires.", $req, PdoGestStock::$monPdo->errorInfo());
        }

        $lesCommentaires = $stmt->fetchAll();
        return $lesCommentaires;
    }


    public function addCommentaire($valueCommentaire, $coDateDePublication, $coIdFilm, $coIdUtilisateur)
    {
        $req = 'INSERT INTO commentaire (coText, coDateDePublication,coIdFilm,coIdUtilisateur) 
        VALUE(:coText, :coDateDePublication,:coIdFilm,:coIdUtilisateur)';

        $stmt = PdoGestStock::$monPdo->prepare($req);
        $stmt->bindParam(':coText', $valueCommentaire);
        $stmt->bindParam(':coDateDePublication', $coDateDePublication);
        $stmt->bindParam(':coIdFilm', $coIdFilm);
        $stmt->bindParam(':coIdUtilisateur', $coIdUtilisateur);

        if (!$stmt->execute()) {
            afficherErreurSQL("Problème lors de l'insertion du commentaire.", $req, PdoGestStock::$monPdo->errorInfo());
        } else {
            return true;
        }
    }

    public function addArticle($nomProduit, $quantite, $prixUnitaire, $dateExp, $commentaire, $idUtilisateur)
    {
        $req = 'INSERT INTO articles (aNom, aQuantite, aPrixUnitaire, aDateExpiration, aImageUrl, aCommentaire, uId) 
        VALUES (:aNom, :aQuantite, :aPrixUnitaire, :aDateExpiration, NULL, :aCommentaire, :uId)';

        $stmt = PdoGestStock::$monPdo->prepare($req);
        $stmt->bindParam(':aNom', $nomProduit);
        $stmt->bindParam(':aQuantite', $quantite);
        $stmt->bindParam(':aPrixUnitaire', $prixUnitaire);
        $stmt->bindParam(':aDateExpiration', $dateExp);
        $stmt->bindParam(':aCommentaire', $commentaire);
        $stmt->bindParam(':uId', $idUtilisateur);

        if (!$stmt->execute()) {
            afficherErreurSQL("Problème lors de l'insertion de l'article.", $req, PdoGestStock::$monPdo->errorInfo());
        } else {
            // Retourne l'ID du nouvel article inséré
            return PdoGestStock::$monPdo->lastInsertId();
        }
    }


    public function addTransaction($tArticleId, $tQuantite, $tDate, $tType, $tCommentaire, $uId)
    {
        $req = 'INSERT INTO transactions (tArticleId, tQuantite, tDate, tType, tCommentaire, transactions.uId) 
        VALUES (:tArticleId, :tQuantite, :tDate, :tType, :tCommentaire, :uId)';

        $stmt = PdoGestStock::$monPdo->prepare($req);
        $stmt->bindParam(':tArticleId', $tArticleId);
        $stmt->bindParam(':tQuantite', $tQuantite);
        $stmt->bindParam(':tDate', $tDate);
        $stmt->bindParam(':tType', $tType);
        $stmt->bindParam(':tCommentaire', $tCommentaire);
        $stmt->bindParam(':uId', $uId);

        if (!$stmt->execute()) {
            afficherErreurSQL("Problème lors de l'insertion de la transaction.", $req, PdoGestStock::$monPdo->errorInfo());
        } else {
            return true;
        }
    }

    public function updateTransaction($idArticle, $quantite, $tDate, $tType, $commentaire, $idUtilisateur)
    {
        $req = 'UPDATE transactions 
        SET tQuantite = :tQuantite, 
            tDate = :tDate, 
            tType = :tType, 
            tCommentaire = :tCommentaire 
        WHERE tArticleId = :tArticleId AND uId = :uId';

        $stmt = PdoGestStock::$monPdo->prepare($req);
        $stmt->bindParam(':tQuantite', $quantite);
        $stmt->bindParam(':tDate', $tDate);
        $stmt->bindParam(':tType', $tType);
        $stmt->bindParam(':tCommentaire', $commentaire);
        $stmt->bindParam(':tArticleId', $idArticle);
        $stmt->bindParam(':uId', $idUtilisateur);

        if (!$stmt->execute()) {
            afficherErreurSQL("Problème lors de la mise à jour de la transaction.", $req,  PdoGestStock::$monPdo->errorInfo());
        } else {
            return true;
        }
    }

    public function updateArticle($idArticle, $quantite, $prixUnitaire, $dateExp, $commentaire, $idUtilisateur)
    {
        $req = 'UPDATE articles 
        SET aQuantite = :aQuantite, 
            aPrixUnitaire = :aPrixUnitaire, 
            aDateExpiration = :aDateExpiration, 
            aCommentaire = :aCommentaire 
        WHERE aId = :aId AND uId = :uId';

        $stmt = PdoGestStock::$monPdo->prepare($req);
        $stmt->bindParam(':aQuantite', $quantite);
        $stmt->bindParam(':aPrixUnitaire', $prixUnitaire);
        $stmt->bindParam(':aDateExpiration', $dateExp);
        $stmt->bindParam(':aCommentaire', $commentaire);
        $stmt->bindParam(':aId', $idArticle);
        $stmt->bindParam(':uId', $idUtilisateur);

        if (!$stmt->execute()) {
            afficherErreurSQL("Problème lors de la mise à jour de l'article.", $req, PdoGestStock::$monPdo->errorInfo());
        } else {
            return true;
        }
    }



    public function getAllProducts()
    {
        $req = 'SELECT * FROM articles ORDER BY aDateExpiration ASC';
        $stmt = PdoGestStock::$monPdo->prepare($req);

        if (!$stmt->execute()) {
            afficherErreurSQL("Problème lors de la récupération des articles.", $req, PdoGestStock::$monPdo->errorInfo());
        } else {
            $products = $stmt->fetchAll();
            return $products;
        }
    }

    public function getMaxIdArticle()
    {
        $req = 'SELECT MAX(aId) from articles';
        $stmt = PdoGestStock::$monPdo->prepare($req);

        if (!$stmt->execute()) {
            afficherErreurSQL("Problème lors de la récupération de l'identifiant.", $req, PdoGestStock::$monPdo->errorInfo());
        } else {
            $idArticle = $stmt->fetchAll();
            return $idArticle;
        }
    }

    public function getTransactions()
    {
        $req = 'SELECT aId,aNom,aPrixUnitaire, aDateExpiration,tId,tDate,tQuantite,tCommentaire from articles
        INNER JOIN transactions on transactions.tArticleId = articles.aId ORDER BY tDate DESC';
        $stmt = PdoGestStock::$monPdo->prepare($req);

        if (!$stmt->execute()) {
            afficherErreurSQL("Problème lors de la récupération des transactions.", $req, PdoGestStock::$monPdo->errorInfo());
        } else {
            $lesTransactions = $stmt->fetchAll();
            return $lesTransactions;
        }
    }

    public function getQuantite($idArticle)
    {
        $req = ' select articles.aQuantite from articles where articles.aId = :idArticle';
        $stmt = PdoGestStock::$monPdo->prepare($req);

        $stmt->bindParam(':idArticle', $idArticle);

        if (!$stmt->execute()) {
            afficherErreurSQL("Problème lors de la récupération de la quantité.", $req, PdoGestStock::$monPdo->errorInfo());
        } else {
            $quantite = $stmt->fetchColumn(); // recupère directement la valeur de la colonne 
            return $quantite;
        }
    }

    public function supprimerTransactionParArticle($idArticle)
    {
        $req = 'DELETE FROM transactions WHERE tArticleId = :idArticle';
        $stmt = PdoGestStock::$monPdo->prepare($req);
        $stmt->bindParam(':idArticle', $idArticle);
    
        if (!$stmt->execute()) {
            afficherErreurSQL("Problème lors de la suppression des transactions liées à l'article.", $req, PdoGestStock::$monPdo->errorInfo());
        } else {
            return true;
        }
    }
    
    
    public function supprimerArticle($idArticle)
    {
        $req = 'DELETE FROM articles WHERE aId = :idArticle';
        $stmt = PdoGestStock::$monPdo->prepare($req);
        $stmt->bindParam(':idArticle', $idArticle);

        if (!$stmt->execute()) {
            afficherErreurSQL("Problème lors de la suppression de l'article.", $req, PdoGestStock::$monPdo->errorInfo());
        } else {
            return true;
        }
    }
}
