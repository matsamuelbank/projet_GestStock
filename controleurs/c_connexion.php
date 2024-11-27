<?php
require_once('../models/class.gestStock.php');

class UserAction {
    private $pdo;

    public function __construct() {
        $this->pdo = PdoGestStock::getPdoGestStock();
    }

    public function filterData($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function connexion($uLogin, $uMdp) {
        $infosUser = $this->pdo->rechercherUtilisateur($uLogin);
        if ($infosUser !== false) {
            $hashed_password = $infosUser['uMdp'];

            if (password_verify($uMdp, $hashed_password)) {
                session_start();
                $_SESSION['user'] = $infosUser;
                header('Location: c_gestStock.php?action=accueil');
            } else {
                $_SESSION['error'] = "Mot de passe incorrect. Veuillez réessayer.";
                header('Location: ../index.php');
            }
        } else {
            $_SESSION['error'] = "Utilisateur non trouvé. Veuillez réessayer.";
            header('Location: ../index.php');
        }
    }

    public function inscription($uNom, $uPrenom, $uLogin, $uMdp, $uMail) {
        $uNom = $this->filterData($uNom);
        $uPrenom = $this->filterData($uPrenom);
        $uLogin = $this->filterData($uLogin);
        $uMdp = $this->filterData($uMdp);
        $uMdp = password_hash($uMdp, PASSWORD_DEFAULT);
        $uMail = $this->filterData($uMail);

        $data = $this->pdo->addUser($uNom, $uPrenom,$uLogin, $uMdp, $uMail);
        if ($data) {
            header('Location: ../index.php');
        } else {
            $_SESSION['error'] = "Il y a eu une erreur lors de l'inscription. Veuillez réessayer.";
            header('Location: ../vues/inscription.php');
        }
    }
}

$action = new UserAction();

if ($_REQUEST['action'] == 'connexion') {
    if (isset($_POST['uLogin']) && isset($_POST['uMdp'])) {
        $uLogin = $action->filterData($_POST['uLogin']);
        $uMdp = $action->filterData($_POST['uMdp']);
        $action->connexion($uLogin, $uMdp);
    }
}

if ($_REQUEST['action'] == 'inscription') {
    if (
        isset($_POST['uNom']) && isset($_POST['uPrenom']) && isset($_POST['uLogin'])
        && isset($_POST['uMdp']) && isset($_POST['uMail'])
    ) {
        $uNom = $_POST['uNom'];
        $uPrenom = $_POST['uPrenom'];
        $uLogin = $_POST['uLogin'];
        $uMdp = $_POST['uMdp'];
        $uMail = $_POST['uMail'];

        $action->inscription($uNom, $uPrenom, $uLogin, $uMdp, $uMail);
    }
}