<?php
?>

<form method="POST" action="index.php?uc=gererFraisComptable&action=afficherFicheFrais">
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
    <input type="hidden" name="visiteur" value="<?php echo htmlspecialchars($visiteurLogin); ?>">
    <button type="submit">Valider</button>
</form>

