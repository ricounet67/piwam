<h2>Mise à jour de Piwam</h2>

<table class="formArray">
    <tr>
        <th>Version actuelle de la base de données :</th>
        <td><pre><?php echo $currentDBVersion; ?></pre></td>
    </tr>
    <tr>
        <th>Fichiers SQL à exécuter :</th>
        <td><?php if (count($files) === 0): ?> Aucun fichier à exécuter <?php else: ?>
        <ul>
        <?php foreach ($files as $file): ?>
            <li><pre><?php echo $file ?></pre></li>
            <?php endforeach; ?>
        </ul>
        <?php endif ?></td>
    </tr>
    <?php if (count($files) !== 0): ?>
    <tr>
        <th>&nbsp;</th>
        <td><?php echo link_to('Exécuter', 'update/perform', array('class' => 'button')) ?>
        </td>
    </tr>
    <?php endif ?>
</table>
