<?php use_helper('Date') ?>
<?php use_helper('Number') ?>

<h2>Liste des recettes</h2>

<table class="datalist">
    <thead>
        <tr>
            <th>Libellé</th>
            <th>Montant</th>
            <th>Compte</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($recettesPager->getResults() as $recette): ?>
        <tr>
            <td><?php echo $recette->getLabel() ?></td>
            <td><?php echo format_currency($recette->getAmount()) ?></td>
            <td><?php echo $recette->getAccount() ?></td>
            <td><?php
            if ($recette->getReceived() == 1) {
                echo format_date($recette->getDate());
            }
            else {
                echo 'Non perçue';
            }
            ?></td>
            <td>
                <a href="<?php echo url_for('@income_show?id=' . $recette->getId()) ?>"><?php echo image_tag('details.png', array('alt' => '[détails]')) ?></a>
                <a href="<?php echo url_for('@income_edit?id=' . $recette->getId()) ?>"><?php echo image_tag('edit.png', array('alt' => '[modifier]')) ?></a>
                <?php echo link_to(image_tag('delete', array('alt' => '[supprimer]')), '@income_delete?id=' . $recette->getId(), array('method' => 'delete', 'confirm' => 'Ètes vous sûr ?')) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include_partial('global/pager', array('pager' => $recettesPager, 'module' => 'recette', 'action' => 'index', 'params' => array())) ?>

<div class="addNew">
    <?php echo link_to(image_tag('add', array('align'=>'top', 'alt'=>'[ajouter]')). ' Nouvelle recette', '@income_new') ?>
</div>
