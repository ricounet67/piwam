<?php use_helper('Date') ?>

<h2>Liste des activités</h2>

<table class="datalist">

    <!-- Header, describes columns -->

    <thead>
        <tr>
            <th>Libellé</th>
            <th>Créée le</th>
            <th>Actions</th>
        </tr>
    </thead>


    <!-- Display entries -->

    <tbody>
        <?php foreach ($activities as $activity): ?>
        <tr>
            <td>
                <?php echo $activity->getLabel() ?>
            </td>
            <td>
                <?php echo format_date($activity->getCreatedAt()) ?>
            </td>
            <td>
                <a href="<?php echo url_for('@activity_by_id?id=' . $activity->getId()) ?>"><?php echo image_tag('details.png', array('alt' => '[détails]')) ?></a>
                <a href="<?php echo url_for('@activity_edit?id=' . $activity->getId()) ?>"><?php echo image_tag('edit.png', array('alt' => '[modifier]')) ?></a>
                <?php echo link_to(image_tag('delete'), '@activity_delete?id=' . $activity->getId(), array(
                    'method'  => 'delete',
                    'confirm' => 'Etes vous sûr ? Les recettes et dépenses associées seront aussi supprimées'
                )) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<div class="addNew">
    <?php echo link_to(image_tag('add', array('align' => 'top', 'alt' => '[Ajouter]')). ' Nouvelle activité', '@activity_new') ?>
</div>
