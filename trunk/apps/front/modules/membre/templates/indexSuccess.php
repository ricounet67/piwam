
<h2>Liste des membres</h2>

<table class="tableauDonnees">
    <thead>
        <tr class="enteteTableauDonnees">
            <th><?php echo link_to('Nom', 'membre/list?sort=nom') ?></th>
            <th><?php echo link_to('Pr&eacute;nom', 'membre/list?sort=prenom') ?></th>
            <th><?php echo link_to('Statut', 'membre/list?sort=statut') ?></th>
            <th><?php echo link_to('Ville', 'membre/list?sort=ville') ?></th>
            <th style="width:70px">Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($membres as $membre): ?>
    <?php if ($membre->isAjourCotisation()): ?>
        <tr>
    <?php else: ?>
        <tr class="cotisationNonAjour">
    <?php endif; ?>
            <td><?php echo $membre->getNom() ?></td>
            <td><?php echo $membre->getPrenom() ?></td>
            <td><?php echo $membre->getStatut() ?></td>
            <td><?php echo $membre->getVille() ?></td>
            <td><?php echo link_to(image_tag('edit'), 'membre/edit?id='.$membre->getId()).' '.link_to(image_tag('details'), 'membre/show?id='.$membre->getId()).' '.link_to(image_tag('delete'), 'membre/delete?id='.$membre->getId(), 'confirm=&Ecirc;tes vous sur ?').' <a href="mailto:'.$membre->getEmail().'">'.image_tag('mail').'</a>' ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php echo link_to('Ajouter un membre', 'membre/create') ?>