<?php use_helper('Date') ?>
<?php use_helper('Number') ?>

<h2>Gestion des dépenses</h2>

<table class="datalist">
    <thead>
        <tr>
            <th>Libellé</th>
            <th>Montant</th>
            <th>Compte</th>
            <th>Date</th>
            <th class="actions">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($expensesPager->getResults() as $expense): ?>
            <?php include_partial('expenseRow', array('expense' => $expense)) ?>
        <?php endforeach ?>
    </tbody>
</table>


<?php include_partial('global/pager', array('pager' => $expensesPager, 'route' => '@expenses_list', 'params' => array())) ?>


<div class="addNew">
    <?php echo link_to(image_tag('add', array('align' => 'top', 'alt' => '[ajouter]')). ' Nouvelle dépense', '@expense_new') ?>
</div>
