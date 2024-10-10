<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

$visiteurs = $pdo->getAllVisiteurs();

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


<div class="visiteur-choice-section">
    <label for="visiteur">Choisir le visiteur:</label>
    <select name="visiteur" id="visiteur">
        <?php foreach ($visiteurs as $visiteur): ?>
            <option class="userLoginOption" value="<?= htmlspecialchars($visiteur['login']) ?>">
                <?= htmlspecialchars($visiteur['login']) ?>
            </option>
        <?php endforeach; ?>

    </select>

    <?php
        if (isset($_POST['visiteur'])) $visiteurName = $_POST['visiteur'];
    ?>

    <label for="mois">Mois:</label>
    <select name="mois" id="mois">

        <?php
        $first_year = 2010;
        $first_month = 1;
        $nb_years = date('Y') - 2009;

        $dates = [];

        for ($year = $first_year; $year < $first_year + $nb_years; $year++) {
            for ($mois = $first_month; $mois <= 12; $mois++) {
                $date = str_pad($mois, 2, '0', STR_PAD_LEFT) . '/' . $year;
                $dates[] = $date;
            }
            $first_month = 1;
        }

        foreach ($dates as $date) {
            $dateEntree = $date;
            list($mois, $annee) = explode("/", $dateEntree);
            $moisActuel = date('m');
            $anneeActuelle = date('Y');

            if ($mois >= 1 && $mois <= 12 && $mois == $moisActuel && $annee == $anneeActuelle) echo $options = '<option value="date" selected>', $date, '</option>';
            else echo $options = '<option value="date">', $date, '</option>';
        }
        ?>


    </select>
</div>
<div class="form-section">
    <h2>Valider la fiche de frais</h2>
    <div class="row">
        <h2>Renseigner ma fiche de frais du mois
            <?php echo $numMois . '-' . $numAnnee ?>
        </h2>
        <h3>Eléments forfaitisés</h3>
        <div class="col-md-4">
            <form method="post"
                  action="index.php?uc=gererFrais&action=validerMajFraisForfait"
                  role="form">
                <fieldset>
                    <?php
                    /*
                    foreach ($lesFraisForfait as $unFrais) {
                        $idFrais = $unFrais['idfrais'];
                        $libelle = htmlspecialchars($unFrais['libelle']);
                        $quantite = $unFrais['quantite'];*/
                    ?>
                        <div class="form-group">
                            <label for="idFrais"><?php /*echo $libelle*/ ?></label>
                            <input type="text" id="idFrais"
                                   name="lesFrais[<?php /*echo $idFrais*/ ?>]"
                                   size="10" maxlength="5"
                                   value="<?php /*echo $quantite*/ ?>"
                                   class="form-control">
                        </div>
                        <?php
                    //}
                    ?>
                    <button class="btn btn-success" type="submit">Ajouter</button>
                    <button class="btn btn-danger" type="reset">Effacer</button>
                </fieldset>
            </form>
        </div>
    </div>
</div>

<div class="table-section">
    <h3>Descriptif des éléments hors forfait</h3>
    <table>
        <thead>
        <tr>
            <th>Date</th>
            <th>Libellé</th>
            <th>Montant</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>

        <?php



        echo '
            <tr>
                <td><input type="text" value="14/08/2022"></td>
                <td><input type="text" value="Taxi"></td>
                <td><input type="number" value="32.50"></td>
                <td>
                    <input type="submit" value="Corriger">
                    <input type="reset" value="Réinitialiser">
                </td>
            </tr>
        ';

        ?>

        <!--
        <tr>
            <td><input type="text" value="14/08/2022"></td>
            <td><input type="text" value="Taxi"></td>
            <td><input type="number" value="32.50"></td>
            <td>
                <input type="submit" value="Corriger">
                <input type="reset" value="Réinitialiser">
            </td>
        </tr>
        -->
        </tbody>
    </table>

    <div class="validation-section">
        <label for="justificatifs">Nombre de justificatifs:</label>
        <input type="number" id="justificatifs" name="justificatifs" value="2">

        <div class="action-buttons">
            <input type="submit" value="Valider">
            <input type="reset" value="Réinitialiser">
        </div>
    </div>
</div>
</body>
</html>

