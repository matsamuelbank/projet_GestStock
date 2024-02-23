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
                // Le mot de passe est incorrect
                $_SESSION['error'] = "Mot de passe incorrect. Veuillez réessayer.";
                header('Location: ../index.php');
            }
        } else {
            // L'utilisateur n'a pas été trouvé
            $_SESSION['error'] = "Utilisateur non trouvé. Veuillez réessayer.";
            header('Location: ../index.php');
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
