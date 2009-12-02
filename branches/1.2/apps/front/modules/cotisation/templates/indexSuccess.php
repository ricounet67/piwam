<?php use_helper('Date') ?>
<?php use_helper('Number') ?>

<h2>Liste des cotisations</h2>

<!-- If dues have already been configured -->

<?php if ($typesExist): ?>

    <table class="datalist">
        <thead>
            <tr>
                <th>Compte</th>
                <th>Type</th>
                <th>Montant</th>
                <th>Membre</th>
                <th>Versée le</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($duesPager->getResults() as $due): ?>
                <tr>
                    <td><?php echo $due->getAccount() ?></td>
                    <td><?php echo $due->getDueType() ?></td>
                    <td><?php echo format_currency($due->getAmount(), '&euro;') ?></td>
                    <td><?php echo $due->getMember() ?></td>
                    <td><?php echo format_date($due->getDate()) ?></td>
                    <td>
                        <?php echo link_to(image_tag('details', array('alt' => '[détails]')), '@due_show?id=' . $due->getId()) ?>
                        <a href="<?php echo url_for('@due_edit?id='.$due->getId()) ?>"><?php echo image_tag('edit.png', array('alt' => '[modifier]')) ?></a>
                        <?php echo link_to(image_tag('delete', array('alt' => '[supprimer]')), '@due_delete?id=' . $due->getId(), array('method' => 'delete', 'confirm' => 'Ètes vous sûr ?')) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="addNew">
        <?php echo link_to(image_tag('add', array('align'=>'top', 'alt'=>'[ajouter]')). ' Enregistrer une cotisation', '@due_new') ?>
    </div>

    <?php include_partial('global/pager', array('pager' => $duesPager, 'route' => '@dues_list', 'params' => array())) ?>



<!-- No due type has been configured yet, we need to set one -->

<?php else: ?>

    <p>
        Aucun type de cotisation n'a été configuré pour le moment. <br />
        Avant d'enregistrer les cotisations de vos membres, vous devez <br />
        d'abord <?php echo link_to('créer un nouveau type de cotisation', '@duetype_new?first=1') ?>.
    </p>

<?php endif ?>