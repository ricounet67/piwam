<h2>Gestion des statuts</h2>

<?php if ($sf_user->hasFlash('notice')): ?>
<div class="error"><?php echo $sf_user->getFlash('notice') ?></div>
<?php endif; ?>

<table class="datalist">
    <thead>
        <tr>
            <th>Libellé</th>
            <th width="70px">Membres</th>
            <th width="80px">Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($status_list as $status): ?>
        <tr>
            <td><?php echo $status->getLabel() ?></td>
            <td><?php echo $status->countEnabledMembers() ?></td>
            <td>
                <?php echo link_to(image_tag('details.png', array('alt' => '[détails]')), '@status_show?id=' . $status->getId()) ?>
                <?php echo link_to(image_tag('edit.png',    array('alt' => '[modifier]')), '@status_edit?id=' . $status->getId()) ?>
                <?php echo link_to(image_tag('delete.png',  array('alt' => '[supprimer]')), '@status_delete?id=' . $status->getId(), array('method' => 'delete', 'confirm' => 'Etes vous sur ?')) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="addNew"><?php echo link_to(image_tag('add', array('align'=>'top', 'alt'=>'Time')). ' Nouveau statut', '@status_new') ?>
</div>
