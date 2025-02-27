<?php
?>
<div class="form-section">
    <h3>Frais Forfaitisés</h3>
    <form method="POST" action="index.php?uc=gererFraisComptable&action=corrigerFrais">
        <?php foreach ($lesFraisForfait as $frais) : ?>
            <label for="<?php echo $frais['idfrais']; ?>"><?php echo htmlspecialchars($frais['libelle']); ?></label>
            <input type="text" name="lesFrais[<?php echo $frais['idfrais']; ?>]" value="<?php echo $frais['quantite']; ?>">
        <?php endforeach; ?>
        <input type="hidden" name="visiteur" value="<?php echo htmlspecialchars($visiteurLogin); ?>">
        <input type="hidden" name="mois" value="<?php echo htmlspecialchars($mois); ?>">
        <button type="submit">Corriger</button>
    </form>

    <h3>Frais Hors Forfait</h3>
    <table>
        <thead>
        <tr>
            <th>Date</th>
            <th>Libellé</th>
            <th>Montant</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($lesFraisHorsForfait as $fraisHors) : ?>
            <tr>
                <td class="date">
                    <input type="text" name="dateFrais[<?php echo htmlspecialchars($fraisHors['date']); ?>]" value="<?php echo htmlspecialchars($fraisHors['date']); ?>" class="form-control">
                </td>
                <td class="libelle">
                    <input type="text" name="libelleFrais[<?php echo htmlspecialchars($fraisHors['libelle']); ?>]" value="<?php echo htmlspecialchars($fraisHors['libelle']); ?>" class="form-control">
                </td>
                <td class="montant">
                    <input type="text" name="montantFrais[<?php echo htmlspecialchars($fraisHors['montant']); ?>]" value="<?php echo htmlspecialchars($fraisHors['montant']); ?>" class="form-control">
                </td>
                <td class="action">
                    <button class="btn btn-success btn-sm" type="button">Corriger</button>
                    <button class="btn btn-danger btn-sm" type="button">Réinitialiser</button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <form method="POST" action="index.php?uc=gererFraisComptable&action=genererPDF">
        <input type="hidden" name="visiteur" value="<?php echo htmlspecialchars($visiteurLogin); ?>">
        <input type="hidden" name="mois" value="<?php echo htmlspecialchars($mois); ?>">
        <button type="submit" class="btn btn-primary">Générer le PDF</button>
    </form>

</div>
