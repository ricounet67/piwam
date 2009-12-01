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
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($expensesPager->getResults() as $expense): ?>
            <tr>
                <td><?php echo $expense->getLabel() ?></td>
                <td><?php echo format_currency($expense->getAmount()) ?></td>
                <td><?php echo $expense->getAccount() ?></td>
                <td>
                    <?php if ($expense->getPaid() == 1): ?>
                        <?php echo format_date($expense->getDate()) ?>
                    <?php else: ?>
                        <?php echo 'Non payée'; ?>
                    <?php endif ?>
                </td>
                <td>
                    <a href="<?php echo url_for('@expense_show?id=' . $expense->getId()) ?>"><?php echo image_tag('details.png', array('alt' => '[details]')) ?></a>
                    <a href="<?php echo url_for('@expense_edit?id=' . $expense->getId()) ?>"><?php echo image_tag('edit.png', array('alt' => '[modifier]')) ?></a>
                    <?php echo link_to(image_tag('delete', array('alt' => '[supprimer]')), '@expense_delete?id=' . $expense->getId(), array('method' => 'delete', 'confirm' => 'Ètes vous sûr ?')) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<?php include_partial('global/pager', array('pager' => $expensesPager, 'route' => '@expenses_list', 'params' => array())) ?>


<div class="addNew">
    <?php echo link_to(image_tag('add', array('align' => 'top', 'alt' => '[ajouter]')). ' Nouvelle dépense', '@expense_new') ?>
</div>
