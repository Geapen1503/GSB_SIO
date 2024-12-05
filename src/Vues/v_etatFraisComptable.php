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
            <td><?php echo htmlspecialchars($fraisHors['date']); ?></td>
            <td><?php echo htmlspecialchars($fraisHors['libelle']); ?></td>
            <td><?php echo htmlspecialchars($fraisHors['montant']); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
