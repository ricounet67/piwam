<?php use_helper('Number') ?>
<?php use_helper('Date') ?>

<h2>Gestion des types de cotisation</h2>

<table class="tableauDonnees">
  <thead>
    <tr class="enteteTableauDonnees">
      <th>Libellé</th>
      <th>Valide (ans)</th>
      <th>Montant</th>
      <th>Créé le</th>
      <th>Dernière édition</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($cotisation_type_list as $cotisation_type): ?>
    <tr>
      <td><?php echo $cotisation_type->getLibelle() ?></td>
      <td><?php echo $cotisation_type->getValide() ?></td>
      <td><?php echo format_currency($cotisation_type->getMontant(), '&euro;') ?></td>
      <td><?php echo format_date($cotisation_type->getCreatedAt()) ?></td>
      <td><?php echo format_date($cotisation_type->getUpdatedAt()) ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('cotisationtype/new') ?>">Nouveau type</a>
