<?php

use Modeles\PdoGsb;

$pdo = PdoGsb::getPdoGsb();
$visiteurs = $pdo->getAllVisiteur();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valider la fiche de frais</title>
</head>
<body>

<?php
if (isset($_POST['visiteur'])) {
    $visiteurLogin = $_POST['visiteur'];
    echo "Le visiteur sélectionné est : " . htmlspecialchars($visiteurLogin);

    $visiteurId = $pdo->getVisiteurId(htmlspecialchars($visiteurLogin));
    $visiteurMonths = $pdo->getAllMoisVisiteur($visiteurId);

} else {
    ?>
    <form method="POST" action="">
        <div class="visiteur-choice-section">
            <label for="visiteur">Choisir le visiteur :</label>
            <input list="visiteurs" name="visiteur" id="visiteur" placeholder="Taper pour rechercher...">
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
    <?php
}

if (isset($visiteurMonths)) {
    ?>
    <form method="POST" action="">
        <div class="mois-choice-section">
            <label for="mois">Choisir le mois :</label>
            <select name="mois" id="mois">
                <?php foreach ($visiteurMonths as $month) : ?>
                    <option value="<?php echo htmlspecialchars($month['mois']); ?>">
                        <?php echo substr($month['mois'], 0, 4) . '/' . substr($month['mois'], 4, 2); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <input type="hidden" name="visiteur" value="<?php echo htmlspecialchars($visiteurLogin); ?>">
        <input type="submit" value="Valider">
    </form>
    <?php
}

$newDate = null;

if (isset($_POST['mois']) && isset($_POST['visiteur'])) {
    $moisSelectionne = $_POST['mois'];
    $visiteurLogin = $_POST['visiteur'];

    $newDate = $moisSelectionne;
    echo "Le mois sélectionné est : " . substr($month['mois'], 0, 4) . '/' . substr($month['mois'], 4, 2);


    $visiteurId = $pdo->getVisiteurId(htmlspecialchars($visiteurLogin));
    $lesFraisForfait = $pdo->getLesFraisForfait($visiteurId, $newDate);
}
?>

<div class="form-section">
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
</div>

<div class="row">
    <table class="panel panel-info">
        <div class="panel-heading">Descriptif des éléments hors forfait</div>
        <table class="table table-bordered table-responsive">
            <thead>
            <tr>
                <th class="date">Date</th>
                <th class="libelle">Libellé</th>
                <th class="montant">Montant</th>
                <th class="action">&nbsp;</th>
                <form action="index.php?uc=gererFrais&action=validerCreationFrais" method="post" role="form">
                    <?php
                    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($visiteurId, $newDate);
                    foreach ($lesFraisHorsForfait as $unHorsFrais) {
                        $dateHorsFrais = $unHorsFrais['date'];
                        $horsLibelle = htmlspecialchars($unHorsFrais['libelle']);
                        $horsMontant = $unHorsFrais['montant'];
                        ?>
                        <tr>
                            <th class="date"><?php echo $dateHorsFrais; ?></th>
                            <th class="libelle"><?php echo $horsLibelle; ?></th>
                            <th class="montant"><?php echo $horsMontant; ?></th>
                            <th class="action">
                                <button class="btn btn-success" type="submit">Corriger</button>
                                <button class="btn btn-danger" type="reset">Réinitialiser</button>
                            </th>
                        </tr>
                        <?php
                    }
                    ?>
                </form>
            </tr>
            </thead>
        </table>
        <form method="POST" action="../tools/generate_pdf.php">
            <input type="hidden" name="visiteur" value="<?php echo htmlspecialchars($visiteurLogin); ?>">
            <input type="hidden" name="mois" value="<?php echo htmlspecialchars($newDate); ?>">
            <button type="submit" class="btn btn-primary">Générer le PDF</button>
        </form>
</div>
</div>

</body>
</html>
