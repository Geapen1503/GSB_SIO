<?php

/**
 * Gestion de la connexion
 *
 * PHP Version 8
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */

use Outils\Utilitaires;

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if (!$uc) {
    $uc = 'demandeconnexion';
}

switch ($action) {
    case 'demandeConnexion':
        include PATH_VIEWS . 'v_connexion.php';
        break;
    case 'valideConnexion':
        $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $mdp = filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $visiteur = $pdo->getInfosVisiteur($login);
        $comptable = $pdo->getInfosComptable($login);

        $comptablePassword = password_verify($mdp,$pdo->getMdpComptable($login) ?? '');
        if (!$comptablePassword) $visiteurPassword = password_verify($mdp,$pdo->getMdpVisiteur($login) ?? '');

        if (!password_verify($mdp,$pdo->getMdpVisiteur($login) ?? '') && !password_verify($mdp,$pdo->getMdpComptable($login) ?? '')) {
            Utilitaires::ajouterErreur('Login ou mot de passe incorrect');
            include PATH_VIEWS . 'v_erreurs.php';
            include PATH_VIEWS . 'v_connexion.php';
        } elseif ($visiteurPassword) {
            $id = $visiteur['id'];
            $nom = $visiteur['nom'];
            $prenom = $visiteur['prenom'];
            Utilitaires::connecter($id, $nom, $prenom);
            $_SESSION['typeUtilisateur'] = 'visiteur';
            header('Location: index.php?uc=accueil');
        } elseif ($comptablePassword) {
            $id = $comptable['id'];
            $nom = $comptable['nom'];
            $prenom = $comptable['prenom'];
            Utilitaires::connecter($id, $nom, $prenom);
            $_SESSION['typeUtilisateur'] = 'comptable';
            header('Location: index.php?uc=accueil');
        }
        break;
    default:
        include PATH_VIEWS . 'v_connexion.php';
        break;
}
