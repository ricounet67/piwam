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
    <?php foreach ($incomesPager->getResults() as $income): ?>
        <tr>
            <td><?php echo $income->getLabel() ?></td>
            <td><?php echo format_currency($income->getAmount()) ?></td>
            <td><?php echo $income->getAccount() ?></td>
            <td><?php
            if ($income->getReceived() == 1) {
                echo format_date($income->getDate());
            }
            else {
                echo 'Non perçue';
            }
            ?></td>
            <td>
                <a href="<?php echo url_for('@income_show?id=' . $income->getId()) ?>"><?php echo image_tag('details.png', array('alt' => '[détails]')) ?></a>
                <a href="<?php echo url_for('@income_edit?id=' . $income->getId()) ?>"><?php echo image_tag('edit.png', array('alt' => '[modifier]')) ?></a>
                <?php echo link_to(image_tag('delete', array('alt' => '[supprimer]')), '@income_delete?id=' . $income->getId(), array('method' => 'delete', 'confirm' => 'Ètes vous sûr ?')) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include_partial('global/pager', array('pager' => $incomesPager, 'module' => 'recette', 'action' => 'index', 'params' => array())) ?>

<div class="addNew">
    <?php echo link_to(image_tag('add', array('align'=>'top', 'alt'=>'[ajouter]')). ' Nouvelle recette', '@income_new') ?>
</div>
