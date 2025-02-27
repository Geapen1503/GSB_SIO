<?php

use Outils\Utilitaires;

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if ($_SESSION['typeUtilisateur'] !== 'comptable') {
    header('Location: index.php');
    exit();
}

switch ($action) {
    case 'selectionnerVisiteur':
        $lesVisiteurs = $pdo->getAllVisiteur();
        include PATH_VIEWS . 'v_listeVisiteurComptableEtatFrais.php';
        break;

    case 'selectionnerMois':
        if (isset($_POST['visiteur'])) {
            $visiteurLogin = $_POST['visiteur'];
            $visiteurId = $pdo->getVisiteurId($visiteurLogin);

            if ($visiteurId) {
                $_SESSION['idVisiteurSelectionne'] = $visiteurId;
                $visiteurMonths = $pdo->getMoisCloturesVisiteur($visiteurId);
                include PATH_VIEWS .'v_listeMoisCompableHorsForfait.php';
            } else {
                $messageErreur = "Visiteur introuvable";
                include PATH_VIEWS .'v_erreurs.php';
            }
        }
        break;

    case 'voirEtatFrais':
        $idVisiteur = $_SESSION['idVisiteurSelectionne'] ?? '';
        $leMois = filter_input(INPUT_POST, 'mois', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!$idVisiteur || !$leMois) die('Erreur : ID visiteur ou mois manquant.');

        $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
        $moisASelectionner = $leMois;
        include PATH_VIEWS . 'v_listeMois.php';

        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
        $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
        $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $leMois);

        if (!$lesInfosFicheFrais) die('Aucune fiche de frais trouvée pour ce visiteur et ce mois.');

        $numAnnee = substr($leMois, 0, 4);
        $numMois = substr($leMois, 4, 2);
        $libEtat = $lesInfosFicheFrais['libEtat'];
        $montantValide = $lesInfosFicheFrais['montantValide'];
        $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
        $dateModif = Utilitaires::dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);

        include PATH_VIEWS . 'v_etatFrais.php';
        break;

}
