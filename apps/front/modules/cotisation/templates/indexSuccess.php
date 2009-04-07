<?php use_helper('Date') ?>

<h2>Liste des cotisations</h2>

<table class="tableauDonnees">
  <thead>
    <tr class="enteteTableauDonnees">
      <th>Compte</th>
      <th>Type</th>
      <th>Membre</th>
      <th>Versée le</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($cotisation_list as $cotisation): ?>
    <tr>
    	<td><?php echo $cotisation->getCompte() ?></td>
      	<td><?php echo $cotisation->getCotisationType() ?></td>
      	<td><?php echo $cotisation->getMembreRelatedByMembreId() ?></td>
      	<td><?php echo format_date($cotisation->getDate()) ?></td>
      	<td><a href="<?php echo url_for('cotisation/edit?id='.$cotisation->getId()) ?>"><?php echo image_tag('edit.png') ?></a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('cotisation/new') ?>">Enregistrer une cotisation</a>
