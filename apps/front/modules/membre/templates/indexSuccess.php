<h2>Liste des membres</h2>

<table class="tableauDonnees">
    <thead>
        <tr class="enteteTableauDonnees">
            <th><?php echo link_to('Nom', 		'membre/index?orderby=NOM') ?></th>
            <th><?php echo link_to('Prénom', 	'membre/index?orderby=PRENOM') ?></th>
            <th><?php echo link_to('Pseudo', 	'membre/index?orderby=PSEUDO') ?></th>
            <th><?php echo link_to('Statut', 	'membre/index?orderby=STATUT_ID') ?></th>
            <th><?php echo link_to('Ville', 	'membre/index?orderby=VILLE') ?></th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($membre_list as $membre): ?>
    <?php
    if ($membre->isAjourCotisation()) {
        echo '<tr>';
    }
    else {
        echo '<tr class="cotisationNonAjour">';
    }

    ?>
        <td><?php echo $membre->getNom() ?></td>
        <td><?php echo $membre->getPrenom() ?></td>
        <td><?php echo $membre->getPseudo() ?></td>
        <td><?php echo $membre->getStatut() ?></td>
        <td><?php echo $membre->getVille() ?></td>
        <td>
            <a href="mailto:<?php echo $membre->getEmail() ?>"><?php echo image_tag('mail.png') ?></a>
            <?php echo link_to(image_tag('edit.png'), 'membre/edit?id=' . $membre->getId()) ?>
            <?php echo link_to(image_tag('details.png'), 'membre/show?id=' . $membre->getId()) ?>
            <?php echo link_to(image_tag('delete.png'), 'membre/delete?id=' . $membre->getId(), array('method' => 'delete', 'confirm' => 'Etes vous sur ?')) ?>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<a href="<?php echo url_for('membre/new') ?>">Enregistrer un membre</a>
