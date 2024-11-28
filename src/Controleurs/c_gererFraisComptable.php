<?php

use Outils\Utilitaires;


$mois = Utilitaires::getMois(date('d/m/Y'));
$numAnnee = substr($mois, 0, 4);
$numMois = substr($mois, 4, 2);
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

switch ($action) {
    case 'afficherVisiteurs':
        $visiteurs = $pdo->getAllVisiteur();
        include PATH_VIEWS . 'v_listeVisiteursComptable.php';
        break;
    case 'selectionnerMois':
        if (isset($_POST['visiteur'])) {
            $visiteurLogin = $_POST['visiteur'];
            $visiteurId = $pdo->getVisiteurId($visiteurLogin);

            if ($visiteurId) {
                $visiteurMonths = $pdo->getMoisCloturesVisiteur($visiteurId);
                include 'vues/v_listeMoisComptable.php';
            } else {
                $messageErreur = "Visiteur introuvable";
                include 'vues/v_erreurs.php';
            }
        }
        break;
    case 'afficherFicheFrais':
        if (isset($_POST['visiteur']) && isset($_POST['mois'])) {
            $visiteurLogin = $_POST['visiteur'];
            $mois = $_POST['mois'];
            $visiteurId = $pdo->getVisiteurId($visiteurLogin);

            if ($visiteurId) {
                $lesFraisForfait = $pdo->getLesFraisForfait($visiteurId, $mois);
                $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($visiteurId, $mois);
                include 'vues/v_etatFraisComptable.php';
            } else {
                $messageErreur = "Données invalides.";
                include 'vues/v_erreurs.php';
            }
        }
        break;
    case 'corrigerFrais':
        if (isset($_POST['visiteur'], $_POST['mois'], $_POST['lesFrais'])) {
            $visiteurId = $pdo->getVisiteurId($_POST['visiteur']);
            $mois = $_POST['mois'];
            $frais = $_POST['lesFrais'];

            $pdo->setLesFraisForfait($visiteurId, $mois, $frais);

            $lesFraisForfait = $pdo->getLesFraisForfait($visiteurId, $mois);
            $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($visiteurId, $mois);

            include 'vues/v_etatFraisComptable.php';
        }
        break;
    case 'reinitialiserFrais':
        if (isset($_POST['visiteur'], $_POST['mois'])) {
            $visiteurId = $pdo->getVisiteurId($_POST['visiteur']);
            $mois = $_POST['mois'];

            $pdo->resetLesFraisForfait($visiteurId, $mois);

            $lesFraisForfait = $pdo->getLesFraisForfait($visiteurId, $mois);
            $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($visiteurId, $mois);

            include 'vues/v_etatFraisComptable.php';
        }
        break;
    case 'genererPDF':
        if (isset($_POST['visiteur'], $_POST['mois'])) {
            $visiteurLogin = $_POST['visiteur'];
            $mois = $_POST['mois'];

            include '../tools/generate_pdf.php';
        }
        break;
    default:
        include 'vues/v_accueil.php';
        break;
}

