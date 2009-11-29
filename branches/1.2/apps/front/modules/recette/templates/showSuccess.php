<?php use_helper('Date') 	?>
<?php use_helper('Membre') 	?>
<?php use_helper('Number') 	?>
<?php use_helper('Boolean')  ?>

<h2>Détails d'une entrée d'argent</h2>
<table class="tableauDetails" id="details">
    <tbody>
        <tr>
            <th>Id :</th>
            <td><?php echo $recette->getId() ?></td>
        </tr>
        <tr>
            <th>Libellé :</th>
            <td><?php echo $recette->getLabel() ?></td>
        </tr>
        <tr>
            <th>Montant :</th>
            <td><?php echo format_currency($recette->getAmount(), '&euro;') ?></td>
        </tr>
        <tr>
            <th>Compte affecté :</th>
            <td><?php echo $recette->getAccount() ?></td>
        </tr>
        <tr>
            <th>Activité :</th>
            <td><?php echo $recette->getActivity() ?></td>
        </tr>
        <?php if ($recette->getReceived() == 1): ?>
        <tr>
            <th>Effective le :</th>
            <td><?php echo format_date($recette->getDate()) ?></td>
        </tr>
        <?php else: ?>
        <tr>
            <th>Perçue :</th>
            <td><?php echo boolean2icon(false) ?></td>
        </tr>
        <?php endif; ?>
        <tr>
            <th><?php echo image_tag('time.png', array('align' => 'absmiddle', 'alt' => 'Time'))?> Créée le
            :</th>
            <td><?php echo format_datetime($recette->getCreatedAt(), 'dd/MM/yyyy HH:mm') . ' par ' . format_member($recette->getCreatedByMember()) ?></td>
        </tr>
        <tr>
            <th><?php echo image_tag('time.png', array('align' => 'absmiddle', 'alt' => 'Time'))?> Mise à
            jour le :</th>
            <td><?php echo format_datetime($recette->getUpdatedAt(), 'dd/MM/yyyy HH:mm') . ' par ' . format_member($recette->getUpdatedByMember()) ?></td>
        </tr>
    </tbody>
</table>

<hr />

<a href="<?php echo url_for('recette/edit?id='.$recette->getId()) ?>">Editer</a>
&nbsp;
<a href="<?php echo url_for('recette/index') ?>">Retour</a>
