<?php

?>

<form method="POST" action="index.php?uc=etatFraisComptable&action=selectionnerMois">
    <label for="visiteur">Choisir le visiteur :</label>
    <input list="visiteurs" name="visiteur" id="visiteur" autocomplete="off">
    <datalist id="visiteurs">
        <?php foreach ($visiteurs as $visiteur) : ?>
            <option value="<?php echo htmlspecialchars($visiteur['login']); ?>">
                <?php echo htmlspecialchars($visiteur['login']); ?>
            </option>
        <?php endforeach; ?>
    </datalist>
    <button type="submit">Valider</button>
</form>

