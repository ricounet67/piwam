<?php use_helper('Date') ?>

<h2>Liste des activités</h2>

<table class="tableauDonnees">
  <thead>
    <tr class="enteteTableauDonnees">
      <th>Libellé</th>
      <th>Créée le</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($activite_list as $activite): ?>
    <tr>
      <td><?php echo $activite->getLibelle() ?></td>
      <td><?php echo format_date($activite->getCreatedAt()) ?></td>
      <td><a href="<?php echo url_for('activite/edit?id=' . $activite->getId()) ?>"><?php echo image_tag('edit.png', array('alt' => '[éditer]')) ?></a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<div class="addNew">
	<?php echo link_to(image_tag('add', 'align="top"'). ' Nouvelle activité', 'activite/new') ?>
</div>
