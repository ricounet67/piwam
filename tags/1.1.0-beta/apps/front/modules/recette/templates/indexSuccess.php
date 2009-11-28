<?php use_helper('Date') ?>
<?php use_helper('Number') ?>

<h2>Liste des recettes</h2>

<table class="tableauDonnees">
    <thead class="enteteTableauDonnees">
        <tr>
            <th>Libellé</th>
            <th>Montant</th>
            <th>Compte</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($recette_list as $recette): ?>
        <tr>
            <td><?php echo $recette->getLibelle() ?></td>
            <td><?php echo format_currency($recette->getMontant()) ?></td>
            <td><?php echo $recette->getCompte() ?></td>
            <td><?php echo format_date($recette->getDate()) ?></td>
            <td>
                <a href="<?php echo url_for('recette/show?id='.$recette->getId()) ?>"><?php echo image_tag('details.png') ?></a>
                <a href="<?php echo url_for('recette/edit?id='.$recette->getId()) ?>"><?php echo image_tag('edit.png') ?></a>
                <?php echo link_to(image_tag('delete'),
          	  					 	'recette/delete?id=' . $recette->getId(),
          	   					 	array('method' => 'delete', 'confirm' => 'Ètes vous sûr ?'));
              	?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="addNew">
	<?php echo link_to(image_tag('add', 'align="top"'). ' Nouvelle recette', 'recette/new') ?>
</div>