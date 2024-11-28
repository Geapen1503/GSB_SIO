<?php

/**
 * Vue Liste des mois
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
 * @link      https://getbootstrap.com/docs/3.3/ Documentation Bootstrap v3
 */

use Modeles\PdoGsb;

$pdo = PdoGsb::getPdoGsb();
$visiteurs = $pdo->getAllVisiteur();

?>


<?php if ($_SESSION['typeUtilisateur'] == 'visiteur') { ?>
<h2>Mes fiches de frais</h2>
<div class="row">
    <div class="col-md-4">
        <h3>Sélectionner un mois : </h3>
    </div>
    <div class="col-md-4">
        <form action="index.php?uc=etatFrais&action=voirEtatFrais" 
              method="post" role="form">
            <div class="form-group">
                <label for="lstMois" accesskey="n">Mois : </label>
                <select id="lstMois" name="lstMois" class="form-control">
                    <?php
                    foreach ($lesMois as $unMois) {
                        $mois = $unMois['mois'];
                        $numAnnee = $unMois['numAnnee'];
                        $numMois = $unMois['numMois'];
                        if ($mois == $moisASelectionner) {
                            ?>
                            <option selected value="<?php echo $mois ?>">
                                <?php echo $numMois . '/' . $numAnnee ?> </option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo $mois ?>">
                                <?php echo $numMois . '/' . $numAnnee ?> </option>
                            <?php
                        }
                    }
                    ?>    

                </select>
            </div>
            <input id="ok" type="submit" value="Valider" class="btn btn-success" 
                   role="button">
            <input id="annuler" type="reset" value="Effacer" class="btn btn-danger"
                   role="button">
        </form>
    </div>
</div>
<?php } elseif ($_SESSION['typeUtilisateur'] == 'comptable') {

    if (isset($_POST['visiteur'])) {
        $visiteurLogin = $_POST['visiteur'];

        $visiteurId = $pdo->getVisiteurId($visiteurLogin);

        if ($visiteurId === false || empty($visiteurId)) {
        ?> <p id="warn"> <?php echo "Ce visiteur n'existe pas. Veuillez réessayer." ?> </p> <?php
        $visiteurValide = false;
        } else {
            echo "Le visiteur sélectionné est : " . htmlspecialchars($visiteurLogin);
            $visiteurValide = true;

            $visiteurMonths = $pdo->getAllMoisVisiteur($visiteurId);
        }
    } else {
        $visiteurValide = false;
    }
    ?>
    <?php if (!$visiteurValide): ?>
        <form method="POST" action="">
            <div class="visiteur-choice-section" id="top">
                <label for="visiteur">Choisir le visiteur :</label>
                <input list="visiteurs" name="visiteur" id="visiteur" placeholder="Taper pour rechercher..." value="<?php echo isset($visiteurLogin) ? htmlspecialchars($visiteurLogin) : ''; ?>">
                <datalist id="visiteurs">
                    <?php foreach ($visiteurs as $visiteur) : ?>
                        <option value="<?php echo htmlspecialchars($visiteur['login']); ?>">
                            <?php echo htmlspecialchars($visiteur['login']); ?>
                        </option>
                    <?php endforeach; ?>
                </datalist>
            </div>
            <input type="submit" value="Valider">
        </form>
    <?php endif; ?>
    <?php

    if (isset($visiteurMonths)) {
        ?>
        <form method="POST" action="">
            <div class="mois-choice-section">
                <label for="mois">Choisir le mois :</label>
                <select name="mois" id="mois">
                    <?php foreach ($visiteurMonths as $month) : ?>
                        <?php
                        $mois = $month['mois'];
                        $year = substr($mois, 0, 4);
                        $monthNumber = substr($mois, 4, 2);

                        $formattedDate = $monthNumber . '/' . $year;
                        ?>
                        <option value="<?php echo htmlspecialchars($mois); ?>">
                            <?php echo htmlspecialchars($formattedDate); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input type="hidden" name="visiteur" value="<?php echo htmlspecialchars($visiteurLogin); ?>">
            <input type="submit" value="Valider">
        </form>
        <?php
    }
    ?>

    <?php
    if (isset($_POST['mois'])) {
        $moisSelectionne = $_POST['mois'];

        $newDate = $moisSelectionne;
        echo "Le mois sélectionné est : " . htmlspecialchars($newDate);

        $lesFraisForfait = $pdo->getLesFraisForfait($visiteurId, $newDate);
    }
}

?>
