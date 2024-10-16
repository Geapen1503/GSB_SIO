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
    <title>Valider la fiche de frais</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header, .validation-section {
            margin: 20px 0;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header img {
            width: 100px;
        }
        .form-section, .table-section {
            margin-top: 20px;
        }
        label {
            margin-right: 10px;
        }
        input[type="text"], input[type="number"], select {
            padding: 5px;
            margin: 5px 0;
        }
        .forfait-section input[type="number"] {
            width: 100px;
        }
        .action-buttons {
            margin-top: 20px;
        }
        .action-buttons input {
            padding: 10px 20px;
            margin-right: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .table-section input[type="text"], .table-section input[type="number"] {
            width: 100%;
        }
    </style>
</head>
<body>


<form method="POST" action="">
    <div class="visiteur-choice-section">
        <label for="visiteur">Choisir le visiteur :</label>
        <input list="visiteurs" name="visiteur" id="visiteur" placeholder="Taper pour rechercher...">
        <datalist id="visiteurs">
            <?php foreach ($visiteurs as $visiteur): ?>
                <option value="<?= htmlspecialchars($visiteur['login']) ?>">
                    <?= htmlspecialchars($visiteur['login']) ?>
                </option>
            <?php endforeach; ?>
        </datalist>
    </div>
    <button type="submit">Valider</button>
</form>

<?php
if (isset($_POST['visiteur'])) {
    $visiteurLogin = $_POST['visiteur'];
    echo "Le visiteur sélectionné est : " . htmlspecialchars($visiteurLogin);
}
?>


<label for="mois">Mois:</label>
    <select name="mois" id="mois">

        <?php
        $visiteurId = $pdo->getVisiteurId(htmlspecialchars($visiteurLogin));
        $visiteurMonths = $pdo->getAllMoisVisiteur($visiteurId);


        ?>

    </select>

</div>
<div class="form-section">
    <h2>Valider la fiche de frais</h2>
    <div class="row">
        <h3>Eléments forfaitisés</h3>
        <div class="col-md-4">
            <form method="post"
                  action="index.php?uc=gererFrais&action=validerMajFraisForfait"
                  role="form">
                <fieldset>
                    <?php
                    $idVisiteur = $visiteurId;

                    //list($mois, $annee) = explode("/", $date);
                    //$leMois = $annee . str_pad($mois, 2, '0', STR_PAD_LEFT);

                    $dateUnformat = '03/10/2023'; // replace with geoffrey date selector system
                    echo $newDate = \Outils\Utilitaires::getMois($dateUnformat);

                    $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $newDate);


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
                    ?>
                    <button class="btn btn-success" type="submit">Corriger</button>
                    <button class="btn btn-danger" type="reset">Réinitialiser</button>
                </fieldset>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <h3>Descriptif des éléments hors forfait</h3>
    <div class="col-md-4">
        <form action="index.php?uc=gererFrais&action=validerCreationFrais"
              method="post" role="form">

            <?php
            $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $newDate);

            foreach ($lesFraisHorsForfait as $unHorsFrais) {
                $dateHorsFrais = $unHorsFrais['date'];
                $horsLibelle = htmlspecialchars($unHorsFrais['libelle']);
                $horsMontant = $unHorsFrais['montant'];
            ?>

            <div class="form-group">
                <label for="txtDateHF">Date (jj/mm/aaaa): </label>
                <input type="date" id="txtDateHF" name="dateFrais"
                       class="form-control" id="text" value="<?php echo $dateHorsFrais; ?>">
            </div>
            <div class="form-group">
                <label for="txtLibelleHF">Libellé</label>
                <input type="text" id="txtLibelleHF" name="libelle" class="form-control" id="text" value="<?php echo $horsLibelle; ?>">
            </div>
            <div class="form-group">
                <label for="txtMontantHF">Montant : </label>
                <div class="input-group">
                    <span class="input-group-addon">€</span>
                    <input type="text" id="txtMontantHF" name="montant" class="form-control" value="<?php echo $horsMontant; ?>">
                </div>
            </div>

            <?php
            }
            ?>

            <button class="btn btn-success" type="submit">Corriger</button>
            <button class="btn btn-danger" type="reset">Réinitialiser</button>
        </form>
    </div>
</div>


</body>
</html>

