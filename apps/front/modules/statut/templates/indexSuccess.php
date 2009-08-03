<h2>Gestion des statuts</h2>

<table class="tableauDonnees">
  <thead>
    <tr class="enteteTableauDonnees">
      <th>Libellé</th>
      <th width="70px">Membres</th>
      <th width="80px">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($statut_list as $statut): ?>
    <tr>
      <td><?php echo $statut->getNom() ?></td>
      <td><?php echo $statut->countMembers() ?></td>
      <td>
      	<?php echo link_to(image_tag('details.png', array('alt' => '[détails]')), 'statut/show?id=' . $statut->getId()) ?>
        <?php echo link_to(image_tag('edit.png', array('alt' => '[éditer]')), 'statut/edit?id=' . $statut->getId()) ?>
        <?php echo link_to(image_tag('delete.png', array('alt' => '[supprimer]')), 'statut/delete?id=' . $statut->getId(), array('method' => 'delete', 'confirm' => 'Etes vous sur ?')) ?>
     </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<div class="addNew">
	<?php echo link_to(image_tag('add', 'align="top"'). ' Nouveau statut', 'statut/new') ?>
</div>
