<h2>Gestion des statuts</h2>

<?php if ($sf_user->hasFlash('notice')): ?>
    <div class="error">
        <?php echo $sf_user->getFlash('notice') ?>
    </div>
<?php endif; ?>

<table class="datalist">
    <thead>
        <tr>
            <th>Libellé</th>
            <th width="70px">Membres</th>
            <th class="actions">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($status_list as $status): ?>
            <?php include_partial('statusRow', array('status' => $status)) ?>
        <?php endforeach ?>
    </tbody>
</table>

<div class="addNew"><?php echo link_to(image_tag('add', array('align'=>'top', 'alt'=>'Time')). ' Nouveau statut', '@status_new') ?>
</div>
