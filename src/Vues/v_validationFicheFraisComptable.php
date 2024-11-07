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
</head>
<body>


<?php
if (isset($_POST['visiteur'])) {
    $visiteurLogin = $_POST['visiteur'];
    echo "Le visiteur sélectionné est : " . htmlspecialchars($visiteurLogin);

    // Obtenez l'ID et les mois du visiteur.
    $visiteurId = $pdo->getVisiteurId(htmlspecialchars($visiteurLogin));
    $visiteurMonths = $pdo->getAllMoisVisiteur($visiteurId);
} else {
    // Formulaire de sélection du visiteur.
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

// Affichez le formulaire de mois si le visiteur est sélectionné.
if (isset($visiteurMonths)) {
    ?>
    <form method="POST" action="">
        <div class="mois-choice-section">
            <label for="mois">Choisir le mois :</label>
            <select name="mois" id="mois">
                <?php foreach ($visiteurMonths as $month) : ?>
                    <option value="<?php echo htmlspecialchars($month['mois']); ?>">
                        <?php echo htmlspecialchars($month['mois']); ?>
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



<?php
$visiteurId = $pdo->getVisiteurId(htmlspecialchars($visiteurLogin));
$visiteurMonths = $pdo->getAllMoisVisiteur($visiteurId);

?>


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

                    //$dateUnformat = '03/10/2023';
                    //echo $newDate = \Outils\Utilitaires::getMois($dateUnformat);

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
                        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $newDate);

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

                        <!-- <button class="btn btn-success" type="submit">Corriger</button>
                        <button class="btn btn-danger" type="reset">Réinitialiser</button> -->
                    </form>
                </tr>
                </thead>

            </table>
    </div>
</div>


</body>
</html>

