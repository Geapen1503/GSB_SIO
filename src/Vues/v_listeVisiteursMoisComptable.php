<hr class="separator-line">
<form method="POST" action="index.php?uc=gererFraisComptable&action=selectionnerMois">
    <label for="visiteur">Choisir le visiteur :</label>
    <input list="visiteurs" name="visiteur" id="visiteur" autocomplete="off" placeholder="Entrez un nom">
    <datalist id="visiteurs">
        <?php foreach ($visiteurs as $visiteur) : ?>
            <option value="<?php echo htmlspecialchars($visiteur['login']); ?>" 
                <?php echo (!empty($visiteurSelectionne) && $visiteurSelectionne == $visiteur['login']) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($visiteur['login']); ?>
            </option>
        <?php endforeach; ?>
    </datalist>
    <button type="submit">Valider</button>
</form>

<!-- Affichage du visiteur sélectionné -->
<?php if (!empty($visiteurSelectionne)) : ?>
    <p style="margin-top: 15px;">Visiteur sélectionné : <strong><?php echo htmlspecialchars($visiteurSelectionne); ?></strong></p>
<?php endif; ?>

<?php if (!empty($visiteurMonths)) : ?>
    <form method="POST" action="index.php?uc=gererFraisComptable&action=selectionnerMois">
        <label for="mois">Choisir le mois :</label>
        <select name="mois" id="mois">
            <?php foreach ($visiteurMonths as $month) : ?>
                <?php
                $mois = $month['mois'];
                $year = substr($mois, 0, 4);
                $monthNumber = substr($mois, 4, 2);
                $formattedDate = $monthNumber . '/' . $year;
                ?>
                <option value="<?php echo htmlspecialchars($mois); ?>" 
                    <?php echo (!empty($moisSelectionne) && $moisSelectionne == $mois) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($formattedDate); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="hidden" name="visiteur" value="<?php echo htmlspecialchars($visiteurSelectionne); ?>">
        <button type="submit">Valider</button>
    </form>
<?php endif; ?>

<?php if (!empty($moisSelectionne)) : ?>
    <p style="margin-top: 15px;">Mois sélectionné : <strong><?php echo htmlspecialchars($moisSelectionne); ?></strong></p>
<?php endif; 