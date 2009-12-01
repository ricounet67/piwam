<h2>Résultats de recherche</h2>

<?php include_partial('searchForm', array('form' => $searchForm)) ?>

<table class="datalist">
    <thead>
        <tr>
            <th><?php echo link_to('Nom',    'membre/index?orderby=lastname') ?></th>
            <th><?php echo link_to('Prénom', 'membre/index?orderby=firstname') ?></th>
            <th><?php echo link_to('Pseudo', 'membre/index?orderby=username') ?></th>
            <th><?php echo link_to('Statut', 'membre/index?orderby=status_id') ?></th>
            <th><?php echo link_to('Ville',  'membre/index?orderby=city') ?></th>
            <th width="75px">Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($membres as $member): ?>

    <?php if ($member->isAjourCotisation()): ?>
        <tr>
    <?php else: ?>
        <tr class="cotisationNonAjour">
    <?php endif; ?>

            <td><?php echo $member->getNom() ?></td>
            <td><?php echo $member->getPrenom() ?></td>
            <td><?php echo $member->getPseudo() ?></td>
            <td><?php echo $member->getStatut() ?></td>
            <td><?php echo $member->getVille() ?></td>
            <td>
                <?php if ($member->getEmail()) :?>
                    <?php echo mail_to($member->getEmail(), image_tag('mail.png', array('alt' => '[e-mail]'))) ?>
                <?php else: ?>
                    <?php echo image_tag('no_mail', array('alt' => '[pas d\'adresse]')) ?>
                <?php endif; ?>
                <?php echo link_to(image_tag('edit.png',    array('alt' => '[modifier]')), '@member_edit?id=' . $member->getId()) ?>
                <?php echo link_to(image_tag('details.png', array('alt' => '[détails]')), '@member_show?id=' . $member->getId()) ?>
                <?php echo link_to(image_tag('delete.png',  array('alt' => '[supprimer]')), '@member_delete?id=' . $member->getId(), array('method' => 'delete', 'confirm' => 'Etes vous sur ?')) ?>
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


<div class="addNew" style="width: 194px; background-color: #EAEAEA; border: 3px solid #EAEAEA;">
        <?php echo link_to('Retour à la liste complète', '@members_list') ?>
</div>