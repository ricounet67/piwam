<h2>Résultats de recherche</h2>

<?php include_partial('searchForm', array('form' => $searchForm)) ?>

<table class="datalist">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Pseudo</th>
            <th>Statut</th>
            <th>Ville</th>
            <th width="75px">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($members->getResults() as $member): ?>
            <?php include_partial('memberRow', array('member' => $member)) ?>
        <?php endforeach ?>
    </tbody>
</table>


<!-- Legend -->

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


<div class="addNew" style="width: 194px; background-color: #EAEAEA; border: 3px solid #EAEAEA;">
        <?php echo link_to('Retour à la liste complète', '@members_list') ?>
</div>

<?php include_partial('global/pager', array('pager' => $members, 'route' => '@member_search', 'params' => array())) ?>