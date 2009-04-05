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
      <td><?php echo $cotisation->getCotisationTypeId() ?></td>
      <td><?php echo $cotisation->getMembreId() ?></td>
      <td><?php echo $cotisation->getDate() ?></td>
      <td><a href="<?php echo url_for('cotisation/show?id='.$cotisation->getId()) ?>"><?php echo image_tag('edit.png') ?></a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('cotisation/new') ?>">Enregistrer une cotisation</a>
