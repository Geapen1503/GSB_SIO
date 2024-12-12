<div class="form-section">
    <h2 class="orgcomptable">Valider la fiche de frais</h2>
    <div class="row">
        <h3>Éléments forfaitisés</h3>
        <div class="col-md-4">
            <form method="POST" action="index.php?uc=gererFraisComptable&action=corrigerFraisForfait">
                <fieldset>
                    <!-- Champs pour chaque frais forfaitisé -->
                    <?php foreach ($lesFraisForfait as $frais) : ?>
                        <div class="form-group vertical-form-group">
                            <label for="<?php echo $frais['idfrais']; ?>">
                                <?php echo htmlspecialchars($frais['libelle']); ?>
                            </label>
                            <input type="text" 
                                   name="lesFrais[<?php echo htmlspecialchars($frais['idfrais']); ?>]" 
                                   value="<?php echo htmlspecialchars($frais['quantite']); ?>" 
                                   class="form-control">
                        </div>
                    <?php endforeach; ?>
                    <input type="hidden" name="visiteur" value="<?php echo htmlspecialchars($visiteurSelectionne); ?>">
                    <input type="hidden" name="mois" value="<?php echo htmlspecialchars($moisSelectionne); ?>">
                    <button type="submit" class="btn btn-success" name="action" value="corriger">Corriger</button>
                </fieldset>
            </form>
            <form method="POST" action="index.php?uc=gererFraisComptable&action=reinitialiserFraisForfait">
                <input type="hidden" name="visiteur" value="<?php echo htmlspecialchars($visiteurSelectionne); ?>">
                <input type="hidden" name="mois" value="<?php echo htmlspecialchars($moisSelectionne); ?>">
                <button type="submit" name="action" value="reinitialiser" class="btn btn-danger">Réinitialiser</button>
            </form>
        </div>
    </div>
</div>

<hr class="separator-line">
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
                <?php foreach ($lesFraisHorsForfait as $fraisHors) : ?>
                <tr>
                <form method="POST">
                    <td class="date">
                        <input type="text" name="dateFrais[<?php echo htmlspecialchars($fraisHors['date']); ?>]" value="<?php echo htmlspecialchars($fraisHors['date']); ?>" class="form-control">
                    </td>
                    <td class="libelle">
                        <input type="text" name="libelleFrais[<?php echo htmlspecialchars($fraisHors['libelle']); ?>]" value="<?php echo htmlspecialchars($fraisHors['libelle']); ?>" class="form-control">
                    </td>
                    <td class="montant">
                        <input type="text" name="montantFrais[<?php echo htmlspecialchars($fraisHors['montant']); ?>]" value="<?php echo htmlspecialchars($fraisHors['montant']); ?>" class="form-control">
                    </td>
                    <td>
                    <form method="POST" action="index.php?uc=gererFraisComptable&action=corrigerFrais">
                            <input type="hidden" name="visiteur" value="<?php echo htmlspecialchars($visiteurSelectionne); ?>">
                            <input type="hidden" name="mois" value="<?php echo htmlspecialchars($moisSelectionne); ?>">
                            <input type="hidden" name="idFrais" value="<?php echo htmlspecialchars($idFrais); ?>">
                            <!-- Champs pour date, libelle, montant -->
                            <button type="submit" name="action" value="corriger" class="btn btn-success">Corriger</button>
                        </form>

                        <form method="POST" action="index.php?uc=gererFraisComptable&action=reinitialiserFrais">
                            <input type="hidden" name="visiteur" value="<?php echo htmlspecialchars($visiteurSelectionne); ?>">
                            <input type="hidden" name="mois" value="<?php echo htmlspecialchars($moisSelectionne); ?>">
                            <input type="hidden" name="idFrais" value="<?php echo htmlspecialchars($idFrais); ?>">
                            <button type="submit" name="action" value="reinitialiser" class="btn btn-danger">Réinitialiser</button>
                    </form>
                    </td>
                </form>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<label for="visiteur">Nombre de justificatifs :</label>