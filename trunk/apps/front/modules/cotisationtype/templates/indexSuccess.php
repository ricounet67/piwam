<?php use_helper('Number') ?>
<?php use_helper('Date') ?>

<h2>Gestion des types de cotisation</h2>

<table class="datalist">
    <thead>
        <tr>
            <th>Libellé</th>
            <th>Valide (mois)</th>
            <th>Montant</th>
            <th>Créé le</th>
            <th>Dernière édition</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($due_types as $due_type): ?>
        <tr>
            <td><?php echo $due_type->getLabel() ?></td>
            <td><?php echo $due_type->getPeriod() ?></td>
            <td><?php echo format_currency($due_type->getAmount(), '&euro;') ?></td>
            <td><?php echo format_date($due_type->getCreatedAt()) ?></td>
            <td><?php echo format_date($due_type->getUpdatedAt()) ?></td>
            <td>
                <?php echo link_to(image_tag('edit',   array('alt' => '[modifier]')), '@duetype_edit?id=' . $due_type->getId())?>
                <?php echo link_to(image_tag('delete', array('alt' => '[supprimer]')), '@duetype_delete?id=' . $due_type->getId(), array('method' => 'delete', 'confirm' => 'Ètes vous sûr ?')) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<div class="addNew">
    <?php echo link_to(image_tag('add', array('align'=>'top', 'alt'=>'[ajouter]')). ' Nouveau type', '@duetype_new') ?>
</div>
