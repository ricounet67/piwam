<?php if (count($pending)): ?>
    <h2>Demandes d'adhésion en attente...</h2>

    <table class="tableauDonnees" summary="Members who would like to belong to the association">
        <thead>
            <tr class="enteteTableauDonnees">
                <th>Nom</th>
                <th>Prénom</th>
                <th>Pseudo</th>
                <th>Statut</th>
                <th>Ville</th>
                <th width="100px">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($pending as $membre): ?>
            <tr>
                <td><?php echo $membre->getLastname() ?></td>
                <td><?php echo $membre->getFirstname() ?></td>
                <td><?php echo $membre->getUsername() ?></td>
                <td><?php echo $membre->getStatus() ?></td>
                <td><?php echo $membre->getCity() ?></td>
                <td>
                    <?php echo link_to(image_tag('state_ok.png', array('alt' => '[valider]')), 'membre/validate?id=' . $membre->getId()) ?>
                    <?php if ($membre->getEmail()) :?>
                        <?php echo mail_to($membre->getEmail(), image_tag('mail.png', array('alt' => '[e-mail]'))) ?>
                    <?php else: ?>
                        <?php echo image_tag('no_mail', array('alt' => '[pas d\'adresse]')) ?>
                    <?php endif; ?>
                    <?php echo link_to(image_tag('edit.png', array('alt' => '[modifier]')), 'membre/edit?id=' . $membre->getId()) ?>
                    <?php echo link_to(image_tag('details.png', array('alt' => '[détails]')), 'membre/show?id=' . $membre->getId()) ?>
                    <?php echo link_to(image_tag('delete.png', array('alt' => '[supprimer]')), 'membre/delete?id=' . $membre->getId(), array('method' => 'delete', 'confirm' => 'Etes vous sur ?')) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif ?>


<h2>Liste des membres</h2>

<?php include_partial('searchForm', array('form' => $searchForm)) ?>

<table class="tableauDonnees" summary="Members who would like to belong to the association">
    <thead>
        <tr class="enteteTableauDonnees">
            <th><?php echo link_to('Nom',    'membre/index?orderby=lastname') ?></th>
            <th><?php echo link_to('Prénom', 'membre/index?orderby=firstname') ?></th>
            <th><?php echo link_to('Pseudo', 'membre/index?orderby=username') ?></th>
            <th><?php echo link_to('Statut', 'membre/index?orderby=status_id') ?></th>
            <th><?php echo link_to('Ville',  'membre/index?orderby=city') ?></th>
            <th width="75px">Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($members->getResults() as $membre): ?>

    <?php if ($membre->hasToPayDue()): ?>
        <tr class="cotisationNonAjour">
    <?php else: ?>
        <tr>
    <?php endif; ?>

            <td><?php echo $membre->getLastname() ?></td>
            <td><?php echo $membre->getFirstname() ?></td>
            <td><?php echo $membre->getUsername() ?></td>
            <td><?php echo $membre->getStatus() ?></td>
            <td><?php echo $membre->getCity() ?></td>
            <td>
                <?php if ($membre->getEmail()) :?>
                    <?php echo mail_to($membre->getEmail(), image_tag('mail.png', array('alt' => '[e-mail]'))) ?>
                <?php else: ?>
                    <?php echo image_tag('no_mail', array('alt' => '[pas d\'adresse]')) ?>
                <?php endif; ?>
                <?php echo link_to(image_tag('edit.png', array('alt' => '[modifier]')), 'membre/edit?id=' . $membre->getId()) ?>
                <?php echo link_to(image_tag('details.png', array('alt' => '[détails]')), 'membre/show?id=' . $membre->getId()) ?>
                <?php echo link_to(image_tag('delete.png', array('alt' => '[supprimer]')), 'membre/delete?id=' . $membre->getId(), array('method' => 'delete', 'confirm' => 'Etes vous sur ?')) ?>
            </td>
        </tr>
        <?php endforeach; ?>
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


<div class="addNew"
    style="width: 194px; background-color: #EAEAEA; border: 3px solid #EAEAEA;">
        <?php echo link_to(image_tag('add', array('align'=>'top', 'alt'=>'[ajouter]')). ' Enregistrer un membre', 'membre/new') ?>
</div>


<?php include_partial('global/pager', array('pager' => $members, 'module' => 'membre', 'action' => 'index', 'params' => array('orderby' => $orderByColumn))) ?>
