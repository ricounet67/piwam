<?php use_helper('Date') ?>

<h2>Liste des comptes</h2>

<table class="datalist">
    <thead>
        <tr>
            <th>Libellé</th>
            <th>Référence</th>
            <th>Enregistré le</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($accounts as $account): ?>
        <tr>
            <td><?php echo $account->getLabel() ?></td>
            <td><?php echo $account->getReference() ?></td>
            <td><?php echo format_date($account->getCreatedAt()) ?></td>
            <td>
              <a href="<?php echo url_for('@account_by_id?id='.$account->getId()) ?>"><?php echo image_tag('details.png', array('alt' => '[details]')); ?></a>
              <a href="<?php echo url_for('@account_edit?id='.$account->getId()) ?>"><?php echo image_tag('edit.png', array('alt' => '[modifier]')); ?></a>
              <?php echo link_to(image_tag('delete', array('alt' => '[supprimer]')), '@account_delete?id=' . $account->getId(), array('method' => 'delete', 'confirm' => 'Ètes vous sûr ?')); ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div class="addNew">
  <?php echo link_to(image_tag('add', array('align'=>'top', 'alt' => '[ajouter]')). ' Enregistrer un compte', '@account_new') ?>
</div>
