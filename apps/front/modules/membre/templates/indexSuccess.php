
<!-- Displays pending subscriptions -->

<?php if (count($pending)): ?>
    <h2>Demandes d'adhésion en attente...</h2>

    <table class="datalist" summary="Members who would like to belong to the association">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Pseudo</th>
                <th>Statut</th>
                <th>Ville</th>
                <th width="100px">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pending as $member): ?>
                <?php include_partial('memberRow', array('member' => $member)) ?>
            <?php endforeach ?>
        </tbody>
    </table>
<?php endif ?>



<!-- And then displays the subscribed members -->

<h2>Liste des membres</h2>

<?php include_partial('searchForm', array('form' => $searchForm)) ?>

<table class="datalist" summary="Members who would like to belong to the association">
    <thead>
        <tr>
            <th><?php echo link_to('Nom',    '@members_list?orderby=lastname') ?></th>
            <th><?php echo link_to('Prénom', '@members_list?orderby=firstname') ?></th>
            <th><?php echo link_to('Pseudo', '@members_list?orderby=username') ?></th>
            <th><?php echo link_to('Statut', '@members_list?orderby=status_id') ?></th>
            <th><?php echo link_to('Ville',  '@members_list?orderby=city') ?></th>
            <th width="75px">Actions</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($members->getResults() as $member): ?>
            <?php include_partial('memberRow', array('member' => $member)) ?>
        <?php endforeach ?>

    </tbody>
</table>


<!-- Display the legend -->

<table style="border: 1px solid #999; margin-top: 15px; width: 200px;">
    <tr style="font-weight: bold; background-color: #ddd; color: #555;">
        <td colspan="2">Légende&nbsp;</td>
    </tr>
    <tr>
        <td class="cotisationNonAjour" width="20px">&nbsp;</td>
        <td>Cotisation non à jour</td>
    </tr>
    <tr>
        <td style="border: 1px solid #bbb;" width="20px">&nbsp;</td>
        <td>Cotisation à jour</td>
    </tr>
</table>


<div class="addNew"
    style="width: 194px; background-color: #EAEAEA; border: 3px solid #EAEAEA;">
        <?php echo link_to(image_tag('add', array('align'=>'top', 'alt'=>'[ajouter]')). ' Enregistrer un membre', '@member_new') ?>
</div>


<?php include_partial('global/pager', array('pager' => $members, 'route' => '@members_list', 'params' => array('orderby' => $orderByColumn))) ?>
