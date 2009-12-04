<?php use_helper('Date') ?>

<h2>Liste des comptes</h2>

<table class="datalist">
    <thead>
        <tr>
            <th>Libellé</th>
            <th>Référence</th>
            <th>Enregistré le</th>
            <th class="actions">&nbsp;</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($accounts as $account): ?>
            <?php include_partial('accountRow', array('account' => $account))?>
        <?php endforeach ?>

    </tbody>
</table>

<div class="addNew">
  <?php echo link_to(image_tag('add', array('align'=>'top', 'alt' => '[ajouter]')). ' Enregistrer un compte', '@account_new') ?>
</div>
