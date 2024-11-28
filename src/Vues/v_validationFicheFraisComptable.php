<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

use Modeles\PdoGsb;

$pdo = PdoGsb::getPdoGsb();
$visiteurs = $pdo->getAllVisiteur();


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>


<?php
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
?>

<div class="form-section">
    <?php if (!empty($newDate)) {?>
    <h2>Valider la fiche de frais</h2>
    <div class="row">
        <h3>Eléments forfaitisés</h3>
        <div class="col-md-4">
            <form method="post" action="" role="form">
                <fieldset>
                    <?php
                    if (isset($_POST['CorrigerSubmit']) && isset($_POST['mois']) && isset($_POST['lesFrais'])) {
                        $pdo->setLesFraisForfait($visiteurId, $newDate, $_POST['lesFrais']);
                        $lesFraisForfait = $pdo->getLesFraisForfait($visiteurId, $newDate);
                    }

                    if (isset($_POST['ResetSubmit']) && isset($newDate)) {
                        $pdo->resetLesFraisForfait($visiteurId, $newDate);
                        $lesFraisForfait = $pdo->getLesFraisForfait($visiteurId, $newDate);
                    }

                    if (isset($lesFraisForfait)) {
                        foreach ($lesFraisForfait as $unFrais) {
                            $idFrais = $unFrais['idfrais'];
                            $libelle = htmlspecialchars($unFrais['libelle']);
                            $quantite = $unFrais['quantite'];
                            ?>
                            <div class="form-group">
                                <label for="idFrais"><?php echo $libelle ?></label>
                                <input type="text" id="idFrais"
                                       name="lesFrais[<?php echo $idFrais ?>]"
                                       size="10" maxlength="5"
                                       value="<?php echo $quantite ?>"
                                       class="form-control">
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <input type="hidden" name="visiteur" value="<?php echo htmlspecialchars($visiteurLogin); ?>">
                    <input type="hidden" name="mois" value="<?php echo htmlspecialchars($newDate); ?>">
                    <button class="btn btn-success" name="CorrigerSubmit" type="submit">Corriger</button>
                    <button class="btn btn-danger" name="ResetSubmit" type="submit">Réinitialiser</button>
                </fieldset>
            </form>
        </div>
    </div>
    <?php } ?>
</div>

<?php if (!empty($newDate)) {?>
    <div class="row">
        <div class="panel panel-orange">
            <div class="panel-heading">Descriptif des éléments hors forfait</div>
            <table class="table table-bordered table-orange">
                <thead>
                <tr class="border-org">
                    <th class="date">Date</th>
                    <th class="libelle">Libellé</th>
                    <th class="montant">Montant</th>
                    <th class="action">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($visiteurId, $newDate);

                foreach ($lesFraisHorsForfait as $unHorsFrais) {
                    $dateHorsFrais = $unHorsFrais['date'];
                    $horsLibelle = htmlspecialchars($unHorsFrais['libelle']);
                    $horsMontant = $unHorsFrais['montant'];
                    ?>
                    <tr>
                        <td class="date">
                            <input type="text" name="dateFrais[<?php echo $idFraisHorsForfait; ?>]" value="<?php echo $dateHorsFrais; ?>" class="form-control">
                        </td>
                        <td class="libelle">
                            <input type="text" name="libelleFrais[<?php echo $idFraisHorsForfait; ?>]" value="<?php echo $horsLibelle; ?>" class="form-control">
                        </td>
                        <td class="montant">
                            <input type="text" name="montantFrais[<?php echo $idFraisHorsForfait; ?>]" value="<?php echo $horsMontant; ?>" class="form-control">
                        </td>
                        <td class="action">
                            <button class="btn btn-success btn-sm" name="corrigerHorsForfaitButton" type="button">Corriger</button>
                            <button class="btn btn-danger btn-sm" type="button">Réinitialiser</button>

                            <?php // untested
                            if (isset($_POST['corrigerHorsForfaitButton'])) {
                                //$pdo->setLesFraisHorsForfait($visiteurId, );
                                //$lesFraisForfait = $pdo->getLesFraisForfait($visiteurId, $newDate);
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
        <form method="POST" action="../fpdf/scriptToPDF.php">
            <input type="hidden" name="visiteur" value="<?php echo htmlspecialchars($visiteurLogin); ?>">
            <input type="hidden" name="mois" value="<?php echo htmlspecialchars($newDate); ?>">
            <button type="submit" href="../fpdf/scriptToPDF.php" class="btn btn-primary">Générer le PDF</button>
        </form>
    </div>
<?php } ?>

</body>
</html>