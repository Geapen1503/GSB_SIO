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
                                   data-original-value="<?php echo htmlspecialchars($frais['quantite']); ?>" 
                                   class="form-control">
                        </div>
                    <?php endforeach; ?>
                    <input type="hidden" name="visiteur" value="<?php echo htmlspecialchars($visiteurSelectionne); ?>">
                    <input type="hidden" name="mois" value="<?php echo htmlspecialchars($moisSelectionne); ?>">
                    <button type="submit" class="btn btn-success">Corriger</button>
                </fieldset>
            </form>
            <button type="button" class="btn btn-danger btn-reinitialiser">Réinitialiser</button>
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
            <form method="POST" action="index.php?uc=gererFraisComptable&action=corrigerFraisHorsForfait">
                    <td class="date">
                        <input type="text" name="dateFrais[<?php echo htmlspecialchars($fraisHors['date']); ?>]" 
                               value="<?php echo htmlspecialchars($fraisHors['date']); ?>" 
                               data-original-value="<?php echo htmlspecialchars($fraisHors['date']); ?>" 
                               class="form-control">
                    </td>
                    <td class="libelle">
                        <input type="text" name="libelleFrais[<?php echo htmlspecialchars($fraisHors['libelle']); ?>]" 
                               value="<?php echo htmlspecialchars($fraisHors['libelle']); ?>" 
                               data-original-value="<?php echo htmlspecialchars($fraisHors['libelle']); ?>" 
                               class="form-control">
                    </td>
                    <td class="montant">
                        <input type="text" name="montantFrais[<?php echo htmlspecialchars($fraisHors['montant']); ?>]" 
                               value="<?php echo htmlspecialchars($fraisHors['montant']); ?>" 
                               data-original-value="<?php echo htmlspecialchars($fraisHors['montant']); ?>" 
                               class="form-control">
                    </td>
                    <td>
                        <input type="hidden" name="idFrais" value="<?php echo htmlspecialchars($fraisHors['id']); ?>">
                        <input type="hidden" name="visiteur" value="<?php echo htmlspecialchars($visiteurSelectionne); ?>">
                        <input type="hidden" name="mois" value="<?php echo htmlspecialchars($moisSelectionne); ?>">
                        <button type="submit" class="btn btn-success">Corriger</button>
                        <button type="button" class="btn btn-danger btn-reinitialiser">Réinitialiser</button>
                    </td>
                </form>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<label for="visiteur">Nombre de justificatifs :</label>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Fonction pour réinitialiser les champs de formulaire
        function reinitialiserChamps() {
            const inputs = document.querySelectorAll('[data-original-value]');
            inputs.forEach(input => {
                input.value = input.getAttribute('data-original-value'); // Remet la valeur initiale
            });
        }

        // Attache un événement au bouton de réinitialisation
        const boutonsReinitialiser = document.querySelectorAll('.btn-reinitialiser'); // Classe des boutons
        boutonsReinitialiser.forEach(bouton => {
            bouton.addEventListener('click', function (event) {
                event.preventDefault(); // Empêche la soumission
                reinitialiserChamps();
            });
        });
    });
</script>