<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

$visiteurs = $pdo->getAllVisiteur();

?>

<!--<!DOCTYPE html>
<html lang="fr">
<head>-->
<!--    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valider la fiche de frais</title>
</head>
<body>-->


<div class="visiteur-choice-section">
    <label for="visiteur">Choisir le visiteur:</label>
    <select name="visiteur" id="visiteur">
        <?php foreach ($visiteurs as $visiteur): ?>
            <option value="<?= htmlspecialchars($visiteur['nom'] . ' ' . $visiteur['prenom']) ?>">
                <?= htmlspecialchars($visiteur['nom'] . ' ' . $visiteur['prenom']) ?>
            </option>
        <?php endforeach; ?>

    </select>
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

        //$today_date = date('m') + date('y');

        foreach ($dates as $date) {

           // if ($date == $today_date) echo $options = '<option value="date" selected>', $date, '</option>';
            //else echo $options = '<option value="date">', $date, '</option>';

            echo $options = '<option value="date">', $date, '</option>';
        }

        ?>


    </select>
</div>
<div class="row">    
    <h2 class="orgcomptable">Valider la fiche de frais</h2>
    <h3>Eléments forfaitisés</h3>
    <div class="col-md-4">
        <form method="post" 
              action="index.php?uc=gererFrais&action=validerMajFraisForfait" 
              role="form">
            <fieldset>       
                <?php
                foreach ($lesFraisForfait as $unFrais) {
                    $idFrais = $unFrais['idfrais'];
                    $libelle = htmlspecialchars($unFrais['libelle']);
                    $quantite = $unFrais['quantite']; ?>
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
<!--<div class="form-section">
    <h2 class="orgcomptable">Valider la fiche de frais</h2>
    <div class="forfait-section">
        <h3>Éléments forfaitisés</h3>
        <label for="etape">Forfait Étape:</label>
        <input type="number" id="etape" name="etape" value="12">

        <label for="kilometrique">Frais Kilométrique:</label>
        <input type="number" id="kilometrique" name="kilometrique" value="562">

        <label for="hotel">Nuitée Hôtel:</label>
        <input type="number" id="hotel" name="hotel" value="6">

        <label for="restaurant">Repas Restaurant:</label>
        <input type="number" id="restaurant" name="restaurant" value="25">

        <div class="action-buttons">
            <input type="submit" value="Corriger">
            <input type="reset" value="Réinitialiser">
        </div>
    </div>
</div>-->

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
        <tr>
            <td><input type="text" value="12/08/2022"></td>
            <td><input type="text" value="Achat de fleurs"></td>
            <td><input type="number" value="29.90"></td>
            <td>
                <input type="submit" value="Corriger">
                <input type="reset" value="Réinitialiser">
            </td>
        </tr>
        <tr>
            <td><input type="text" value="14/08/2022"></td>
            <td><input type="text" value="Taxi"></td>
            <td><input type="number" value="32.50"></td>
            <td>
                <input type="submit" value="Corriger">
                <input type="reset" value="Réinitialiser">
            </td>
        </tr>
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

