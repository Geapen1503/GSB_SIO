<?php

use Outils\Utilitaires;


$mois = Utilitaires::getMois(date('d/m/Y'));
$numAnnee = substr($mois, 0, 4);
$numMois = substr($mois, 4, 2);
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$idVisiteur = $_SESSION['idVisiteur'];
switch ($action) {
    case 'afficherVisiteurs':
        $visiteurs = $pdo->getAllVisiteur();
        include PATH_VIEWS .'v_listeVisiteursMoisComptable.php';
        break;
    case 'selectionnerMois':
        if (isset($_POST['visiteur'])) {
            $visiteurLogin = $_POST['visiteur'];
            $visiteurId = $pdo->getVisiteurId($visiteurLogin);

            if ($visiteurId) {
                $visiteurMonths = $pdo->getMoisCloturesVisiteur($visiteurId);
                $visiteurSelectionne = $visiteurLogin; // Stockage du visiteur sélectionné
                include PATH_VIEWS . 'v_listeVisiteursMoisComptable.php';
            } else {
                $messageErreur = "Visiteur introuvable.";
                include PATH_VIEWS . 'v_erreurs.php';
            }
        } if (isset($_POST['mois'], $_POST['visiteur'])) {
            $mois = $_POST['mois'];
            $visiteurLogin = $_POST['visiteur'];

            // Récupérer les frais et autres informations liées au mois et au visiteur
            $lesFraisForfait = $pdo->getLesFraisForfait($visiteurLogin, $mois);
            $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($visiteurLogin, $mois);

            // Assigner les valeurs pour afficher la vue de l'état des frais
            $moisSelectionne = $mois;
            $visiteurSelectionne = $visiteurLogin;
        }

    case 'afficherFicheFrais':
        if (isset($_POST['visiteur'], $_POST['mois'])) {
            $visiteurLogin = $_POST['visiteur'];
            $mois = $_POST['mois'];
            $visiteurId = $pdo->getVisiteurId($visiteurLogin);

            if ($visiteurId) {
                // Récupérer les données nécessaires
                $visiteurs = $pdo->getAllVisiteur();
                $visiteurMonths = $pdo->getMoisCloturesVisiteur($visiteurId);
                $lesFraisForfait = $pdo->getLesFraisForfait($visiteurId, $mois);
                $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($visiteurId, $mois);

                // Variables pour la sélection
                $visiteurSelectionne = $visiteurLogin;
                $moisSelectionne = $mois;

                // Inclure la vue avec les variables nécessaires
                include PATH_VIEWS . 'v_etatFraisComptable.php';
            } else {
                $messageErreur = "Données invalides.";
                include PATH_VIEWS . 'v_erreurs.php';
            }
        }
        break;
    case 'corrigerFraisForfait':
        if (isset($_POST['visiteur'], $_POST['mois'], $_POST['lesFrais'])) {
            $visiteurLogin = $_POST['visiteur'];
            $mois = $_POST['mois'];
            $lesFrais = $_POST['lesFrais'];

            // Récupérer l'ID visiteur
            $visiteurId = $pdo->getVisiteurId($visiteurLogin);

            // Mise à jour des frais forfaitisés
            $pdo->setLesFraisForfait($visiteurId, $mois, $lesFrais);

            // Récupérer les données mises à jour pour les afficher à nouveau
            $lesFraisForfait = $pdo->getLesFraisForfait($visiteurId, $mois);
            $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($visiteurId, $mois);

            // Passer à nouveau les informations pour réafficher les champs de sélection
            $visiteurs = $pdo->getAllVisiteur();
            $visiteurMonths = $pdo->getMoisCloturesVisiteur($visiteurId);

            // Variables de sélection
            $visiteurSelectionne = $visiteurLogin;
            $moisSelectionne = $mois;

            // Inclure la vue
            include PATH_VIEWS . 'v_etatFraisComptable.php';
        }
        break;
   
    case 'corrigerFraisHorsForfait':
        if (isset($_POST['visiteur'], $_POST['mois'], $_POST['idFrais'], $_POST['date'], $_POST['libelle'], $_POST['montant'])) {
            $visiteurLogin = $_POST['visiteur'];
            $mois = $_POST['mois'];
            $idFrais = $_POST['idFrais'];

            // Récupérer l'ID visiteur
            $visiteurId = $pdo->getVisiteurId($visiteurLogin);

            // Préparer les nouvelles données pour le frais hors forfait
            $nouveauFrais = [
                'date' => $_POST['date'],
                'libelle' => $_POST['libelle'],
                'montant' => $_POST['montant']
            ];

            // Mettre à jour le frais hors forfait dans la base de données
            $pdo->setLesFraisHorsForfait($visiteurId, $mois, [$idFrais => $nouveauFrais]);

            // Récupérer les données mises à jour pour les afficher à nouveau
            $lesFraisForfait = $pdo->getLesFraisForfait($visiteurId, $mois);
            $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($visiteurId, $mois);

            // Passer à nouveau les informations pour réafficher les champs de sélection
            $visiteurs = $pdo->getAllVisiteur();
            $visiteurMonths = $pdo->getMoisCloturesVisiteur($visiteurId);

            // Variables de sélection
            $visiteurSelectionne = $visiteurLogin;
            $moisSelectionne = $mois;

            // Inclure la vue
            include PATH_VIEWS . 'v_etatFraisComptable.php';
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
        include PATH_VIEWS .'v_accueil.php';
        break;
}

