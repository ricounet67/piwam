<?php use_helper('Date') ?>
<?php use_helper('Number') ?>

<h2>Gestion des dépenses</h2>

<table class="tableauDonnees">
    <thead>
        <tr class="enteteTableauDonnees">
            <th>Libellé</th>
            <th>Montant</th>
            <th>Compte</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($depense_list as $depense): ?>
        <tr>
            <td><?php echo $depense->getLibelle() ?></td>
            <td><?php echo format_currency($depense->getMontant()) ?></td>
            <td><?php echo $depense->getCompte() ?></td>
            <td><?php echo format_date($depense->getDate()) ?></td>
            <td>
                <a href="<?php echo url_for('depense/show?id=' . $depense->getId()) ?>"><?php echo image_tag('details.png', array('alt' => '[details]')) ?></a>
                <a href="<?php echo url_for('depense/edit?id=' . $depense->getId()) ?>"><?php echo image_tag('edit.png', array('alt' => '[éditer]')) ?></a>
                <?php echo link_to(image_tag('delete', array('alt' => '[supprimer]')),
          	  					 	'depense/delete?id=' . $depense->getId(),
          	   					 	array('method' => 'delete', 'confirm' => 'Ètes vous sûr ?'));
              	?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="addNew">
	<?php echo link_to(image_tag('add', 'align="top"'). ' Nouvelle dépense', 'depense/new') ?>
</div>
